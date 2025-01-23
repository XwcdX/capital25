<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PasswordResetToken extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['email', 'token'];

    public static function sendEmailValidationRules($role)
    {
        return [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($role) {
                    if ($role == 'team') {
                        $exists = DB::table('teams')->where('email', $value)->exists();
                    } else if ($role == 'admin') {
                        $exists = DB::table('admins')->where('email', $value)->exists();
                    } else {
                        return redirect()->back()->with('error', "Something went wrong. Please go back and try again.");
                    }

                    if (!$exists) {
                        $fail("The $attribute field is invalid.");
                    }
                },
            ],
            'role' => [
                'required',
                'string',
                'in:team,admin'
            ]
        ];
    }

    public static function sendEmailValidationMessages()
    {
        return [
            'email.required' => 'We need to know your email address!',
            'email.email' => 'Input must be email!',
            'role.required' => 'Something went wrong. Please open the page through email again.',
            'role.string' => 'Something went wrong. Please open the page through email again.',
            'role.in' => 'Something went wrong. Please open the page through email again.'
        ];
    }

    public static function resetPasswordValidationRules(){
        return [
            'token' => 'required|string|exists:password_reset_tokens,token',
            'role' => 'required|string|in:team,admin'
        ];
    }

    public static function resetPasswordValidationMessages(){
        return [
            'token.exists' => 'Session has expired. Please send a new Reset Password request.',
            'token.required' => 'Token missing. Please open the page through email again.',
            'token.string' => 'Something went wrong. Please open the page through email again.',
            'role.required' => 'Something went wrong.Please open the page through email again.',
            'role.string' => 'Something went wrong. Please open the page through email again.',
            'role.in' => 'Something went wrong. Please open the page through email again.'
        ];
    }

    public static function resetPasswordPostValidationRules(){
        return [
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;"\'<>,.?~\\/-])[A-Za-z\d!@#$%^&*()_+{}\[\]:;"\'<>,.?~\\/-]{8,}$/'
            ],
            'token' => 'required|string|exists:password_reset_tokens,token',
            'role' => 'required|string|in:team,admin'
        ];
    }

    public static function resetPasswordPostValidationMessages(){
        return [
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
    }
}
