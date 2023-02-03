<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signIn(Request $request) {
        if(Auth::check()) {return redirect('signin')->withErrors('User already signed in');}
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended('/')->withSucess('Signed in');
        }
        return redirect('/signin')->withErrors('Invalid credentials!');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();

        return redirect('/signin');
    }
}
