@extends('pelanggan.layouts.app')

@section('title', 'Lacak Pesanan - UBB Nextmart')

@section('content')

@php
    $tahap = [
        'menunggu_pembayaran' => [
            'Menunggu Pembayaran',
            'Selesaikan pembayaran agar pesanan bisa diproses.',
        ],
        'menunggu_verifikasi' => [
            'Menunggu Verifikasi',
            'Pembayaranmu sedang dicek oleh toko.',
        ],
        'diproses' => [
            'Diproses',
            'Toko sedang menyiapkan pesananmu.',
        ],
        'siap_diambil' => [
            'Siap Diambil',
            'Pesanan siap, silakan ambil di tempat.',
        ],
        'selesai' => [
            'Selesai',
            'Pesanan sudah diterima. Terima kasih sudah berbelanja!',
        ],
    ];

    $statusLabels = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses' => 'Diproses',
        'siap_diambil' => 'Siap Diambil',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

<div class="min-h-screen bg-slate-50">

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#001840] text-white">

        <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-[#102A71] blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-32 w-96 h-96 rounded-full bg-[#F5C400]/10 blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            {{-- NAVIGATION --}}
            <div class="flex justify-center mb-8">

                <div class="inline-flex p-1 rounded-xl bg-white/5 border border-white/10 text-sm font-medium">

                    <a href="{{ route('pelanggan.pesanan.lacak') }}"
                       class="px-5 py-2 rounded-lg bg-[#F5C400] text-[#001840] font-semibold">
                        Lacak Pesanan
                    </a>

                    <a href="{{ route('pelanggan.pesanan.riwayat') }}"
                       class="px-5 py-2 rounded-lg text-white/70 hover:text-white transition">
                        Riwayat
                    </a>

                </div>

            </div>

            {{-- TITLE --}}
            <div class="text-center">

                <p class="text-[11px] text-[#F5C400] font-semibold uppercase tracking-[0.18em]">
                    UBB Nextmart
                </p>

                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mt-2">
                    Lacak Pesanan
                </h1>

                <p class="max-w-xl mx-auto text-sm sm:text-base text-white/55 mt-3 leading-relaxed">
                    Pantau perkembangan pesananmu melalui akun UBB Nextmart.
                </p>

            </div>

        </div>

    </section>


    {{-- ORDER LIST --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if($pesanans->isEmpty())

            {{-- EMPTY STATE --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8 sm:p-12 text-center">

                <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-2xl bg-[#001840]/5 text-[#001840]">

                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                         stroke-width="1.7" viewBox="0 0 24 24">

                        <path d="M6 7h12l1 13H5L6 7Z"
                              stroke-linejoin="round"/>

                        <path d="M9 7V5a3 3 0 0 1 6 0v2"
                              stroke-linecap="round"/>

                    </svg>

                </div>

                <h2 class="text-xl font-bold text-[#001840] mt-5">
                    Belum Ada Pesanan Aktif
                </h2>

                <p class="max-w-md mx-auto text-sm text-slate-500 mt-2 leading-relaxed">
                    Pesanan yang sedang diproses akan muncul di halaman ini.
                    Yuk, temukan produk favoritmu di UBB Nextmart!
                </p>

                <div class="flex flex-wrap justify-center gap-3 mt-6">

                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#F5C400] text-[#001840] font-bold text-sm transition hover:bg-[#e4b900]">

                        Lihat Produk

                    </a>

                    <a href="{{ route('pelanggan.pesanan.riwayat') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-slate-200 text-[#001840] font-semibold text-sm transition hover:bg-slate-50">

                        Riwayat Pesanan

                    </a>

                </div>

            </div>

        @else

            {{-- SECTION HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-6">

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-[#102A71]">
                        Status Pesanan
                    </p>

                    <h2 class="text-xl sm:text-2xl font-bold text-[#001840] mt-1">
                        Pesanan yang Sedang Berjalan
                    </h2>

                </div>

                <p class="text-xs text-slate-500">
                    {{ $pesanans->count() }} pesanan aktif
                </p>

            </div>


            {{-- ORDER CARDS --}}
            <div class="space-y-5">

                @foreach($pesanans as $pesanan)

                    @php
                        $status = $pesanan->status_pesanan;

                        $diantar = $pesanan->jenis_pengambilan === 'diantar';

                        $tahapPesanan = $tahap;

                        if ($diantar) {
                            $tahapPesanan['siap_diambil'] = [
                                'Siap Diantar',
                                'Pesanan siap dan akan segera diantar.',
                            ];
                        }

                        $keys = array_keys($tahapPesanan);

                        $dibatalkan = $status === 'dibatalkan';

                        $indeks = array_search($status, $keys);

                        $indeks = $indeks === false ? 0 : $indeks;

                        $statusLabel = $statusLabels[$status]
                            ?? ucfirst(str_replace('_', ' ', $status));

                        $statusDescription = $tahapPesanan[$status][1]
                            ?? 'Status pesananmu sedang diperbarui.';
                    @endphp


                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">

                        {{-- ORDER HEADER --}}
                        <div class="flex flex-wrap items-start justify-between gap-4 p-5 sm:p-6 border-b border-gray-100">

                            <div>

                                <p class="text-xs text-gray-500">
                                    Nomor Pesanan
                                </p>

                                <p class="text-lg font-bold text-[#001840] mt-1">
                                    #{{ $pesanan->id_pesanan }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">

                                    @if($pesanan->tanggal_pesanan)
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i') }}
                                    @else
                                        Tanggal tidak tersedia
                                    @endif

                                </p>

                            </div>


                            {{-- STATUS BADGE --}}
                            <span class="inline-flex items-center gap-2 w-fit rounded-full px-3 py-1.5 text-xs font-bold

                                @if($dibatalkan)
                                    bg-red-50 text-red-600
                                @elseif($status === 'selesai')
                                    bg-green-50 text-green-700
                                @elseif($status === 'siap_diambil')
                                    bg-blue-50 text-blue-700
                                @else
                                    bg-amber-50 text-amber-700
                                @endif
                            ">

                                <span class="w-1.5 h-1.5 rounded-full

                                    @if($dibatalkan)
                                        bg-red-500
                                    @elseif($status === 'selesai')
                                        bg-green-500
                                    @elseif($status === 'siap_diambil')
                                        bg-blue-500
                                    @else
                                        bg-amber-500
                                    @endif
                                "></span>

                                {{ $statusLabel }}

                            </span>

                        </div>


                        {{-- ORDER SUMMARY --}}
                        <div class="p-5 sm:p-6">

                            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">

                                <div>

                                    <h3 class="text-sm font-bold text-[#001840]">
                                        {{ $statusLabel }}
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                                        {{ $statusDescription }}
                                    </p>

                                </div>

                                <div class="text-right">

                                    <p class="text-xs text-gray-500">
                                        Total Pesanan
                                    </p>

                                    <p class="text-lg font-extrabold text-[#102A71] mt-1">
                                        Rp{{ number_format($pesanan->total, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>


                            {{-- PROGRESS LINE --}}
                            <div class="rounded-xl border border-gray-100 bg-slate-50 p-5 sm:p-6">

                                <h4 class="text-sm font-bold text-[#001840] mb-6">
                                    Progres Pesanan
                                </h4>

                                @if($dibatalkan)

                                    {{-- CANCELLED --}}
                                    <div class="flex items-start gap-4 rounded-xl bg-red-50 border border-red-100 p-4">

                                        <div class="w-9 h-9 shrink-0 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">
                                            ✕
                                        </div>

                                        <div>

                                            <p class="text-sm font-bold text-red-600">
                                                Pesanan Dibatalkan
                                            </p>

                                            <p class="mt-0.5 text-xs text-red-500/80">
                                                Pesanan ini tidak diproses lebih lanjut.
                                            </p>

                                        </div>

                                    </div>

                                @else

                                    <ol class="relative">

                                        @foreach($tahapPesanan as $key => [$judul, $deskripsi])

                                            @php
                                                $i = $loop->index;

                                                $selesai = $i < $indeks || $status === 'selesai';

                                                $aktif = $i === $indeks && $status !== 'selesai';

                                                $terakhir = $loop->last;
                                            @endphp

                                            <li class="relative flex gap-4 {{ $terakhir ? '' : 'pb-8' }}">

                                                {{-- VERTICAL LINE --}}
                                                @unless($terakhir)

                                                    <span class="absolute left-[17px] top-9 -bottom-0 w-0.5

                                                        {{ $i < $indeks || $status === 'selesai'
                                                            ? 'bg-[#102A71]'
                                                            : 'bg-gray-200' }}">

                                                    </span>

                                                @endunless


                                                {{-- STEP ICON --}}
                                                <div class="relative z-10 w-9 h-9 shrink-0 rounded-full flex items-center justify-center text-sm font-bold border-2

                                                    {{ $selesai
                                                        ? 'bg-[#102A71] border-[#102A71] text-white'
                                                        : ($aktif
                                                            ? 'bg-[#F5C400] border-[#F5C400] text-[#001840] ring-4 ring-[#F5C400]/25'
                                                            : 'bg-white border-gray-200 text-gray-300') }}">

                                                    @if($selesai)

                                                        <svg class="w-4 h-4" fill="none"
                                                             stroke="currentColor" stroke-width="2.5"
                                                             viewBox="0 0 24 24">

                                                            <path d="m5 12 4 4L19 6"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"/>

                                                        </svg>

                                                    @else

                                                        {{ $i + 1 }}

                                                    @endif

                                                </div>


                                                {{-- STEP DESCRIPTION --}}
                                                <div class="pt-1.5">

                                                    <p class="text-sm font-bold

                                                        {{ $selesai || $aktif
                                                            ? 'text-[#001840]'
                                                            : 'text-gray-400' }}">

                                                        {{ $judul }}

                                                        @if($aktif)

                                                            <span class="ml-2 rounded-full bg-[#F5C400]/20 px-2 py-0.5 text-[10px] font-semibold text-[#8a6d00]">
                                                                Saat ini
                                                            </span>

                                                        @endif

                                                    </p>

                                                    <p class="mt-0.5 text-xs leading-relaxed

                                                        {{ $selesai || $aktif
                                                            ? 'text-gray-500'
                                                            : 'text-gray-300' }}">

                                                        {{ $deskripsi }}

                                                    </p>

                                                </div>

                                            </li>

                                        @endforeach

                                    </ol>

                                @endif

                            </div>


                            {{-- ORDER FOOTER --}}
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-6 pt-5 border-t border-slate-100">

                                <div>

                                    <p class="text-xs text-slate-400">
                                        Nomor Resi
                                    </p>

                                    <p class="text-sm font-semibold text-[#001840] mt-1">

                                        {{ $pesanan->no_resi ?: 'Belum tersedia' }}

                                    </p>

                                </div>


                                {{-- DETAIL BUTTON --}}
                                <a href="{{ route('pelanggan.pesanan.show', ['id' => $pesanan->id_pesanan]) }}"
                                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#001840] text-white text-xs font-bold transition hover:bg-[#102A71]">

                                    Detail Pesanan

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                         stroke-width="2" viewBox="0 0 24 24">

                                        <path d="M5 12h14M13 6l6 6-6 6"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>

                                    </svg>

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </section>


    {{-- FOOTER --}}
    <section class="bg-white border-t border-gray-200">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5">

            <div>

                <p class="text-sm font-bold text-[#001840]">
                    Butuh bantuan dengan pesananmu?
                </p>

                <p class="text-xs text-gray-500 mt-1">
                    Hubungi pengelola toko jika mengalami kendala.
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                <a href="{{ route('pelanggan.pesanan.riwayat') }}"
                   class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-[#001840] hover:bg-slate-50 transition">

                    Riwayat Pesanan

                </a>

                <a href="{{ route('pelanggan.kontak') }}"
                   class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-[#001840] hover:bg-slate-50 transition">

                    Hubungi Kami

                </a>

            </div>

        </div>

    </section>

</div>

@endsection
