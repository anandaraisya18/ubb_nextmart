@extends('pelanggan.layouts.app')

@section('title', 'UBB Nextmart - Beranda')

@section('content')

{{-- =========================================================
     HERO SECTION
========================================================= --}}
<section class="relative overflow-hidden bg-[#001840] min-h-[680px]">

    {{-- =====================================================
         ANIMATED GRID / KOTAK BERGERAK
    ====================================================== --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">

        {{-- Grid utama --}}
        <div class="hero-grid"></div>

        {{-- Garis tambahan --}}
        <div class="absolute inset-0 opacity-20">
            <div class="moving-line moving-line-1"></div>
            <div class="moving-line moving-line-2"></div>
            <div class="moving-line moving-line-3"></div>
        </div>

        {{-- Glow background --}}
        <div class="absolute -top-32 -left-32 w-[450px] h-[450px]
                    bg-[#102A71]/40 rounded-full blur-[120px]">
        </div>

        <div class="absolute -bottom-40 right-0 w-[500px] h-[500px]
                    bg-[#102A71]/30 rounded-full blur-[130px]">
        </div>

    </div>


    {{-- =====================================================
         DECORATIVE CIRCLES
    ====================================================== --}}
    <div class="absolute top-20 left-[8%] w-3 h-3 bg-[#F5C400]
                rounded-full opacity-70 animate-pulse">
    </div>

    <div class="absolute top-[45%] left-[4%] w-2 h-2 bg-white
                rounded-full opacity-30">
    </div>

    <div class="absolute bottom-20 left-[45%] w-2 h-2 bg-[#F5C400]
                rounded-full opacity-50 animate-pulse">
    </div>


    {{-- =====================================================
         HERO CONTENT
    ====================================================== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16
                    items-center min-h-[680px] py-20">


            {{-- =================================================
                 LEFT CONTENT
            ================================================== --}}
            <div class="max-w-2xl">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2
                            bg-white/10 border border-white/10
                            backdrop-blur-sm rounded-full
                            px-4 py-2 mb-7">

                    <span class="w-2 h-2 bg-[#F5C400]
                                 rounded-full animate-pulse">
                    </span>

                    <span class="text-white/80 text-sm font-medium">
                        Belanja Mudah di UBB
                    </span>

                </div>


                {{-- Heading --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl
                           font-extrabold leading-[1.08]
                           tracking-tight text-white">

                    Semua Kebutuhan

                    <span class="block text-[#F5C400] mt-2">
                        Dalam Satu Tempat.
                    </span>

                </h1>


                {{-- Description --}}
                <p class="mt-7 text-lg leading-relaxed
                          text-white/65 max-w-xl">

                    Temukan berbagai kebutuhan mahasiswa,
                    layanan printing, hingga pilihan makanan
                    dalam satu platform UBB Nextmart.

                </p>


                {{-- Buttons --}}
                <div class="flex flex-wrap items-center gap-4 mt-9">

                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="group inline-flex items-center gap-3
                              bg-[#F5C400] hover:bg-[#ffd51a]
                              text-[#001840] font-bold
                              px-6 py-3.5 rounded-xl
                              transition-all duration-300
                              shadow-lg shadow-[#F5C400]/20">

                        <span>
                            Lihat Produk
                        </span>

                        <svg
                            class="w-5 h-5 transition-transform
                                   duration-300 group-hover:translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />

                        </svg>

                    </a>


                    <a href="{{ route('pelanggan.pesanan.lacak') }}"
                       class="inline-flex items-center gap-2
                              border border-white/20
                              hover:border-white/40
                              hover:bg-white/5
                              text-white font-semibold
                              px-6 py-3.5 rounded-xl
                              transition-all duration-300">

                        Lacak Pesanan

                    </a>

                </div>


                {{-- Info --}}
                <div class="grid grid-cols-3 gap-5 mt-12 max-w-lg">

                    <div>
                        <div class="text-2xl font-bold text-white">
                            24/7
                        </div>

                        <div class="text-sm text-white/45 mt-1">
                            Akses Online
                        </div>
                    </div>


                    <div class="border-l border-white/10 pl-5">

                        <div class="text-2xl font-bold text-white">
                            3+
                        </div>

                        <div class="text-sm text-white/45 mt-1">
                            Toko Pilihan
                        </div>

                    </div>


                    <div class="border-l border-white/10 pl-5">

                        <div class="text-2xl font-bold text-white">
                            Mudah
                        </div>

                        <div class="text-sm text-white/45 mt-1">
                            Dalam Satu Platform
                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 RIGHT : 2 CIRCLE IMAGES
            ================================================== --}}
            <div class="relative hidden lg:flex
                        items-center justify-center
                        min-h-[500px]">

                {{-- Glow belakang --}}
                <div class="absolute w-[430px] h-[430px]
                            rounded-full
                            bg-[#102A71]/50
                            blur-[80px]">
                </div>


                {{-- Decorative ring --}}
                <div class="absolute w-[420px] h-[420px]
                            rounded-full
                            border border-white/10
                            animate-[spin_25s_linear_infinite]">
                </div>


                {{-- Ring kecil --}}
                <div class="absolute w-[350px] h-[350px]
                            rounded-full
                            border border-[#F5C400]/10
                            animate-[spin_18s_linear_infinite_reverse]">
                </div>


                {{-- =================================================
                     CIRCLE 1
                ================================================== --}}
                <div class="hero-circle hero-circle-one">

                    <div class="absolute inset-0 rounded-full
                                bg-gradient-to-br
                                from-white/20 to-transparent
                                z-10 pointer-events-none">
                    </div>

                    <img
                        src="{{ asset('images/ubbmart-dalam.png') }}"
                        alt="UBB Mart Dalam"
                        class="w-full h-full object-cover">

                    <div class="absolute inset-0 rounded-full
                                bg-gradient-to-t
                                from-[#001840]/60
                                via-transparent
                                to-transparent">
                    </div>

                </div>


                {{-- =================================================
                     CIRCLE 2
                ================================================== --}}
                                <div class="hero-circle hero-circle-two">

                    <div class="absolute inset-0 rounded-full
                                bg-gradient-to-br
                                from-white/20 to-transparent
                                z-10 pointer-events-none">
                    </div>

                    <img
                        src="{{ asset('images/ubbmart-depan.png') }}"
                        alt="UBB Mart Depan"
                        class="w-full h-full object-cover">

                    <div class="absolute inset-0 rounded-full
                                bg-gradient-to-t
                                from-[#001840]/60
                                via-transparent
                                to-transparent">
                    </div>

                </div>

        </div>

    </div>

</div>

</div>


    {{-- =====================================================
         BOTTOM FADE
    ====================================================== --}}
   <div class="absolute bottom-0 left-0 right-0 h-8
            bg-gradient-to-t
            from-[#f8fafc]
            via-[#f8fafc]/40
            to-transparent
            pointer-events-none">
</div>


    {{-- =====================================================
         HERO ANIMATION STYLE
    ====================================================== --}}
    <style>

        /* ============================================
           MOVING GRID
        ============================================ */

        .hero-grid {
            position: absolute;
            inset: -100px;
            opacity: 0.16;

            background-image:
                linear-gradient(
                    rgba(255,255,255,0.12) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255,255,255,0.12) 1px,
                    transparent 1px
                );

            background-size: 70px 70px;

            transform: perspective(500px)
                       rotateX(55deg)
                       scale(1.5);

            transform-origin: center center;

            animation: gridMove 12s linear infinite;
        }


        @keyframes gridMove {

            0% {
                background-position:
                    0 0,
                    0 0;
            }

            100% {
                background-position:
                    0 70px,
                    70px 0;
            }

        }


        /* ============================================
           MOVING LIGHT LINES
        ============================================ */

        .moving-line {
            position: absolute;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(245,196,0,0.35),
                transparent
            );
        }


        .moving-line-1 {
            width: 40%;
            height: 1px;
            top: 25%;
            left: -40%;
            animation: lineMove 7s linear infinite;
        }


        .moving-line-2 {
            width: 35%;
            height: 1px;
            top: 60%;
            left: -35%;
            animation: lineMove 9s linear infinite 2s;
        }


        .moving-line-3 {
            width: 25%;
            height: 1px;
            top: 80%;
            left: -25%;
            animation: lineMove 11s linear infinite 4s;
        }


        @keyframes lineMove {

            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(500%);
            }

        }


        /* ============================================
           CIRCLE IMAGE
        ============================================ */

        .hero-circle {
            position: absolute;
            overflow: hidden;

            border-radius: 9999px;

            border: 7px solid rgba(255,255,255,0.10);

            box-shadow:
                0 25px 60px rgba(0,0,0,0.35),
                0 0 60px rgba(16,42,113,0.45);

            transition:
                transform 0.5s ease,
                box-shadow 0.5s ease;

            animation:
                floatCircle 5s ease-in-out infinite;
        }


        .hero-circle:hover {
            transform:
                scale(1.04)
                translateY(-8px);

            box-shadow:
                0 30px 80px rgba(0,0,0,0.45),
                0 0 80px rgba(245,196,0,0.18);
        }


        /* Circle kiri / belakang */

        .hero-circle-one {

            width: 310px;
            height: 310px;

            left: 5px;
            top: 95px;

            z-index: 1;

            animation-delay: -1s;
        }


        /* Circle kanan / depan */

        .hero-circle-two {

            width: 360px;
            height: 360px;

            right: 10px;
            top: 45px;

            z-index: 2;

            border-color:
                rgba(245,196,0,0.22);

            animation-delay: -3s;
        }


        @keyframes floatCircle {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-14px);
            }

        }


        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

        }


        /* ============================================
           RESPONSIVE
        ============================================ */

        @media (max-width: 1024px) {

            .hero-circle-one {
                width: 260px;
                height: 260px;
            }

            .hero-circle-two {
                width: 300px;
                height: 300px;
            }

        }


        @media (max-width: 768px) {

            .hero-grid {
                background-size: 50px 50px;
            }

        }

    </style>

</section>



{{-- =========================================================
     STORE / CATEGORY STRIP
     BAGIAN INI TETAP
========================================================= --}}

<section class="bg-white py-8 border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- UBB MART --}}
            <div class="group rounded-2xl border border-gray-100
                        bg-white p-5
                        hover:border-[#102A71]/20
                        hover:shadow-lg
                        transition-all duration-300">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-[#001840]
                                flex items-center justify-center
                                text-white">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h12"
                            />

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-[#001840]">
                            UBB Mart
                        </h3>

                        <p class="text-sm text-gray-500">
                            Kebutuhan mahasiswa
                        </p>
                    </div>

                </div>

            </div>


            {{-- GUBUK PRINTING --}}
            <div class="group rounded-2xl border border-gray-100
                        bg-white p-5
                        hover:border-[#102A71]/20
                        hover:shadow-lg
                        transition-all duration-300">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-[#102A71]
                                flex items-center justify-center
                                text-white">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"
                            />

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-[#001840]">
                            Gubuk Printing
                        </h3>

                        <p class="text-sm text-gray-500">
                            Printing & percetakan
                        </p>
                    </div>

                </div>

            </div>


            {{-- NEW COMBI --}}
            <div class="group rounded-2xl border border-gray-100
                        bg-white p-5
                        hover:border-[#102A71]/20
                        hover:shadow-lg
                        transition-all duration-300">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl
                                bg-[#F5C400]
                                flex items-center justify-center
                                text-[#001840]">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v18M3 12h18"
                            />

                        </svg>

                    </div>

                    <div>
                        <h3 class="font-bold text-[#001840]">
                            New Combi
                        </h3>

                        <p class="text-sm text-gray-500">
                            Makanan & minuman
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     PRODUCT SECTION
========================================================= --}}

<section id="produk" class="bg-[#f8fafc] py-20">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex items-end justify-between gap-5 mb-10">

            <div>

                <span class="text-sm font-bold
                             text-[#102A71] uppercase
                             tracking-wider">

                    Pilihan Produk

                </span>

                <h2 class="text-3xl lg:text-4xl
                           font-extrabold
                           text-[#001840] mt-2">

                    Produk Terbaru

                </h2>

                <p class="text-gray-500 mt-3">
                    Temukan kebutuhan yang kamu perlukan
                    di UBB Nextmart.
                </p>

            </div>

            <a href="#"
               class="hidden sm:inline-flex
                      items-center gap-2
                      font-semibold text-[#102A71]
                      hover:text-[#001840]
                      transition">

                Lihat Semua

                <span>→</span>

            </a>

        </div>


        {{-- =================================================
             PRODUCTS DARI DATABASE
        ================================================== --}}

        @if(isset($products) && $products->count())

            <div class="grid grid-cols-2
                        md:grid-cols-3
                        lg:grid-cols-4 gap-5">

                @foreach($products as $product)

                    <div class="bg-white rounded-2xl
                                border border-gray-100
                                overflow-hidden
                                hover:shadow-xl
                                hover:-translate-y-1
                                transition-all duration-300">

                        <div class="aspect-square bg-gray-100">

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">

                            @else

                                <div class="w-full h-full
                                            flex items-center justify-center
                                            text-gray-400">

                                    Tidak ada gambar

                                </div>

                            @endif

                        </div>


                        <div class="p-4">

                            <h3 class="font-bold text-[#001840]
                                       truncate">

                                {{ $product->name }}

                            </h3>

                            <p class="text-[#102A71]
                                      font-bold mt-2">

                                Rp {{ number_format($product->price, 0, ',', '.') }}

                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- =================================================
                 DUMMY PRODUCTS
            ================================================== --}}

            <div class="grid grid-cols-2
                        md:grid-cols-3
                        lg:grid-cols-4 gap-5">

                @php

                    $dummyProducts = [
                        [
                            'name' => 'Produk UBB Mart',
                            'price' => 15000,
                            'image' => 'images/ubbmart-dalam.png'
                        ],
                        [
                            'name' => 'Layanan Printing',
                            'price' => 5000,
                            'image' => 'images/ubbmart-depan.png'
                        ],
                        [
                            'name' => 'Kebutuhan Mahasiswa',
                            'price' => 10000,
                            'image' => 'images/ubbmart-dalam.png'
                        ],
                        [
                            'name' => 'Makanan & Minuman',
                            'price' => 12000,
                            'image' => 'images/ubbmart-depan.png'
                        ],
                        [
                            'name' => 'Alat Tulis',
                            'price' => 8000,
                            'image' => 'images/ubbmart-dalam.png'
                        ],
                        [
                            'name' => 'Jasa Printing',
                            'price' => 3000,
                            'image' => 'images/ubbmart-depan.png'
                        ],
                        [
                            'name' => 'Snack Mahasiswa',
                            'price' => 7000,
                            'image' => 'images/ubbmart-dalam.png'
                        ],
                        [
                            'name' => 'Minuman',
                            'price' => 10000,
                            'image' => 'images/ubbmart-depan.png'
                        ],
                    ];

                @endphp


                @foreach($dummyProducts as $product)

                    <div class="bg-white rounded-2xl
                                border border-gray-100
                                overflow-hidden
                                hover:shadow-xl
                                hover:-translate-y-1
                                transition-all duration-300">

                        <div class="aspect-square bg-gray-100">

                            <img
                                src="{{ asset($product['image']) }}"
                                alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover">

                        </div>


                        <div class="p-4">

                            <h3 class="font-bold text-[#001840]
                                       truncate">

                                {{ $product['name'] }}

                            </h3>

                            <p class="text-[#102A71]
                                      font-bold mt-2">

                                Rp {{ number_format($product['price'], 0, ',', '.') }}

                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

    </div>

</section>

@endsection