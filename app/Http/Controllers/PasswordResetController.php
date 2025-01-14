<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class PasswordResetController extends Controller
{
    public function forgetPassword($role){
        $data = [
            'title' => "Forget Password",
            'role' => $role
        ];
        return view('password-reset.enter-email', $data);
    }

    public function sendEmail(Request $request){
        
        $role = $request->role;

        $rules = [
            'email' => ['required',
                        'email',
                        function ($attribute, $value, $fail) use ($role) {
                            if($role == 'peserta'){
                                $exists = DB::table('kelompoks')->where('email', $value)->exists();
                            }else if($role == 'admin'){
                                $exists = DB::table('admins')->where('email', $value)->exists();
                            }else{
                                return redirect()->back()->with('error', "Something went wrong. Please go back and try again.");
                            }
                
                            if (!$exists) {
                                $fail('No accounts exist with this email address.');
                            }
                        },
                    ],
            'role' => ['required',
                        'string',
                        'in:peserta,admin'
                    ]
        ];

        $messages = [
            'email.required' => 'We need to know your email address!',
            'email.email' => 'Input must be email!',
            'role.required' => 'Something went wrong. Please open the page through email again.',
            'role.string' => 'Something went wrong. Please open the page through email again.',
            'role.in' => 'Something went wrong. Please open the page through email again.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $token = Str::random(64);

        $data=[
            'token' => $token,
            'role' => $role
        ];

        Mail::send("admin.mail.reset-password-email", $data, function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password CAPITAL");
        });
        

        PasswordResetToken::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        return redirect()->back()->with('success', 'Please check your email to proceed with password reset.');
        
    }

    public function resetPassword($role, $token){
        $rules = [
            'token' => 'required|string|exists:password_resets,token',
            'role' => 'required|string|in:peserta,admin'
        ];

        $messages = [
            'token.exists' => 'Session has expired. Please send a new Reset Password request.',
            'token.required' => 'Token missing. Please open the page through email again.',
            'token.string' => 'Something went wrong. Please open the page through email again.',
            'role.required' => 'Something went wrong.Please open the page through email again.',
            'role.string' => 'Something went wrong. Please open the page through email again.',
            'role.in' => 'Something went wrong. Please open the page through email again.'
        ];

        $validator = Validator::make(['role'=>$role, 'token'=>$token], $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('forget.password', $role)->with('error', $validator->errors()->first());
        }

        $data = [
            'token' => $token,
            'role' => $role,
            'title' => 'Reset Password'
        ];
    
        return view('password-reset.reset-password', $data);
    }

    public function resetPasswordPost(Request $request){

        $rules = [
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',                    
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;"\'<>,.?~\\/-])[A-Za-z\d!@#$%^&*()_+{}\[\]:;"\'<>,.?~\\/-]{8,}$/'
            ],
            'token' => 'required|string|exists:password_resets,token',
            'role' => 'required|string|in:peserta,admin'
        ];

        $messages = [
            'password.required' => 'Please fill in the blanks!',
            'password.string' => 'Password must be plain text!',
            'password.confirmed' => "Passwords don't match, please try again.",
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.min' => 'Password must be at least 8 characters long.',
            'token.required' => 'Token missing. Please open the page through email again.',
            'token.string' => 'Something went wrong. Please open the page through email again.',
            'token.exists' => 'Session has expired. Please send a new Reset Password request.',
            'role.required' => 'Something went wrong. Please open the page through email again.',
            'role.string' => 'Something went wrong. Please open the page through email again.',
            'role.in' => 'Something went wrong. Please open the page through email again.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $passwordReset = PasswordResetToken::where('token', $request->token)->first();
        $email = $passwordReset->email;
        
        if($request->role == 'admin'){
            $admin = Admin::where('email', $email)->first();
            $newPassword = $request->password;

            if (Hash::check($newPassword, $admin->password)) {
                return redirect()->back()->with('error', 'New password must be different from the current password.');
            }

            $admin->password = Hash::make($newPassword);
            $admin->save();

            $passwordReset->delete();

            return redirect()->route('admin.login')->with('success', "Password successfully changed. Please try logging in again.");

        }else if($request->role == 'peserta'){

        }else{
            return redirect()->route('admin.logins')->with('error', 'Something went wrong. Please send another request.');
        }
    }
}
