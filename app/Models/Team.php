<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Team extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'school',
        'domicile',
        'password',
        'proof_of_payment',
        'payment_uploaded_at',
        'profile_image',
        'coin',
        'green_points',
        'valid',
        'feedback'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_uploaded_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:16|unique:teams,name',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:teams,email',
            'school' => 'required|string|max:255',
            'domicile' => 'required|string|max:255',
            'proof_of_payment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'profile_image' => 'nullable|string',
            'coin' => 'required|integer|min:0',
            'green_points' => 'required|integer|min:0',
            'valid' => 'required|integer|in:0,1,2',
            'feedback' => 'nullable|string',
        ];
    }

    public static function validationMessages()
    {
        return [
            'name.required' => 'Team name is required',
            'name.string' => 'Team name must be a string',
            'name.max' => 'Team name must not exceed 16 characters',
            'name.unique' => 'Team name has already been taken',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email has already been taken',

            'school.required' => 'School name is required',
            'school.string' => 'School name must be a string',
            'school.max' => 'School name must not exceed 255 characters',

            'domicile.required' => 'Domicile is required',
            'domicile.string' => 'Domicile must be a string',
            'domicile.max' => 'Domicile must not exceed 255 characters',

            'proof_of_payment.file' => 'Proof of payment must be a valid file',
            'proof_of_payment.mimes' => 'Proof of payment must be a JPG, JPEG, PNG, or PDF file',
            'proof_of_payment.max' => 'Proof of payment must not exceed 2MB',

            'coin.required' => 'Coin value is required',
            'coin.integer' => 'Coin must be an integer',
            'coin.min' => 'Coin must be at least 0',

            'green_points.required' => 'Green points value is required',
            'green_points.integer' => 'Green points must be an integer',
            'green_points.min' => 'Green points must be at least 0',

            'valid.required' => 'Validation status is required',
            'valid.integer' => 'Validation status must be an integer',
            'valid.in' => 'Validation status must be 0 (Pending), 1 (Validated), or 2 (Declined)',

            'feedback.string' => 'Feedback must be a string',
        ];
    }

    public function relations()
    {
        return ['rallies', 'users'];
    }

    public function rallies()
    {
        return $this->belongsToMany(Rally::class, 'rally_histories')
            ->withPivot('qr_expired_at', 'scanned_at', 'rank', 'point')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
