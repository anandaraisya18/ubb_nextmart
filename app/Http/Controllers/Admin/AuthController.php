<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

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

    public function showForgotPassword()
{
    return view('admin.auth.forgot-password');
}

public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => ['required', 'email', 'max:150'],
    ], [
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()->withErrors([
            'email' => 'Email tidak ditemukan.',
        ])->onlyInput('email');
    }

    $token = Str::random(64);

    DB::table('admin_password_reset_tokens')->updateOrInsert(
        ['email' => $admin->email],
        [
            'token' => Hash::make($token),
            'created_at' => now(),
        ]
    );

    $resetUrl = route('admin.password.reset', [
        'token' => $token,
        'email' => $admin->email,
    ]);

    try {
        \Illuminate\Support\Facades\Mail::raw(
            "Halo {$admin->nama},\n\n"
            . "Kami menerima permintaan untuk mengatur ulang password akun Admin UBB Nextmart.\n\n"
            . "Silakan buka tautan berikut untuk membuat password baru:\n"
            . $resetUrl . "\n\n"
            . "Tautan ini hanya berlaku selama 60 menit. "
            . "Jika kamu tidak meminta pengaturan ulang password, abaikan email ini.",
            function ($message) use ($admin) {
                $message->to($admin->email)
                    ->subject('Reset Password Admin - UBB Nextmart');
            }
        );
    } catch (\Throwable $e) {
        DB::table('admin_password_reset_tokens')
            ->where('email', $admin->email)
            ->delete();

        return back()->withErrors([
            'email' => 'Email reset password gagal dikirim. Silakan coba lagi.',
        ])->onlyInput('email');
    }

    return back()->with(
        'status',
        'Tautan reset password berhasil dikirim ke email admin.'
    );
}

public function showResetPassword(Request $request, $token)
{
    $email = $request->query('email');

    $reset = DB::table('admin_password_reset_tokens')
        ->where('email', $email)
        ->first();

    if (
        !$reset ||
        !Hash::check($token, $reset->token) ||
        !$reset->created_at ||
        now()->diffInMinutes($reset->created_at) > 60
    ) {
        return redirect()->route('admin.password.request')
            ->withErrors([
                'email' => 'Tautan reset password tidak valid atau sudah kedaluwarsa.',
            ]);
    }

    return view('admin.auth.reset-password', [
        'token' => $token,
        'email' => $email,
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => ['required', 'email', 'max:150'],
        'token' => ['required', 'string'],
        'password' => [
            'required',
            'confirmed',
            PasswordRule::min(8),
        ],
    ], [
        'password.required' => 'Password baru wajib diisi.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        'password.min' => 'Password minimal 8 karakter.',
    ]);

    $reset = DB::table('admin_password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (
        !$reset ||
        !Hash::check($request->token, $reset->token) ||
        !$reset->created_at ||
        \Carbon\Carbon::parse($reset->created_at)->addMinutes(60)->isPast()
    ) {
        return back()->withErrors([
            'email' => 'Tautan reset password tidak valid atau sudah kedaluwarsa.',
        ]);
    }

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
    return back()->with(
        'status',
        'Jika email terdaftar, tautan reset password akan dikirim.'
    );
}

    $admin->password = Hash::make($request->password);
    $admin->save();

    DB::table('admin_password_reset_tokens')
        ->where('email', $admin->email)
        ->delete();

    return redirect()->route('admin.login')
        ->with('status', 'Password berhasil diubah. Silakan login menggunakan password baru.');
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