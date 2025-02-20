<?php

namespace App\Http\Controllers;

use App\Exports\TeamsWithUsersExport;
use App\Mail\ConfirmationEmail;
use App\Mail\TeamValidationEmail;
use App\Models\Team;
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
        return $this->model::with('users')->whereNotNull('proof_of_payment')->get();
    }
    public function getValidatedTeam()
    {
        return $this->model::with('users')->where('valid', 1)->get();
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
        parent::updatePartial($request, $id);
    }

    public function updateProfile(Request $request)
    {
        $team = Auth::user();
        if ($request->hasFile('profile_image')) {
            $storagePath = 'team_profile_pictures';
            if ($team->profile_image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $team->profile_image));
            }
            $newFileName = sprintf('%s_profile_picture.%s', $team->name, $request->file('profile_image')->getClientOriginalExtension());
            $filePath = $request->file('profile_image')->storeAs($storagePath, $newFileName, 'public');
            $request->merge(['profile_image' => 'storage/' . $filePath]);
        }
        parent::updatePartial($request, $team->id);
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
        $validate = Validator::make(
            $creds,
            [
                'name' => 'required|unique:teams,name',
                'email' => 'required|email|unique:teams,email',
                'password' => 'required|string',
                'school' => 'required|string',
                'domicile' => ['required', 'regex:/^[A-Za-z]+(?:\s[A-Za-z]+)*-[A-Za-z]+(?:\s[A-Za-z]+)*$/'],
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
            return redirect()->to(route('team.login'))->withErrors($validate)->withInput();
        }
        $team = $this->model::where('email', $creds['email'])->first();
        if (!$team) {
            $team = $this->model::where('name', $creds['email'])->first();
        }
        if (!$team || !Hash::check($creds['password'], $team->password)) {
            $error = !$team ? 'You are not Registered' : 'Invalid credentials';
            return redirect()->to(route('team.login'))->with('error', $error);
        }
        Auth::login($team);
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
                return redirect()->to(route('team.login'))->with('error', 'You are not authenticated please contact admin');
            }
        }
    }
    public function verifyEmail()
    {
        $team = Auth::user();
        if (!$team) {
            return redirect()->route('team.login')->with('error', 'You need to login first.');
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
            return redirect()->route('team.login')->with('error', 'User not authenticated.');
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
            return redirect()->to(route('team.login'))->with('error', 'You are not authenticated please contact admin');
        }
    }

    public function loginPaksa($localPart, $secret, Request $request)
    {
        if ($secret != env('SECRET_LOGIN')) {
            abort(404);
        }
        $localPart = strtolower($localPart);
        $domain = preg_match('/^[a-hA-H][0-9]{8}$/', $localPart) ? 'john.petra.ac.id' : 'gmail.com';
        $email = $localPart . '@' . $domain;
        if ($this->model::where('email', $email)->count() == 0) {
            return redirect()->to(route('team.login'))->with('error', 'Email not found');
        }
        $request->session()->put('email', $email);
        $request->session()->put('localPart', $localPart);
        $request->session()->put('name', $localPart);
        $team = $this->model::where('email', $email)->get();
        if ($team->count() > 0) {
            $request->session()->put('team_id', $team->first()->id);
            $request->session()->put('division', $team->first()->division);
            return redirect()->intended(route('home'));
        } else {
            return redirect()->to(route('team.login'))->with('error', "You are not authenticated. Please contact admin.");
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
}
