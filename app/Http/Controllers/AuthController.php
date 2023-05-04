<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'stated'   => 'required',
        ]);
        
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return \redirect()->intended('/beranda');
        }

        return back()->with('error', 'Gagal Login');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        return redirect('/');
    }
}
