
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Pelanggan - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#001840]">

    <div class="grid min-h-screen grid-cols-1 md:grid-cols-2">

        <!-- SISI KIRI -->
        <div class="flex flex-col justify-between bg-[#001840] p-8 text-white md:p-14">

            <a href="{{ route('pelanggan.dashboard') }}" class="flex w-fit items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white">
                    <img
                        src="{{ asset('images/logoubb.png') }}"
                        alt="Logo UBB"
                        class="h-8 w-8 object-contain"
                    >
                </div>

                <span class="text-lg font-bold">UBB Nextmart</span>
            </a>

            <div class="my-12">
                <h2 class="text-3xl font-bold leading-tight md:text-4xl">
                    Bergabung dengan
                    <span class="text-[#F5C400]">UBB Nextmart</span>
                </h2>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/60">
                    Buat akun untuk menikmati kemudahan berbelanja,
                    memesan makanan, dan menggunakan layanan printing.
                </p>
            </div>

            <p class="text-xs text-white/40">
                &copy; {{ date('Y') }} UBB Nextmart
            </p>

        </div>


        <!-- SISI KANAN -->
        <div class="flex items-center justify-center bg-[#102A71] p-6 md:p-10">

            <div class="w-full max-w-md rounded-2xl border border-[#F5C400]/20 bg-[#001840] p-7 shadow-2xl md:p-9">

                <h1 class="text-2xl font-bold text-white">
                    Daftar Pelanggan
                </h1>

                <p class="mb-7 mt-2 text-sm text-white/60">
                    Lengkapi data untuk membuat akun baru.
                </p>

                <!-- Pesan Error -->
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-400/30 bg-red-400/10 p-3 text-sm text-red-300">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Form Register -->
                <form action="{{ route('pelanggan.register.process') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="mb-2 block text-sm font-semibold text-white">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="name"
                            maxlength="100"
                            required
                            class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]"
                        >
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="mb-2 block text-sm font-semibold text-white">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email aktif"
                            autocomplete="email"
                            required
                            class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]"
                        >
                    </div>

                    <!-- Nomor HP -->
                    <div class="mb-4">
                        <label for="no_hp" class="mb-2 block text-sm font-semibold text-white">
                            Nomor HP
                        </label>

                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 081234567890"
                            autocomplete="tel"
                            maxlength="20"
                            required
                            class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]"
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="mb-2 block text-sm font-semibold text-white">
                            Password
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password"
                                minlength="8"
                                required
                                class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 pr-12 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]"
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password', 'eyePassword')"
                                aria-label="Tampilkan atau sembunyikan password"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[#F5C400] hover:text-white"
                            >
                                <svg id="eyePassword" xmlns="http://www.w3.org/2000/svg"
                                    width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-white">
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                                class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 pr-12 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]"
                            >

                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation', 'eyeConfirmation')"
                                aria-label="Tampilkan atau sembunyikan konfirmasi password"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[#F5C400] hover:text-white"
                            >
                                <svg id="eyeConfirmation" xmlns="http://www.w3.org/2000/svg"
                                    width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Daftar -->
                    <button
                        type="submit"
                        class="w-full rounded-xl border border-[#F5C400] bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400]"
                    >
                        Daftar Sekarang
                    </button>

                </form>

                <!-- Link Login -->
                <p class="mt-7 text-center text-sm text-white/60">
                    Sudah memiliki akun?
                    <a
                        href="{{ route('pelanggan.login') }}"
                        class="font-semibold text-[#F5C400] hover:text-white"
                    >
                        Login
                    </a>
                </p>

            </div>
        </div>

    </div>

    @if (session('register_success'))
    <div id="modalRegister" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
        <div class="w-full max-w-sm rounded-2xl border border-[#F5C400]/30 bg-[#001840] p-7 text-center shadow-2xl">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#F5C400]/15 text-[#F5C400]">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-white">Akun Berhasil Didaftarkan</h3>

            <p class="mt-2 text-sm leading-relaxed text-white/70">
                Silakan cek email Anda untuk aktivasi akun.
            </p>
            <p class="mt-2 text-xs text-white/50">
                Jika email tidak masuk, silakan cek folder <b>spam</b>.
            </p>

            <button type="button"
                    onclick="document.getElementById('modalRegister').remove()"
                    class="mt-6 w-full rounded-xl bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] hover:bg-white">
                Mengerti
            </button>
        </div>
    </div>
@endif

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';

                icon.innerHTML = `
                    <path d="M3 3l18 18"/>
                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a15.5 15.5 0 0 1-4 4.8"/>
                    <path d="M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7a10.8 10.8 0 0 0 4.1-.8"/>
                `;
            } else {
                input.type = 'password';

                icon.innerHTML = `
                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
    </script>

</body>
</html>
