<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Admin;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class PasswordResetTokenController extends BaseController
{
    protected $adminController;
    public function __construct(PasswordResetToken $model)
    {
        parent::__construct($model);
        $this->adminController = new AdminController(new Admin());
    }
    public function forgetPassword($role)
    {
        $data = [
            'title' => "Forget Password",
            'role' => $role
        ];
        return view('password-reset.enter-email', $data);
    }

    public function sendEmail(Request $request)
    {
        $role = $request->role;

        $validator = Validator::make($request->all(), $this->model->sendEmailValidationRules($role), $this->model->sendEmailValidationMessages());

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $token = Str::random(64);

        $data = [
            'token' => $token,
            'role' => $role
        ];

        Mail::to($request->email)->queue(new ResetPasswordEmail($data));

        $this->model::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        return redirect()->back()->with('success', 'Please check your email to proceed with password reset.');
    }

    public function resetPassword($role, $token)
    {
        $validator = Validator::make(['role' => $role, 'token' => $token], $this->model->resetPasswordValidationRules(), $this->model->resetPasswordValidationMessages());

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

    public function resetPasswordPost(Request $request)
    {
        $validator = Validator::make($request->all(), $this->model->resetPasswordPostValidationRules(), $this->model->resetPasswordPostValidationMessages());

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $passwordReset = $this->model::where('token', $request->token)->first();
        $email = $passwordReset->email;

        if ($request->role == 'admin') {
            $admin = $this->adminController->model::where('email', $email)->first();
            $newPassword = $request->password;

            if (Hash::check($newPassword, $admin->password)) {
                return redirect()->back()->with('error', 'New password must be different from the current password.');
            }

            $admin->password = Hash::make($newPassword);
            $admin->save();

            $passwordReset->delete();

            return redirect()->route('admin.login')->with('success', "Password successfully changed. Please try logging in again.");

        } else if ($request->role == 'user') {

        } else {
            return redirect()->route('admin.logins')->with('error', 'Something went wrong. Please send another request.');
        }
    }
}
