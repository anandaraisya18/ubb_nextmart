<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin - UBB Nextmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-[#001840] px-4 py-10">

    <div class="w-full max-w-md rounded-2xl border border-white/10 bg-white p-8 shadow-2xl">
        <div class="mb-7 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#001840] text-3xl text-[#F5C400]">
                <i class="fa-solid fa-key"></i>
            </div>

            <h1 class="text-2xl font-bold text-[#001840]">
                Lupa Password?
            </h1>

            <p class="mt-2 text-sm leading-relaxed text-gray-500">
                Masukkan email yang terdaftar pada akun Admin UBB Nextmart.
                Kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.password.email') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="email" class="mb-2 block text-sm font-semibold text-[#001840]">
                    Email Admin
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email admin"
                    required
                    autofocus
                    autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/20"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-[#001840] px-4 py-3 font-semibold text-white transition hover:bg-[#102A71] focus:outline-none focus:ring-2 focus:ring-[#F5C400] focus:ring-offset-2"
            >
                Kirim Link Reset Password
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

</body>
</html>
