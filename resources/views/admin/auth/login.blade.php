<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        // Mengambil 3 produk aktif terbaru dari database
        $loginProducts = \App\Models\Produk::aktif()
            ->where('stok', '>', 0)
            ->latest()
            ->take(3)
            ->get();
    @endphp

    <style>
        @keyframes blink-live {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.35; }
        }

        @keyframes row-highlight {
            0%, 100% { background-color: rgba(245, 196, 0, 0.07); }
            50% { background-color: rgba(245, 196, 0, 0.16); }
        }

        .animate-blink-live {
            animation: blink-live 2s ease-in-out infinite;
        }

        .animate-row-highlight {
            animation: row-highlight 2.6s ease-in-out infinite;
        }

        @media (max-width: 767px) {
            .decorative-blur,
            .dashboard-mockup-wrap {
                display: none !important;
            }

            .left-panel {
                padding-top: 20px !important;
                padding-bottom: 20px !important;
            }
        }
    </style>
</head>

<body class="min-h-screen w-screen overflow-y-auto bg-[#001840] md:h-screen md:overflow-hidden">

    <div class="grid min-h-screen w-full grid-cols-1 md:h-screen md:grid-cols-2">

        <!-- SISI KIRI: BRANDING -->
        <div class="left-panel relative flex flex-col justify-between overflow-hidden bg-[#001840] p-8 text-white sm:p-10 md:p-14">

            <div class="decorative-blur absolute -bottom-40 -right-20 h-96 w-96 rounded-full bg-[#F5C400]/10 blur-3xl"></div>

            <!-- Logo -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#F5C400]/30 bg-white">
                    <img
                        src="{{ asset('images/logoubb.png') }}"
                        alt="UBB Nextmart"
                        class="h-8 w-8 object-contain"
                    >
                </div>

                <div class="text-base font-bold leading-tight">
                    UBB Nextmart
                </div>
            </div>

            <!-- Mockup Produk -->
            <div class="dashboard-mockup-wrap relative z-10 flex flex-1 items-center justify-center">

                <div class="w-64 overflow-hidden rounded-xl border border-white/10 bg-[#0A2158] shadow-xl md:w-72">

                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">

                        <span class="text-xs font-semibold tracking-wide text-white/80">
                            Produk Tersedia
                        </span>

                        <span class="flex items-center gap-1.5 text-[10px] font-medium text-[#F5C400]">
                            <span class="animate-blink-live h-1.5 w-1.5 rounded-full bg-[#F5C400]"></span>
                            Aktif
                        </span>

                    </div>

                    <!-- Daftar Produk dari Database -->
                    <div class="space-y-1.5 p-2.5">

                        @forelse($loginProducts as $product)

                            <div class="{{ $loop->first ? 'animate-row-highlight ' : '' }}flex items-center justify-between gap-2 rounded-lg px-2.5 py-2">

                                <div class="min-w-0 flex-1">

                                    <!-- Nama Produk -->
                                    <div
                                        class="truncate text-xs font-semibold text-white"
                                        title="{{ $product->nama_produk }}"
                                    >
                                        {{ $product->nama_produk }}
                                    </div>

                                    <!-- Harga dan Stok -->
                                    <div class="text-[10px] text-white/50">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        · Stok {{ $product->stok }}
                                    </div>

                                </div>

                                <!-- Status Produk -->
                                <span class="shrink-0 rounded-full bg-emerald-400/20 px-2 py-0.5 text-[9px] font-semibold text-emerald-300">
                                    Tersedia
                                </span>

                            </div>

                        @empty

                            <!-- Jika Belum Ada Produk Aktif -->
                            <div class="px-3 py-5 text-center">

                                <p class="text-xs font-semibold text-white/80">
                                    Belum Ada Produk
                                </p>

                                <p class="mt-1 text-[10px] text-white/50">
                                    Belum ada produk aktif dengan stok tersedia.
                                </p>

                            </div>

                        @endforelse

                    </div>

                    <!-- Footer Mockup -->
                    <div class="flex items-center gap-2 border-t border-white/10 bg-white/5 px-4 py-2.5">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            class="h-3.5 w-3.5 shrink-0 text-[#F5C400]"
                        >
                            <path
                                d="M5 13l4 4L19 7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        <span class="text-[10px] text-white/70">
                            Data produk terhubung dengan katalog
                        </span>

                    </div>

                </div>

            </div>

            <!-- Caption -->
            <div class="relative z-10 text-sm leading-relaxed text-white/70">

                <strong class="mb-1.5 block text-xl text-white">
                    Panel Administrasi
                </strong>

                Kelola pesanan, produk, dan pembayaran UBB Nextmart dengan aman dari satu dashboard.

            </div>

        </div>

        <!-- SISI KANAN: FORM LOGIN -->
        <div class="flex flex-col justify-center bg-[#102A71] p-7 md:p-12">

            <div class="mx-auto w-full max-w-md rounded-2xl border border-[#F5C400]/20 bg-[#001840] p-7 shadow-2xl md:p-9">

                <h1 class="mb-1.5 text-2xl font-bold text-white md:text-[26px]">
                    Login Admin
                </h1>

                <p class="mb-8 text-sm text-white/60">
                    Masukkan email atau username untuk mengakses dashboard admin.
                </p>

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-[#F5C400]/40 bg-[#102A71] p-3.5 text-[13px] text-[#F5C400]">
                        <ul class="m-0 list-none space-y-1 p-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- PESAN STATUS -->
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-400/10 p-3.5 text-sm text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- FORM LOGIN -->
                <form method="POST" action="{{ route('admin.login.process') }}">
                    @csrf

                    <!-- EMAIL ATAU USERNAME -->
                    <div class="mb-5">

                        <label for="username" class="mb-2 block text-[13px] font-semibold text-white">
                            Email atau Username
                        </label>

                        <div class="relative">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="pointer-events-none absolute left-3.5 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#F5C400]"
                            >
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="w-full rounded-xl border-[1.5px] border-[#102A71] bg-[#102A71] py-3 pl-[42px] pr-3.5 text-sm text-white outline-none transition placeholder:text-white/40 focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10 @error('username') border-[#F5C400] @enderror"
                                placeholder="Masukkan email atau username"
                                value="{{ old('username') }}"
                                autocomplete="username"
                                autofocus
                                required
                            >

                        </div>

                        @error('username')
                            <div class="mt-1.5 text-xs text-[#F5C400]">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-5">

                        <label for="password" class="mb-2 block text-[13px] font-semibold text-white">
                            Password
                        </label>

                        <div class="relative">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="pointer-events-none absolute left-3.5 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#F5C400]"
                            >
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full rounded-xl border-[1.5px] border-[#102A71] bg-[#102A71] py-3 pl-[42px] pr-12 text-sm text-white outline-none transition placeholder:text-white/40 focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10 @error('password') border-[#F5C400] @enderror"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                onclick="togglePassword()"
                                aria-label="Tampilkan atau sembunyikan password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-[#F5C400] transition hover:text-white"
                            >
                                <svg
                                    id="eyeIcon"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    width="18"
                                    height="18"
                                >
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>

                        </div>

                        @error('password')
                            <div class="mt-1.5 text-xs text-[#F5C400]">
                                {{ $message }}
                            </div>  
                        @enderror

                    </div>

                    
<!-- INGAT SAYA DAN LUPA PASSWORD -->
<div class="mb-6 flex items-center justify-between gap-3">

    <!-- Checkbox Ingat Saya -->
    <label for="remember"
           class="flex cursor-pointer items-center gap-2 text-sm text-white/70">

        <input
            type="checkbox"
            id="remember"
            name="remember"
            value="1"
            class="h-4 w-4 rounded border-[#102A71] accent-[#F5C400]"
        >

        Ingat saya

    </label>

    <!-- Link Lupa Password -->
    <a
        href="{{ route('admin.password.request') }}"
        class="text-sm font-semibold text-[#F5C400] transition hover:text-white"
    >
        Lupa Password?
    </a>

</div>

                    <!-- TOMBOL LOGIN -->
                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded-xl border border-[#F5C400] bg-[#F5C400] py-[13px] text-[15px] font-semibold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400] active:scale-[0.99]"
                    >
                        Login
                    </button>

                </form>

                <!-- FOOTER -->
                <p class="mt-7 text-center text-xs text-[#F5C400]/70">
                    &copy; {{ date('Y') }} UBB Nextmart. All rights reserved.
                </p>

            </div>
        </div>

    </div>

    <!-- JAVASCRIPT -->
    <script>

        // TAMPILKAN ATAU SEMBUNYIKAN PASSWORD
        function togglePassword() {

            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (!passwordInput || !eyeIcon) {
                return;
            }

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;

            } else {

                passwordInput.type = 'password';

                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;

            }
        }


        // MENGINGAT EMAIL ATAU USERNAME ADMIN
        document.addEventListener('DOMContentLoaded', function () {

            const usernameInput = document.getElementById('username');
            const rememberCheckbox = document.getElementById('remember');

            if (!usernameInput || !rememberCheckbox) {
                return;
            }

            // Mengambil data yang tersimpan
            const savedUsername = localStorage.getItem('ubb_nextmart_admin_username');

            if (savedUsername) {
                usernameInput.value = savedUsername;
                rememberCheckbox.checked = true;
            }

            // Mengambil form login
            const loginForm = usernameInput.closest('form');

            if (!loginForm) {
                return;
            }

            // Menyimpan atau menghapus email/username
            loginForm.addEventListener('submit', function () {

                if (rememberCheckbox.checked) {

                    localStorage.setItem(
                        'ubb_nextmart_admin_username',
                        usernameInput.value.trim()
                    );

                } else {

                    localStorage.removeItem('ubb_nextmart_admin_username');

                }

            });

        });

    </script>

</body>
</html>
