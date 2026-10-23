<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = trim($request->input('username'));

        $admin = Admin::where('email', $identifier)
            ->orWhere('nama', $identifier)
            ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()
                ->withErrors([
                    'username' => 'Username/email atau password salah.',
                ])
                ->onlyInput('username');
        }

        // Regenerasi sesi setelah login berhasil.
        $request->session()->regenerate();

        // Simpan identitas admin yang login.
        $request->session()->put('admin_id', $admin->id_admin);
        $request->session()->put('admin_nama', $admin->nama);
        $request->session()->put('admin_email', $admin->email);
        $request->session()->put('admin_group_id', $admin->id_group);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'admin_id',
            'admin_nama',
            'admin_email',
            'admin_group_id',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Berhasil logout.');
    }
}