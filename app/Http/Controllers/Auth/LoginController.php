<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function register(){
        return view('auth.register');
    }
    public function forgot_password(){
        return view('auth.forgot-password');
    }
    public function reset_password(){
        return view('auth.reset-password');
    }
}
