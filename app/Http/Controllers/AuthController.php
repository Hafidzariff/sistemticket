<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (
            $request->username === env('ADMIN_USERNAME') &&
            $request->password === env('ADMIN_PASSWORD')
        ) {
            Session::put('is_admin', true);
            return redirect()->route('dashboard')->with('success', 'Selamat datang, Admin!');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function logout()
    {
        Session::forget('is_admin');
        return redirect()->route('admin.login')->with('success', 'Anda telah logout.');
    }
}
