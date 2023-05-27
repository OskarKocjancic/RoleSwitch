<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login()
    {
        return view('login');
    }
    function registration()
    {
        return view('registration');
    }
    function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'))->with("success", "Login successful!");
        } else
            return redirect(route('login'))->with("error", "Login failed!");
    }
    function registrationPost(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);
        $data['username'] = $request->username;
        $data['password'] = Hash::make($request->password);
        $data['api_key'] = 0;
        $user = User::create($data);



        if (!$user) {
            return redirect(route('registration'))->with("error", "Registration failed!");
        } else
            return redirect(route('login'))->with("success", "Registration successful!");
    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}