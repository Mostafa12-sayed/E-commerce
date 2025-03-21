<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function view()
    {
        // dd("doe");
        return view('Auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed'],
            'phone' => 'nullable|numeric|unique:users|digits_between:10,12',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        // dd($request->all());
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/users', 'public');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'image' => $path ?? null,
        ]);

        Auth::login($user);
        flash('You have registered successfully!');
        return redirect('/home');

        return redirect('/login');
    }
}
