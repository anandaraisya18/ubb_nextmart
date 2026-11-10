
@extends('pelanggan.layouts.app')

@section('title', 'Hubungi Kami - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-gray-50 py-12">

    <div class="max-w-5xl mx-auto px-5">

        {{-- HEADER --}}
        <div class="text-center mb-10">

            <div class="w-16 h-16 bg-[#001840] rounded-2xl
                        flex items-center justify-center
                        mx-auto mb-5">

                <svg class="w-8 h-8 text-[#F5C400]"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     viewBox="0 0 24 24">

                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8
                             8.5 8.5 0 0 1-7.6 4.7
                             8.38 8.38 0 0 1-3.8-.9L3 21
                             l1.9-5.7a8.38 8.38 0 0 1-.9-3.8
                             8.5 8.5 0 0 1 4.7-7.6
                             8.38 8.38 0 0 1 3.8-.9h.5
                             a8.48 8.48 0 0 1 8 8v.5z"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

            </div>

            <h1 class="text-3xl font-bold text-[#001840]">
                Hubungi Kami
            </h1>

            <p class="text-gray-500 mt-3 max-w-xl mx-auto">
                Butuh bantuan terkait produk, pembayaran,
                atau pesanan? Temukan informasi bantuan
                UBB Nextmart di halaman ini.
            </p>

        </div>


        {{-- INFORMASI BANTUAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- BANTUAN PESANAN --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        p-7 shadow-sm">

                <div class="w-12 h-12 bg-blue-50 rounded-xl
                            flex items-center justify-center mb-5">

                    <svg class="w-6 h-6 text-[#102A71]"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         viewBox="0 0 24 24">

                        <path d="M6 3h12v18H6z"
                              stroke-linejoin="round"/>

                        <path d="M9 7h6M9 11h6M9 15h4"
                              stroke-linecap="round"/>
                    </svg>

                </div>

                <h2 class="text-lg font-bold text-[#001840] mb-2">
                    Bantuan Pesanan
                </h2>

                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Ingin mengetahui perkembangan pesanan?
                    Gunakan fitur lacak pesanan untuk melihat
                    status pembayaran dan proses pesanan.
                </p>

                <a href="{{ route('pelanggan.pesanan.lacak') }}"
                   class="inline-flex items-center gap-2
                          bg-[#001840] text-white text-sm font-semibold
                          px-5 py-3 rounded-xl
                          hover:bg-[#102A71] transition">

                    Lacak Pesanan

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path d="M5 12h14m-6-6 6 6-6 6"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                </a>

            </div>


            {{-- INFORMASI PENGADUAN --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        p-7 shadow-sm">

                <div class="w-12 h-12 bg-yellow-50 rounded-xl
                            flex items-center justify-center mb-5">

                    <svg class="w-6 h-6 text-[#D1A000]"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         viewBox="0 0 24 24">

                        <circle cx="12" cy="12" r="10"/>

                        <path d="M9.1 9a3 3 0 0 1 5.8 1
                                 c0 2-3 3-3 3"
                              stroke-linecap="round"/>

                        <path d="M12 17h.01"
                              stroke-linecap="round"/>
                    </svg>

                </div>

                <h2 class="text-lg font-bold text-[#001840] mb-2">
                    Pertanyaan dan Pengaduan
                </h2>

                <p class="text-sm text-gray-500 leading-relaxed mb-4">
                    Jika mengalami kendala dalam proses pemesanan,
                    siapkan informasi berikut agar pengelola
                    toko dapat membantu pemeriksaan.
                </p>

                <ul class="text-sm text-gray-600 space-y-2">

                    <li class="flex gap-2">
                        <span class="text-[#D1A000] font-bold">✓</span>
                        Nomor resi pesanan
                    </li>

                    <li class="flex gap-2">
                        <span class="text-[#D1A000] font-bold">✓</span>
                        Nama pemesan
                    </li>

                    <li class="flex gap-2">
                        <span class="text-[#D1A000] font-bold">✓</span>
                        Penjelasan kendala yang dialami
                    </li>

                </ul>

            </div>

        </div>


        {{-- STATUS BANTUAN --}}
        <div class="bg-white border border-gray-200
                    rounded-2xl p-7 mb-8">

            <h2 class="text-lg font-bold text-[#001840] mb-3">
                Kontak Pengelola
            </h2>

            <p class="text-sm text-gray-600 leading-relaxed">
                Informasi nomor WhatsApp atau email pengelola
                toko belum ditambahkan ke halaman ini.
                Saluran kontak resmi akan ditampilkan
                setelah tersedia.
            </p>

        </div>


        {{-- INFORMASI TAMBAHAN --}}
        <div class="bg-[#001840] rounded-2xl p-8
                    text-white text-center">

            <h2 class="text-xl font-bold mb-3">
                Masih membutuhkan informasi?
            </h2>

            <p class="text-sm text-white/70
                      max-w-lg mx-auto mb-6 leading-relaxed">

                Kamu juga dapat melihat daftar produk dan
                informasi toko yang tersedia di UBB Nextmart.

            </p>

            <a href="{{ route('pelanggan.dashboard') }}"
               class="inline-flex items-center justify-center
                      gap-2 bg-[#F5C400] text-[#001840]
                      px-6 py-3 rounded-xl
                      text-sm font-bold
                      hover:bg-yellow-400 transition">

                Kembali ke Beranda

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path d="M5 12h14m-6-6 6 6-6 6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

            </a>

        </div>

    </div>

</div>

@endsection
