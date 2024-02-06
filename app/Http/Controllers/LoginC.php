<?php
// LoginC.php
// LoginC.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginC extends Controller
{
    public function login()
    {
        $subtitle = 'Login';
        return view('login', compact('subtitle'));
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect('/login')->with('error', 'Incorrect username or password.');
        }

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}


