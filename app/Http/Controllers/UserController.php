<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(User $model){
        parent::__construct($model);
    }

    public function viewRegistUser(){
        $title = 'User Registration';
        return view('user.userRegistrationForm', compact('title'));
    }
}
