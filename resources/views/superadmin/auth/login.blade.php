<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Login Superadmin - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================
           ANIMASI SUPERADMIN
        ========================================= */

        @keyframes bar-grow {
            0%, 100% {
                transform: scaleY(0.55);
            }

            50% {
                transform: scaleY(1);
            }
        }

        .chart-bar {
            transform-origin: bottom;
            animation: bar-grow 1.8s ease-in-out infinite;
        }
            0%, 100% {
                opacity: 1;
            }

            50% {
                opacity: 0.35;
            }
        }

        .animate-float-badge {
            animation: float-badge 3.5s ease-in-out infinite;
        }

        .animate-blink-dot {
            animation: blink-dot 2s ease-in-out infinite;
        }


        /* =========================================
           FULL SCREEN FIX
        ========================================= */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden !important;
        }

        body {
            height: 100dvh;
            min-height: 100dvh;
            max-height: 100dvh;
            overscroll-behavior: none;
        }


        /* =========================================
           LAPTOP DENGAN TINGGI LAYAR PENDEK
        ========================================= */

        @media (max-height: 800px) and (min-width: 1024px) {

            .login-panel {
                padding-top: 25px !important;
                padding-bottom: 25px !important;
            }

            .login-card {
                padding: 24px !important;
            }

            .login-header {
                margin-bottom: 20px !important;
            }

            .login-field {
                margin-bottom: 14px !important;
            }

            .remember-row {
                margin-bottom: 18px !important;
            }

            .security-notice {
                margin-top: 15px !important;
                padding: 10px !important;
            }

            .login-footer {
                margin-top: 12px !important;
            }

            .dashboard-mockup {
                width: 260px !important;
            }

            .mockup-badge {
                padding: 8px 12px !important;
            }
        }


        /* =========================================
           TABLET
        ========================================= */

        @media (min-width: 768px) and (max-width: 1023px) {

            html,
            body {
                height: 100dvh;
                overflow: hidden !important;
            }

            body {
                position: fixed;
                inset: 0;
            }

            .login-container {
                height: 100dvh !important;
                max-height: 100dvh !important;
                overflow: hidden !important;
            }
        }



/* =========================================
   HP PORTRAIT
   Animasi + pernak-pernik DISEMBUNYIKAN
========================================= */

@media (max-width: 767px) {

    html,
    body {
        width: 100%;
        height: 100dvh;
        min-height: 100dvh;
        max-height: 100dvh;
        overflow: hidden !important;
    }

    body {
        position: fixed;
        inset: 0;
        overscroll-behavior: none;
    }


    /* =====================================
       CONTAINER
    ===================================== */

    .login-container {
        width: 100%;
        height: 100dvh !important;
        min-height: 100dvh !important;
        max-height: 100dvh !important;

        overflow: hidden !important;

        /*
         * Kiri untuk logo + judul
         * Kanan untuk form login
         */
        grid-template-rows: 32dvh 68dvh !important;
    }


    /* =====================================
       SISI KIRI HP
    ===================================== */

    .left-panel {
        height: 32dvh !important;
        min-height: 0 !important;
        max-height: 32dvh !important;

        padding: 16px 20px !important;

        overflow: hidden !important;

        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
    }


    /* =====================================
       HIDE SEMUA ANIMASI & PERNAK-PERNIK
    ===================================== */

    /*
     * Background blur / lingkaran dekoratif
     */
    .left-panel > div.absolute {
        display: none !important;
    }


    /*
     * Seluruh area ilustrasi:
     * ring + shield + floating node
     */
    .left-panel > div.relative.z-10.flex-1 {
        display: none !important;
    }


    /*
     * Kalau class ilustrasi berubah,
     * selector ini tetap mengamankan elemen-elemen
     */
    .dashboard-mockup,
    .mockup-badge,
    .animate-float-badge,
    .animate-blink-dot {
        display: none !important;
    }


    /* =====================================
       LOGO
    ===================================== */

    .left-panel > div:first-child {
        position: relative !important;
        z-index: 20 !important;

        gap: 8px !important;
    }

    .left-panel > div:first-child > div:first-child {
        width: 38px !important;
        height: 38px !important;

        border-radius: 9px !important;
    }

    .left-panel > div:first-child img {
        width: 26px !important;
        height: 26px !important;
    }

    .left-panel > div:first-child .text-base {
        font-size: 13px !important;
    }


    /* =====================================
       CAPTION
    ===================================== */

    .left-panel > div:last-child {
        position: relative !important;
        z-index: 20 !important;

        max-width: 100% !important;

        margin-top: auto !important;
    }


    .left-panel > div:last-child h2 {
        font-size: 20px !important;
        line-height: 1.2 !important;

        margin-bottom: 5px !important;
    }


    .left-panel > div:last-child p {
        font-size: 10px !important;
        line-height: 1.35 !important;

        max-width: 310px !important;
    }


    /* =====================================
       SISI KANAN HP
    ===================================== */

    .login-panel {
        height: 68dvh !important;
        min-height: 0 !important;
        max-height: 68dvh !important;

        padding: 10px 16px !important;

        overflow: hidden !important;
    }


    .login-panel > div {
        width: 100% !important;
        max-width: 420px !important;
        max-height: 100% !important;
    }


    /* =====================================
       LOGIN CARD
    ===================================== */

    .login-card {
        width: 100% !important;

        padding: 14px !important;

        border-radius: 14px !important;

        max-height: calc(68dvh - 25px) !important;

        overflow: hidden !important;
    }


    /* Header */

    .login-header {
        margin-bottom: 12px !important;
    }

    .login-header h1 {
        font-size: 19px !important;
        line-height: 1.2 !important;
        margin-bottom: 4px !important;
    }

    .login-header p {
        font-size: 10px !important;
        line-height: 1.3 !important;
    }


    /* Error */

    .login-card > div[class*="mb-6"] {
        font-size: 10px !important;
        padding: 8px !important;
        margin-bottom: 10px !important;
    }


    /* =====================================
       FORM
    ===================================== */

    .login-field {
        margin-bottom: 10px !important;
    }

    .login-field label {
        font-size: 10px !important;
        margin-bottom: 4px !important;
    }

    .login-field input {
        height: 38px !important;

        padding-top: 8px !important;
        padding-bottom: 8px !important;

        font-size: 11px !important;

        border-radius: 9px !important;
    }

    .login-field svg {
        width: 15px !important;
        height: 15px !important;
    }


    /* Error validation */

    .login-field > div.text-xs {
        font-size: 9px !important;
        margin-top: 3px !important;
    }


    /* =====================================
       REMEMBER
    ===================================== */

    .remember-row {
        margin-bottom: 11px !important;
        font-size: 10px !important;
    }

    .remember-row input {
        width: 13px !important;
        height: 13px !important;
    }

    .remember-row a {
        font-size: 10px !important;
    }


    /* =====================================
       BUTTON
    ===================================== */

    .login-card button[type="submit"] {
        height: 40px !important;
        min-height: 40px !important;

        padding: 8px !important;

        font-size: 11px !important;

        border-radius: 9px !important;
    }

    .login-card button[type="submit"] svg {
        width: 13px !important;
        height: 13px !important;
    }


    /* =====================================
       SECURITY NOTICE
    ===================================== */

    .security-notice {
        margin-top: 10px !important;
        padding: 8px !important;
        gap: 7px !important;
    }

    .security-notice svg {
        width: 13px !important;
        height: 13px !important;
    }

    .security-notice p {
        font-size: 8px !important;
        line-height: 1.25 !important;
    }


    /* =====================================
       FOOTER
    ===================================== */

    .login-footer {
        margin-top: 5px !important;
        font-size: 8px !important;
    }
}


/* =========================================
   HP PENDEK
   Contoh: 360 x 640
========================================= */

@media (max-width: 767px) and (max-height: 700px) {

    .login-container {
        grid-template-rows: 30dvh 70dvh !important;
    }


    .left-panel {
        height: 30dvh !important;
        max-height: 30dvh !important;

        padding: 12px 16px !important;
    }


    /* Pastikan ilustrasi tetap HILANG */
    .left-panel > div.relative.z-10.flex-1 {
        display: none !important;
    }


    .left-panel > div.absolute {
        display: none !important;
    }


    .left-panel > div:last-child h2 {
        font-size: 17px !important;
    }

    .left-panel > div:last-child p {
        font-size: 8px !important;
    }


    .login-panel {
        height: 70dvh !important;
        max-height: 70dvh !important;

        padding: 7px 12px !important;
    }

    .login-card {
        padding: 11px !important;

        max-height: calc(70dvh - 20px) !important;
    }

    .login-header {
        margin-bottom: 8px !important;
    }

    .login-header h1 {
        font-size: 17px !important;
    }

    .login-header p {
        font-size: 8px !important;
    }

    .login-field {
        margin-bottom: 7px !important;
    }

    .login-field label {
        font-size: 9px !important;
    }

    .login-field input {
        height: 34px !important;
        font-size: 10px !important;
    }

    .remember-row {
        margin-bottom: 8px !important;
    }

    .login-card button[type="submit"] {
        height: 36px !important;
        min-height: 36px !important;
        font-size: 10px !important;
    }

    .security-notice {
        margin-top: 7px !important;
        padding: 6px !important;
    }

    .security-notice p {
        font-size: 7px !important;
    }

    .login-footer {
        margin-top: 3px !important;
        font-size: 7px !important;
    }
}
    </style>
</head>


<body class="h-screen bg-[#001840] overflow-hidden">

    <div
        class="login-container h-screen grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr] overflow-hidden">


        <!-- =========================================
             SISI KIRI
             SUPERADMIN CONTROL CENTER
        ========================================== -->

        <div
            class="left-panel
                   relative
                   h-screen
                   bg-[#001840]
                   text-white
                   px-8 py-8
                   md:px-14 md:py-8
                   lg:px-16 lg:py-8
                   flex flex-col
                   justify-between
                   overflow-hidden"
        >


            <!-- =====================================
                 LOGO
            ====================================== -->

            <div class="relative z-10 flex items-center gap-3">

                <div
                    class="w-11 h-11
                           rounded-xl
                           bg-white
                           border border-[#F5C400]/30
                           flex items-center justify-center"
                >

                    <img
                        src="{{ asset('images/logoubb.png') }}"
                        alt="UBB Nextmart"
                        class="w-8 h-8 object-contain"
                    >

                </div>

                <div>

                    <div
                        class="text-base
                               font-bold
                               leading-tight"
                    >
                        UBB Nextmart
                    </div>

                </div>

            </div>


            <!-- =====================================
                 ILUSTRASI SUPERADMIN
            ====================================== -->

            <div
                class="relative z-10
                       flex-1
                       flex items-center
                       justify-center
                       min-h-0"
            >

                <!-- Dashboard mockup: flat window showing the
                     kind of panel a superadmin actually manages -->

                <div class="relative w-[300px] md:w-[340px]">

                <div
                    class="dashboard-mockup
                           relative
                           w-full
                           rounded-xl
                           bg-[#0A2158]
                           border border-white/10
                           shadow-xl
                           overflow-hidden"
                >

                    <!-- window top bar -->
                    <div class="flex items-center gap-1.5 px-3.5 py-2.5 border-b border-white/10">
                        <span class="w-2 h-2 rounded-full bg-white/20"></span>
                        <span class="w-2 h-2 rounded-full bg-white/20"></span>
                        <span class="w-2 h-2 rounded-full bg-white/20"></span>
                        <span class="ml-2 text-[9px] tracking-wide text-white/40">nextmart.admin</span>
                    </div>

                    <div class="p-4">

                        <!-- stat row -->
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            <div class="rounded-lg bg-white/5 p-2">
                                <div class="text-[8px] text-white/40 mb-1">Store</div>
                                <div class="text-xs font-semibold text-white">2</div>
                            </div>
                            <div class="rounded-lg bg-white/5 p-2">
                                <div class="text-[8px] text-white/40 mb-1">Admin</div>
                                <div class="text-xs font-semibold text-white">2</div>
                            </div>
                            <div class="rounded-lg bg-white/5 p-2">
                                <div class="text-[8px] text-white/40 mb-1">Aktif</div>
                                <div class="flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#F5C400] animate-blink-dot"></span>
                                    <span class="text-xs font-semibold text-white">Live</span>
                                </div>
                            </div>
                        </div>

                        <!-- bar chart -->
                        <div class="flex items-end gap-1.5 h-16 mb-3 px-1">
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]/30" style="height:45%; animation-delay:0s"></div>
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]/50" style="height:70%; animation-delay:.15s"></div>
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]/40" style="height:55%; animation-delay:.3s"></div>
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]" style="height:95%; animation-delay:.45s"></div>
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]/60" style="height:65%; animation-delay:.6s"></div>
                            <div class="chart-bar w-full rounded-sm bg-[#F5C400]/45" style="height:50%; animation-delay:.75s"></div>
                        </div>

                        <!-- row list -->
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 rounded-md bg-white/5 px-2 py-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <div class="h-1.5 w-24 rounded-full bg-white/15"></div>
                            </div>
                            <div class="flex items-center gap-2 rounded-md bg-white/5 px-2 py-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#F5C400]"></span>
                                <div class="h-1.5 w-16 rounded-full bg-white/15"></div>
                            </div>
                        </div>

                    </div>

                </div>

                </div>

            </div>


            <!-- =====================================
                 CAPTION
            ====================================== -->

            <div
                class="relative z-10
                       max-w-md"
            >


                <h2
                    class="text-2xl
                           md:text-3xl
                           font-bold
                           leading-tight
                           mb-2"
                >

                    Pusat Kendali

                    <span class="text-[#F6C400]">
                        UBB Nextmart
                    </span>

                </h2>


                <p
                    class="text-sm
                           leading-relaxed
                           text-white/70
                           max-w-sm"
                >
                    Kelola akun admin, group/store,
                    serta pantau aktivitas sistem
                    melalui satu pusat kendali
                    yang terintegrasi.
                </p>

            </div>

        </div>


        <!-- =========================================
             SISI KANAN
             FORM LOGIN
        ========================================== -->

        <div
            class="login-panel
                   h-screen
                   px-7 py-8
                   md:px-14
                   lg:px-20
                   flex flex-col
                   justify-center
                   bg-[#102A71]
                   overflow-hidden"
        >

            <div
                class="w-full
                       max-w-md
                       mx-auto"
            >

                <!-- =================================
                     LOGIN CARD
                ================================== -->

                <div
                    class="login-card
                           bg-[#001840]
                           border
                           border-[#F5C400]/20
                           rounded-2xl
                           p-7 md:p-9
                           shadow-2xl"
                >

                    <!-- Header -->

                    <div class="login-header mb-8">

                        <h1
                            class="text-2xl
                                   md:text-[28px]
                                   font-bold
                                   text-white
                                   mb-2"
                        >
                            Superadmin Login
                        </h1>

                        <p
                            class="text-sm
                                   leading-relaxed
                                   text-white/60"
                        >
                            Masukkan kredensial Superadmin
                            untuk mengakses pusat kendali sistem.
                        </p>

                    </div>


                    <!-- Error -->

                    @if ($errors->any())

                        <div
                            class="bg-[#102A71]
                                   border
                                   border-[#F5C400]/40
                                   text-[#F5C400]
                                   text-[13px]
                                   p-3.5
                                   rounded-xl
                                   mb-6"
                        >

                            <ul class="list-none m-0 p-0">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <!-- Form -->

                    <form
                        method="POST"
                        action="{{ route('superadmin.login.process') }}"
                    >

                        @csrf


                        <!-- Username -->

                        <div class="login-field mb-5">

                            <label
                                for="username"
                                class="block
                                       text-[13px]
                                       font-semibold
                                       text-white
                                       mb-2"
                            >
                                Email Atau Username
                            </label>


                            <div class="relative">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="absolute
                                           left-3.5
                                           top-1/2
                                           -translate-y-1/2
                                           w-[18px]
                                           h-[18px]
                                           text-[#F5C400]
                                           pointer-events-none"
                                >

                                    <path
                                        d="M20 21v-2
                                           a4 4 0 0 0-4-4H8
                                           a4 4 0 0 0-4 4v2"
                                    />

                                    <circle
                                        cx="12"
                                        cy="7"
                                        r="4"
                                    />

                                </svg>


                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="
                                        w-full
                                        py-3
                                        pl-[42px]
                                        pr-3.5
                                        border-[1.5px]
                                        border-[#102A71]
                                        rounded-xl
                                        text-sm
                                        text-white
                                        bg-[#102A71]
                                        outline-none
                                        transition
                                        placeholder:text-white/40
                                        focus:border-[#F5C400]
                                        focus:ring-4
                                        focus:ring-[#F5C400]/10

                                        @error('username')
                                            border-[#F5C400]
                                        @enderror
                                    "
                                    placeholder="Masukkan username"
                                    value="{{ old('username') }}"
                                    autofocus
                                    required
                                >

                            </div>


                            @error('username')

                                <div
                                    class="text-xs
                                           text-[#F5C400]
                                           mt-1.5"
                                >
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- Password -->

                        <div class="login-field mb-5">

                            <label
                                for="password"
                                class="block
                                       text-[13px]
                                       font-semibold
                                       text-white
                                       mb-2"
                            >
                                Password
                            </label>


                            <div class="relative">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="absolute
                                           left-3.5
                                           top-1/2
                                           -translate-y-1/2
                                           w-[18px]
                                           h-[18px]
                                           text-[#F5C400]
                                           pointer-events-none"
                                >

                                    <rect
                                        x="3"
                                        y="11"
                                        width="18"
                                        height="11"
                                        rx="2"
                                    />

                                    <path
                                        d="M7 11V7
                                           a5 5 0 0 1 10 0v4"
                                    />

                                </svg>


                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="
                                        w-full
                                        py-3
                                        pl-[42px]
                                        pr-12
                                        border-[1.5px]
                                        border-[#102A71]
                                        rounded-xl
                                        text-sm
                                        text-white
                                        bg-[#102A71]
                                        outline-none
                                        transition
                                        placeholder:text-white/40
                                        focus:border-[#F5C400]
                                        focus:ring-4
                                        focus:ring-[#F5C400]/10

                                        @error('password')
                                            border-[#F5C400]
                                        @enderror
                                    "
                                    placeholder="Masukkan password"
                                    required
                                >


                                <!-- Toggle Password -->

                                <button
                                    type="button"
                                    onclick="togglePassword()"
                                    class="
                                        absolute
                                        right-3
                                        top-1/2
                                        -translate-y-1/2
                                        p-1
                                        text-[#F5C400]
                                        hover:text-white
                                        transition
                                    "
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

                                        <path
                                            d="M1 12
                                               s4-8 11-8
                                               11 8 11 8
                                               -4 8-11 8
                                               -11-8-11-8z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                        />

                                    </svg>

                                </button>

                            </div>


                            @error('password')

                                <div
                                    class="text-xs
                                           text-[#F5C400]
                                           mt-1.5"
                                >
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <!-- Login Button -->

                        <button
                            type="submit"
                            class="
                                w-full
                                py-[13px]
                                bg-[#F5C400]
                                hover:bg-[#102A71]
                                text-[#001840]
                                hover:text-[#F5C400]
                                border
                                border-[#F5C400]
                                rounded-xl
                                text-[15px]
                                font-semibold
                                transition
                                active:scale-[0.99]
                                cursor-pointer
                            "
                        >

                            <span
                                class="flex
                                       items-center
                                       justify-center
                                       gap-2"
                            >

                                Masuk ke Control Center

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    class="w-4 h-4"
                                >

                                    <path
                                        d="M5 12h14"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M13 6l6 6-6 6"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />

                                </svg>

                            </span>

                        </button>

                    </form>


                    <!-- Security Notice -->

                    <div
                        class="
                            security-notice
                            mt-6
                            p-3.5
                            rounded-xl
                            bg-[#102A71]
                            border
                            border-[#F5C400]/20
                            flex
                            items-start
                            gap-3
                        "
                    >

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="
                                w-4 h-4
                                text-[#F5C400]
                                mt-0.5
                                shrink-0
                            "
                        >

                            <path
                                d="M12 3
                                   L20 6
                                   V11
                                   C20 16 16.5 20
                                   12 22
                                   C7.5 20 4 16 4 11
                                   V6
                                   L12 3Z"
                            />

                            <path
                                d="M12 8v4"
                                stroke-linecap="round"
                            />

                            <circle
                                cx="12"
                                cy="16"
                                r=".7"
                                fill="currentColor"
                            />

                        </svg>


                        <p
                            class="
                                text-[11px]
                                leading-relaxed
                                text-white/60
                            "
                        >
                            Akses ini ditujukan khusus untuk
                            Superadmin. Seluruh aktivitas pada
                            panel dapat tercatat dalam audit log.
                        </p>

                    </div>

                </div>


                <!-- Footer -->

                <p
                    class="
                        login-footer
                        text-center
                        text-xs
                        text-[#F5C400]/70
                        mt-5
                    "
                >
                    &copy; {{ date('Y') }}
                    UBB Nextmart.
                    All rights reserved.
                </p>

            </div>

        </div>

    </div>


    <!-- =========================================
         JAVASCRIPT
    ========================================== -->

    <script>

        function togglePassword() {

            const passwordInput =
                document.getElementById('password');

            const eyeIcon =
                document.getElementById('eyeIcon');


            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.innerHTML = `

                    <path
                        d="M17.94 17.94
                           A10.07 10.07 0 0 1 12 20
                           c-7 0-11-8-11-8
                           a18.45 18.45 0 0 1 5.06-5.94"
                    />

                    <path
                        d="M9.9 4.24
                           A9.12 9.12 0 0 1 12 4
                           c7 0 11 8 11 8
                           a18.5 18.5 0 0 1-2.16 3.19"
                    />

                    <path
                        d="M14.12 14.12
                           a3 3 0 1 1-4.24-4.24"
                    />

                    <line
                        x1="1"
                        y1="1"
                        x2="23"
                        y2="23"
                    />

                `;

            } else {

                passwordInput.type = 'password';

                eyeIcon.innerHTML = `

                    <path
                        d="M1 12
                           s4-8 11-8
                           11 8 11 8
                           -4 8-11 8
                           -11-8-11-8z"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                    />

                `;

            }

        }

    </script>

</body>

</html>