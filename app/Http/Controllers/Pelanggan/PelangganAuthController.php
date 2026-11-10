<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PelangganAuthController extends Controller
{
    public function showLogin()
    {
        return view('pelanggan.auth.login');
    }

    public function showRegister()
    {
        return view('pelanggan.auth.register');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $p = Pelanggan::where('email', $cred['email'])->first();

        if (! $p || ! $p->password || ! Hash::check($cred['password'], $p->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        if (! $p->hasVerifiedEmail()) {
            return back()
                ->withErrors(['email' => 'Akun belum diaktivasi. Silakan cek email Anda (termasuk folder spam).'])
                ->with('unverified_email', $p->email)
                ->onlyInput('email');
        }

        Auth::guard('pelanggan')->login($p, $request->boolean('remember'));
        $request->session()->regenerate();

        $p->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(route('pelanggan.dashboard'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|max:150',
            'no_hp'    => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $existing = Pelanggan::where('email', $data['email'])->first();

        if ($existing) {
            // Email lama (checkout/kasir) tanpa password: kirim link "atur password",
            // JANGAN terima password dari form.
            if ($existing->password === null) {
                Password::broker('pelanggan')->sendResetLink(['email' => $data['email']]);
            }

            // Respons dibuat sama supaya email terdaftar tidak bisa ditebak
            return redirect()->route('pelanggan.register')->with('register_success', true);
        }

        $p = Pelanggan::create($data);   // password ter-hash otomatis (cast 'hashed')
        event(new Registered($p));       // kirim email verifikasi

        // TIDAK login otomatis
        return redirect()->route('pelanggan.register')->with('register_success', true);
    }

    // Dipanggil saat user klik tombol di email (tidak butuh login)
    public function verify(Request $request, $id, $hash)
    {
        $p = Pelanggan::findOrFail($id);

        if (! hash_equals(sha1($p->getEmailForVerification()), (string) $hash)) {
            abort(403);
        }

        if (! $p->hasVerifiedEmail()) {
            $p->markEmailAsVerified();
            event(new Verified($p));
        }

        return redirect()->route('pelanggan.login')->with('verified', true);
    }

    // Kirim ulang email aktivasi (link berlaku 60 menit)
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $p = Pelanggan::where('email', $request->email)->first();

        if ($p && $p->password && ! $p->hasVerifiedEmail()) {
            $p->sendEmailVerificationNotification();
        }

        // Pesan sama supaya email tidak bisa ditebak
        return back()->with('resent', true);
    }

    
// Menampilkan halaman lupa password
public function showForgotPassword()
{
    return view('pelanggan.auth.forgot-password');
}

// Mengirim tautan reset password ke email pelanggan
public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $status = Password::broker('pelanggan')->sendResetLink([
        'email' => $request->email,
    ]);

    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('status', __($status));
    }

    return back()
        ->withErrors(['email' => __($status)])
        ->onlyInput('email');
}

// Menampilkan halaman membuat password baru
public function showResetPassword(Request $request, $token)
{
    return view('pelanggan.auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
}

// Menyimpan password baru
public function resetPassword(Request $request)
{
    $credentials = $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $status = Password::broker('pelanggan')->reset(
        $credentials,
        function ($pelanggan, $password) {
            $pelanggan->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return redirect()
            ->route('pelanggan.login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    return back()
        ->withErrors(['email' => __($status)])
        ->withInput($request->only('email'));
}


    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pelanggan.dashboard');
    }
}