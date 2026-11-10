<?php

class RegisterController
{
public function register(Request $r)
{
    $data = $r->validate([
        'nama'     => 'required|string|max:100',
        'email'    => 'required|email|max:150',
        'no_hp'    => 'required|string|max:20',
        'password' => 'required|min:8|confirmed',
    ]);

    $existing = Pelanggan::where('email', $data['email'])->first();

    if ($existing) {
        // Email sudah ada di data lama (checkout/kasir) tanpa password:
        // JANGAN terima password dari form. Kirim link "atur password" ke emailnya.
        if ($existing->password === null) {
            Password::broker('pelanggan')->sendResetLink(['email' => $data['email']]);
        }
        // Pesan dibuat sama supaya orang lain tidak bisa menebak email yang terdaftar
        return back()->with('status', 'Jika email valid, instruksi sudah kami kirim ke email tersebut.');
    }

   $p = Pelanggan::create($data);              // password ter-hash otomatis
    event(new Registered($p));                  // mengirim email verifikasi

    // TIDAK login otomatis. Balik ke halaman register + popup
    return redirect()->route('pelanggan.register')->with('register_success', true);

    return redirect()->route('verification.notice');
}
}

