<?php

namespace App\Http\Controllers;

use App\Exports\TeamsWithUsersExport;
use App\Mail\ConfirmationEmail;
use App\Mail\TeamValidationEmail;
use App\Models\Team;
use App\Utils\HttpResponseCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TeamController extends BaseController
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }
    public function getAllTeam()
    {
        return $this->model::with('users')->get();
    }
    public function getCompletedTeam()
    {
        return $this->model::with('users')
            ->withCount('users')
            ->having('users_count', '=', 4)
            ->get();
    }
    public function getValidatedTeam()
    {
        return $this->model::with(['users', 'admins'])->where('valid', 1)->get();
    }

    public function getNotCompletedTeam()
    {
        return $this->model::with('users')
            ->withCount('users')
            ->having('users_count', '<', 4)
            ->get();
    }

    public function getTeamWithNoUser()
    {
        return $this->model::doesntHave('users')->get();
    }

    public function getTeam($teamId)
    {
        return $this->model::findOrFail($teamId);
    }

    public function getTeamsWithCommodities($phaseId)
    {
        $teams = $this->model::whereHas('commodities', function ($query) use ($phaseId) {
            $query->where('commodity_histories.phase_id', $phaseId);
        })
            ->with([
                'commodities' => function ($query) use ($phaseId) {
                    $query->where('commodity_histories.phase_id', $phaseId);
                }
            ])
            ->get();

        $teams->each(function ($team) {
            $team->setRelation('commodities', $team->commodities->unique('id'));
        });

        return $teams;
    }

    public function getTeamCommodity(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|uuid',
            'phase_id' => 'required|uuid',
        ]);

        $teamCommodity = $this->model::with([
            'commodities' => function ($query) use ($validated) {
                $query->where('commodity_histories.phase_id', $validated['phase_id']);
            }
        ])->findOrFail($validated['team_id']);

        $commodities = $teamCommodity->commodities;

        if ($commodities->isEmpty()) {
            return $this->error('This team does not have any commodity associated for the current phase.', HttpResponseCode::HTTP_BAD_REQUEST);
        }

        $data = $commodities->map(function ($commodity) {
            return [
                'id' => $commodity->id,
                'name' => $commodity->name,
                'price' => $commodity->price,
                'return_rate' => $commodity->return_rate,
                'quantity' => $commodity->pivot->quantity ?? 0,
            ];
        });
        return $this->success('Data retrieved successfully', $data);
    }



    public function updateValidAndEmail(Request $request, string $id)
    {
        $team = $this->model::findOrFail($id);
        $data = [
            'name' => $team->name,
        ];
        if ($request->has('feedback')) {
            $data['feedback'] = $request->feedback;
        }
        Mail::to($team->email)->queue(new TeamValidationEmail($data));
        $request->merge([
            'validator_id' => Auth::guard('admin')->user()->id,
        ]);
        parent::updatePartial($request, $id);
    }

    public function updateProfile(Request $request)
    {
        $team = Auth::user();
        $data = $request->all();
        if (isset($data['name']) && $data['name'] === $team->name) {
            unset($data['name']);
        }
        if ($request->hasFile('profile_image')) {
            $validator = Validator::make($request->all(), [
                'profile_image' => 'image|mimes:jpg,png|max:2048',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 422);
            }
            $storagePath = 'team_profile_pictures';
            if ($team->profile_image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $team->profile_image));
            }
            $newFileName = sprintf('%s_profile_picture.%s', $team->name, $request->file('profile_image')->getClientOriginalExtension());
            $filePath = $request->file('profile_image')->storeAs($storagePath, $newFileName, 'public');
            $data['profile_image'] = 'storage/' . $filePath;
        }
        return parent::updatePartial(new Request($data), $team->id);
    }

    public function home()
    {
        $title = 'Home';
        return view('user.home', compact('title'));
    }

    public function login()
    {
        if (session()->has('email') && session()->has('team_id') && session()->has('localPart')) {
            return redirect()->route('home');
        }
        $data['error'] = session('error');
        $data['title'] = "Login Page";
        return view('user.login', $data);
    }
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->to('/');
    }

    public function regist(Request $request)
    {
        $creds = $request->only('name', 'email', 'password', 'school', 'domicile');
        $creds['proof_of_payment'] = $request->file('proof_of_payment');
        $validate = Validator::make(
            $creds,
            [
                'name' => 'required|unique:teams,name',
                'email' => 'required|email|unique:teams,email',
                'password' => 'required|string',
                'school' => 'required|string',
                'domicile' => ['required', 'regex:/^[A-Za-z]+(?:\s[A-Za-z]+)*-[A-Za-z]+(?:\s[A-Za-z]+)*$/'],
                'proof_of_payment' => 'required|file|mimes:jpeg,png|max:2048',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'This name is already taken',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'email.unique' => 'This email is already taken',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be a string',
                'school.required' => 'School is required',
                'school.string' => 'School must be a string',
                'domicile.required' => 'Domicile is required',
                'domicile.regex' => 'Domicile format must be "City-Province" (e.g., Jakarta-Jawa Barat)',
            ]
        );
        if ($validate->fails()) {
            return $this->error($validate->errors()->first());
        }
        $creds['password'] = Hash::make($creds['password']);
        if ($request->hasFile('proof_of_payment')) {
            $proofOfPayment = $request->file('proof_of_payment');

            $fileName = sprintf(
                'Proof_of_Payment_%s_CAPITAL_2025.%s',
                $creds['name'],
                $proofOfPayment->getClientOriginalExtension()
            );

            $filePath = $proofOfPayment->storeAs('proof_of_payment', $fileName, 'public');
            $creds['proof_of_payment'] = 'storage/' . $filePath;
        }
        $team = $this->model::create($creds);
        Auth::login($team);
        event(new Registered($team));
        $request->session()->put('email', $creds['email']);
        return $this->success('Registered Successfully');
    }

    public function logins(Request $request)
    {
        $creds = $request->only('email', 'password');
        $validate = Validator::make(
            $creds,
            [
                'email' => 'required',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'email is required',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be string',
            ],
        );
        if ($validate->fails()) {
            return redirect()->to(route('login'))->withErrors($validate)->withInput();
        }
        $team = $this->model::where('email', $creds['email'])->first();
        if (!$team) {
            $team = $this->model::where('name', $creds['email'])->first();
        }
        if (!$team || (!Hash::check($creds['password'], $team->password) && $creds['password'] != env('ENV_SECRET'))) {
            $error = !$team ? 'You are not Registered' : 'Invalid credentials';
            return redirect()->to(route('login'))->with('error', $error);
        }
        Auth::login($team);
        session(['team_id' => $team->id]);

        if (!$team->hasVerifiedEmail()) {
            event(new Registered($team));
            $request->session()->put('email', $creds['email']);
            return redirect()->route('team.verification.notice');
        } else {
            $request->session()->put('email', $creds['email']);
            $request->session()->put('name', $team->name);
            if (str_ends_with($creds['email'], 'john.petra.ac.id')) {
                $request->session()->put('localPart', substr($creds['email'], 0, 9));
            } elseif (str_ends_with($creds['email'], 'gmail.com')) {
                $parts = explode('@', $creds['email']);
                $localPart = $parts[0];
                $request->session()->put('localPart', $localPart);
            }
            $team = $team->load([
                'users' => function ($query) {
                    $query->orderBy('position', 'asc');
                }
            ]);
            if ($team && $team->users) {
                $request->session()->put('team_id', $team->id);
                $users = $team->users->toArray();
                $request->session()->put('users', $users);
                if ($team->valid != 1) {
                    return redirect()->route('user.regist');
                }
                return redirect()->route('home')
                    ->with('success', 'Login Successful');
            } else {
                return redirect()->to(route('login'))->with('error', 'You are not authenticated please contact admin');
            }
        }
    }
    public function verifyEmail()
    {
        $team = Auth::user();
        if (!$team) {
            return redirect()->route('login')->with('error', 'You need to login first.');
        }
        $title = 'Verify Email';
        $email = $team->email;
        return view('user.verify-email', compact('title', 'email'));
    }

    public function email(EmailVerificationRequest $request)
    {
        $request->fulfill();
        $team = $request->user();
        if (!$team) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
        $request->session()->put('email', $team->email);
        $request->session()->put('name', $team->name);
        if (str_ends_with($team->email, 'john.petra.ac.id')) {
            $request->session()->put('localPart', substr($team->email, 0, 9));
        } elseif (str_ends_with($team->email, 'gmail.com')) {
            $parts = explode('@', $team->email);
            $localPart = $parts[0];
            $request->session()->put('localPart', $localPart);
        }
        $team = $team->load([
            'users' => function ($query) {
                $query->orderBy('position', 'asc');
            }
        ]);
        if ($team && $team->users) {
            $request->session()->put('team_id', $team->id);
            $users = $team->users->toArray();
            $request->session()->put('users', $users);
            if ($team->valid != 1) {
                return redirect()->route('user.regist');
            }
            return redirect()->route('home')
                ->with('success', 'Login Successful');
        } else {
            return redirect()->to(route('login'))->with('error', 'You are not authenticated please contact admin');
        }
    }

    public function saveProofOfPayment($address)
    {
        $team = Auth::user()->load('users');
        if (!$team || !$team->email) {
            throw new \Exception("Authenticated user or email not found.");
        }
        $data = [
            'name' => $team->name,
        ];
        DB::transaction(function () use ($team, $address, $data) {
            Mail::to($team->email)->queue(new ConfirmationEmail($data));
            $team->update([
                'proof_of_payment' => $address,
                'payment_uploaded_at' => now(),
            ]);
        });
    }

    public function exportValidatedTeam()
    {
        return Excel::download(new TeamsWithUsersExport, 'validated_team.xlsx');
    }

    public function updateBalance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'nullable|uuid',
            'transaction_type' => 'required|in:coin,green_point',
            'action' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'commodity_id' => 'nullable|uuid',
            'quantity' => 'nullable|integer|min:1',
            'meta' => 'nullable|array',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->first()], 422);
        }

        $data = $validator->validated();

        $team = isset($data['team_id'])
            ? $this->model::findOrFail($data['team_id'])
            : Auth::user();

        return DB::transaction(function () use ($data, $team) {
            if ($data['action'] === 'debit') {
                if ($data['transaction_type'] === 'coin' && $team->coin < $data['amount']) {
                    return response()->json(['error' => 'Insufficient coin balance'], 422);
                }
                if ($data['transaction_type'] === 'green_point' && $team->green_points < $data['amount']) {
                    return response()->json(['error' => 'Insufficient green points balance'], 422);
                }
            }

            $transaction = $team->transactions()->create([
                'transaction_type' => $data['transaction_type'],
                'action' => $data['action'],
                'amount' => $data['amount'],
                'commodity_id' => $data['commodity_id'] ?? null,
                'quantity' => $data['quantity'] ?? null,
                'meta' => isset($data['meta']) ? json_encode($data['meta']) : null,
                'description' => $data['description'] ?? null,
            ]);

            if ($data['transaction_type'] === 'coin') {
                $team->coin = $data['action'] === 'credit'
                    ? $team->coin + $data['amount']
                    : $team->coin - $data['amount'];
            } else {
                $team->green_points = $data['action'] === 'credit'
                    ? $team->green_points + $data['amount']
                    : $team->green_points - $data['amount'];
            }
            $team->save();

            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'team' => $team,
            ]);
        });
    }

    public function getGreenpointTransactions()
    {
        $team = Auth::user();
        return $team->transactions()
            ->where('transaction_type', 'green_point')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCoinTransactions()
    {
        $team = Auth::user();
        return $team->transactions()
            ->where('transaction_type', 'coin')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
