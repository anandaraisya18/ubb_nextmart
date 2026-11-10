<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - UBB Nextmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-[#102A71] p-5">

    <div class="w-full max-w-md rounded-2xl border border-[#F5C400]/20 bg-[#001840] p-7 shadow-2xl md:p-9">

        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-white">
                <img src="{{ asset('images/logoubb.png') }}"
                     alt="UBB Nextmart"
                     class="h-10 w-10 object-contain">
            </div>

            <h1 class="text-2xl font-bold text-white">Buat Password Baru</h1>

            <p class="mt-2 text-sm text-white/60">
                Masukkan password baru untuk akun UBB Nextmart Anda.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-400/30 bg-red-400/10 p-3 text-sm text-red-300">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('pelanggan.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-5">
                <label for="email" class="mb-2 block text-sm font-semibold text-white">
                    Email
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $email) }}"
                       required
                       autocomplete="email"
                       class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none focus:border-[#F5C400]">
            </div>

            <div class="mb-5">
                <label for="password" class="mb-2 block text-sm font-semibold text-white">
                    Password Baru
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required
                       autocomplete="new-password"
                       class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]">
            </div>

            <div class="mb-6">
                <label for="password_confirmation"
                       class="mb-2 block text-sm font-semibold text-white">
                    Konfirmasi Password Baru
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Masukkan ulang password baru"
                       required
                       autocomplete="new-password"
                       class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]">
            </div>

            <button type="submit"
                    class="w-full rounded-xl bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] transition hover:bg-white">
                Simpan Password Baru
            </button>
        </form>

    </div>
</body>
</html>
