
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan - UBB Nextmart</title>

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
                    Selamat Datang di
                    <span class="text-[#F5C400]">UBB Nextmart</span>
                </h2>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/60">
                    Satu platform untuk belanja kebutuhan, memesan makanan,
                    dan menggunakan layanan printing.
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
                    Login Pelanggan
                </h1>

                <p class="mb-7 mt-2 text-sm text-white/60">
                    Masuk ke akun UBB Nextmart Anda.
                </p>

                <!-- PESAN ERROR -->
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-400/30 bg-red-400/10 p-3 text-sm text-[#FCA5A5]">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- PESAN STATUS -->
                @if (session('status') || session('success'))
                    <div class="mb-5 rounded-lg border border-emerald-400/30 bg-emerald-400/10 p-3 text-sm text-emerald-300">
                        {{ session('status') ?? session('success') }}
                    </div>
                @endif

                <!-- PESAN KIRIM ULANG EMAIL AKTIVASI -->
                @if (session('resent'))
                    <div class="mb-5 rounded-lg border border-[#F5C400]/30 bg-[#F5C400]/10 p-3 text-sm text-[#F5C400]">
                        Jika email valid dan belum aktif, email aktivasi sudah dikirim ulang.
                    </div>
                @endif

                <!-- TOMBOL KIRIM ULANG EMAIL AKTIVASI -->
                @if (session('unverified_email'))
                    <form action="{{ route('pelanggan.verification.resend') }}"
                          method="POST"
                          class="mb-5">

                        @csrf

                        <input type="hidden"
                               name="email"
                               value="{{ session('unverified_email') }}">

                        <button type="submit"
                                class="text-sm font-semibold text-[#F5C400] underline hover:text-white">
                            Kirim ulang email aktivasi
                        </button>

                    </form>
                @endif

                <!-- FORM LOGIN -->
                <form method="POST" action="{{ route('pelanggan.login.process') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-5">

                        <label for="email"
                               class="mb-2 block text-sm font-semibold text-white">
                            Email
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="Masukkan email"
                               autocomplete="email"
                               autofocus
                               required
                               class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]">

                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">

                        <label for="password"
                               class="mb-2 block text-sm font-semibold text-white">
                            Password
                        </label>

                        <div class="relative">

                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password"
                                   autocomplete="current-password"
                                   required
                                   class="w-full rounded-xl border border-[#102A71] bg-[#102A71] px-4 py-3 pr-12 text-sm text-white outline-none placeholder:text-white/40 focus:border-[#F5C400]">

                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#F5C400] hover:text-white"
                                    aria-label="Tampilkan atau sembunyikan password">

                                <svg id="eyeIcon"
                                     xmlns="http://www.w3.org/2000/svg"
                                     width="20"
                                     height="20"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">

                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>

                                </svg>

                            </button>

                        </div>
                    </div>

                    <!-- INGAT SAYA DAN LUPA PASSWORD -->
                    <div class="mb-6 flex items-center justify-between gap-3">

                        <label for="remember"
                               class="flex cursor-pointer items-center gap-2 text-sm text-white/70">

                            <input type="checkbox"
                                   id="remember"
                                   name="remember"
                                   value="1"
                                   class="h-4 w-4 rounded border-[#102A71] accent-[#F5C400]">

                            Ingat saya

                        </label>

                        <a href="{{ route('pelanggan.password.request') }}"
                           class="text-sm font-medium text-[#F5C400] hover:text-white hover:underline">
                            Lupa password?
                        </a>

                    </div>

                    <!-- TOMBOL LOGIN -->
                    <button type="submit"
                            class="w-full rounded-xl border border-[#F5C400] bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400]">
                        Login
                    </button>

                </form>

                <!-- REGISTER -->
                <p class="mt-7 text-center text-sm text-white/60">
                    Belum memiliki akun?

                    <a href="{{ route('pelanggan.register') }}"
                       class="font-semibold text-[#F5C400] hover:text-white">
                        Daftar
                    </a>
                </p>

                <!-- PEMISAH -->
                <div class="my-6 flex items-center gap-4">

                    <div class="h-px flex-1 bg-white/20"></div>

                    <span class="text-xs text-white/40">ATAU</span>

                    <div class="h-px flex-1 bg-white/20"></div>

                </div>

                <!-- CONTINUE AS GUEST -->
                <a href="{{ route('pelanggan.dashboard') }}"
                   class="flex w-full items-center justify-center rounded-xl border border-white/30 bg-transparent py-3 text-sm font-semibold text-white transition hover:border-[#F5C400] hover:bg-[#102A71] hover:text-[#F5C400]">
                    Continue as Guest
                </a>

            </div>
        </div>

    </div>

    <!-- POPUP AKUN BERHASIL DIAKTIVASI -->
    @if (session('verified'))
        <div id="modalVerified"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">

            <div class="w-full max-w-sm rounded-2xl border border-[#F5C400]/30 bg-[#001840] p-7 text-center shadow-2xl">

                <h3 class="text-lg font-bold text-white">
                    Akun Berhasil Diaktivasi
                </h3>

                <p class="mt-2 text-sm text-white/70">
                    Akun Anda sudah aktif. Silakan login untuk mulai berbelanja.
                </p>

                <button type="button"
                        onclick="document.getElementById('modalVerified').remove()"
                        class="mt-6 w-full rounded-xl bg-[#F5C400] py-3 text-sm font-semibold text-[#001840] hover:bg-white">
                    Login Sekarang
                </button>

            </div>
        </div>
    @endif

    <!-- JAVASCRIPT -->
    <script>

        // TAMPILKAN ATAU SEMBUNYIKAN PASSWORD
        function togglePassword() {

            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (!input || !icon) {
                return;
            }

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


        // MENGINGAT EMAIL PELANGGAN PADA PERANGKAT INI
        document.addEventListener('DOMContentLoaded', function () {

            const emailInput = document.getElementById('email');
            const rememberCheckbox = document.getElementById('remember');

            // Pastikan elemen tersedia
            if (!emailInput || !rememberCheckbox) {
                return;
            }

            // Ambil email yang tersimpan
            const savedEmail = localStorage.getItem('ubb_nextmart_email');

            if (savedEmail) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }

            // Ambil form login
            const loginForm = emailInput.closest('form');

            if (!loginForm) {
                return;
            }

            // Simpan atau hapus email saat form dikirim
            loginForm.addEventListener('submit', function () {

                if (rememberCheckbox.checked) {

                    localStorage.setItem(
                        'ubb_nextmart_email',
                        emailInput.value.trim()
                    );

                } else {

                    localStorage.removeItem('ubb_nextmart_email');

                }

            });

        });

    </script>

</body>
</html>
