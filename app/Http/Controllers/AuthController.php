<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function view()
    {
        return view('Auth.login');
    }
    public function login(LoginRequest $request)
    {
        $credentials = ['email' => $request->input('login'), 'password' => $request->input('password')];
        $remember = $request->input('remember') ? true : false;
        if (!auth()->attempt($credentials, $remember)) return $this->invalid($request);
        flash('Welcome back!');
        return to_route('home');
    }
    private function invalid($request)
    {
        flash()->error('Invalid Credentials!');
        return back();
    }
    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            request()->session()->invalidate();
        }
        return to_route('login');
    }
    protected function redirectTo()
    {
        return to_route('home');
    }
}
