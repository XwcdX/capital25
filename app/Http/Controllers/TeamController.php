<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeamController extends BaseController
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function home()
    {
        $title = 'Home';
        return view('welcome', compact('title'));
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
                'domicile' => 'required|string',
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
                'domicile.string' => 'Domicile must be a string',
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
                'email' => 'required|exists:teams,email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'email is required',
                'email.exists' => 'Email not found',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be string',
            ],
        );
        foreach ($validate->errors()->all() as $error) {
            return redirect()->to(route('team.login'))->with('error', $error);
        }
        $team = $this->model::where('email', $creds['email'])->first();
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
                if ($team->users->count() < 4) {
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
        $email = session('email');
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
            if ($team->users->count() < 4) {
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
}
