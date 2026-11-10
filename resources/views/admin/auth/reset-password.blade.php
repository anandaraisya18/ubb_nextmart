<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Admin - UBB Nextmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-[#001840] px-4 py-10">

    <div class="w-full max-w-md rounded-2xl border border-white/10 bg-white p-8 shadow-2xl">
        <div class="mb-7 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#001840] text-3xl text-[#F5C400]">
                <i class="fa-solid fa-lock"></i>
            </div>

            <h1 class="text-2xl font-bold text-[#001840]">
                Buat Password Baru
            </h1>

            <p class="mt-2 text-sm leading-relaxed text-gray-500">
                Silakan buat password baru untuk akun Admin UBB Nextmart.
                Pastikan password mudah kamu ingat dan tidak mudah ditebak.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-5">
                <label for="password" class="mb-2 block text-sm font-semibold text-[#001840]">
                    Password Baru
                </label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 text-sm text-gray-800 outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/20"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password', 'iconPassword')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#102A71]"
                        aria-label="Tampilkan password"
                    >
                        <i id="iconPassword" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#001840]">
                    Konfirmasi Password Baru
                </label>

                <div class="relative">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan ulang password baru"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 text-sm text-gray-800 outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/20"
                    >

                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', 'iconConfirmation')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#102A71]"
                        aria-label="Tampilkan konfirmasi password"
                    >
                        <i id="iconConfirmation" class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-[#001840] px-4 py-3 font-semibold text-white transition hover:bg-[#102A71] focus:outline-none focus:ring-2 focus:ring-[#F5C400] focus:ring-offset-2"
            >
                Simpan Password Baru
            </button>
        </form>

        <div class="mt-6 text-center">
            <a
                href="{{ route('admin.login') }}"
                class="text-sm font-semibold text-[#102A71] transition hover:text-[#F5C400]"
            >
                <i class="fa-solid fa-arrow-left mr-1"></i>
                Kembali ke Login Admin
            </a>
        </div>

        <div class="mt-8 border-t border-gray-100 pt-5 text-center">
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} UBB Nextmart. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
