<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('superadmin')->check()) {
            return redirect()->route('superadmin.dashboard');
        }

        return view('superadmin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = trim($request->input('username'));

        // Izinkan login menggunakan nama atau email.
        $column = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'name';

        $credentials = [
            $column => $identifier,
            'password' => $request->input('password'),
        ];

        $remember = $request->boolean('remember');

        if (! Auth::guard('superadmin')->attempt(
            $credentials,
            $remember
        )) {
            return back()
                ->withErrors([
                    'username' => 'Username/email atau password salah.',
                ])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->intended(
            route('superadmin.dashboard')
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('superadmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('superadmin.login')
            ->with('success', 'Berhasil logout Superadmin.');
    }
}