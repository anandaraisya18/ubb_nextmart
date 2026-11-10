<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - UBB Nextmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#001840]">
    <div class="grid min-h-screen grid-cols-1 md:grid-cols-2">

        <!-- SISI KIRI -->
        <div class="flex flex-col justify-between bg-[#001840] p-8 text-white md:p-14">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white">
                    <img src="{{ asset('images/logoubb.png') }}"
                         alt="UBB Nextmart"
                         class="h-8 w-8 object-contain">
                </div>
                <span class="text-lg font-bold">UBB Nextmart</span>
            </div>

            <div class="my-12">
                <h2 class="text-3xl font-bold leading-tight md:text-4xl">
                    Pulihkan Akses
                    <span class="text-[#F5C400]">Akun Anda</span>
                </h2>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/60">
                    Jangan khawatir. Masukkan email yang terdaftar
                    untuk mendapatkan tautan pengaturan ulang password.
                </p>
            </div>

            <p class="text-xs text-white/40">
                &copy; {{ date('Y') }} UBB Nextmart
            </p>
        </div>

        <!-- SISI KANAN -->
        <div class="flex items-center justify-center bg-[#102A71] p-6 md:p-12">
            <div class="w-full max-w-md rounded-2xl border border-[#F5C400]/20 bg-[#001840] p-7 shadow-2xl md:p-9">

                <h1 class="text-2xl font-bold text-white">
                    Lupa Password?
                </h1>

                <p class="mb-7 mt-2 text-sm text-white/60">
                    Masukkan email akun Anda untuk menerima tautan reset password.
                </p>

                <!-- PESAN BERHASIL -->
                @if (session('status'))
                    <div class="mb-5 rounded-lg border border-emerald-400/30 bg-emerald-400/10 p-3 text-sm text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-400/30 bg-red-400/10 p-3 text-sm text-[#FCA5A5]">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- FORM LUPA PASSWORD -->
                <form method="POST" action="{{ route('pelanggan.password.email') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email"
                               class="mb-2 block text-sm font-semibold text-white">
                            Email
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan email terdaftar"
                               autocomplete="email"
                               autofocus
                               required
                               class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]">
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl border border-[#F5C400] bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400]">
                        Kirim Link Reset Password
                    </button>
                </form>

                <!-- KEMBALI KE LOGIN -->
                <p class="mt-7 text-center text-sm">
                    <a href="{{ route('pelanggan.login') }}"
                       class="font-semibold text-[#F5C400] hover:text-white">
                        ← Kembali ke Login
                    </a>
                </p>

            </div>
        </div>
    </div>
</body>
</html>
