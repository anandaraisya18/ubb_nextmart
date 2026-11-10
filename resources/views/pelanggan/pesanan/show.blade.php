 @extends('pelanggan.layouts.app')

@section('title', 'Detail Pesanan ' . $pesanan->no_resi . ' - UBB Nextmart')

@section('content')

@php
    $diantar = $pesanan->jenis_pengambilan === 'diantar';

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
            $diantar ? 'Siap Diantar' : 'Siap Diambil',
            $diantar
                ? 'Pesanan siap dan akan segera diantar.'
                : 'Pesanan siap, silakan ambil di tempat.',
        ],
        'selesai' => [
            'Selesai',
            'Pesanan sudah diterima.',
        ],
    ];

    $keys = array_keys($tahap);
    $status = $pesanan->status_pesanan;
    $dibatalkan = $status === 'dibatalkan';

    $indeks = array_search($status, $keys);
    $indeks = $indeks === false ? 0 : $indeks;

    $statusLabel = \App\Models\Pesanan::STATUS[$status] ?? ucfirst($status);

    $pengambilanLabel = \App\Models\Pesanan::PENGAMBILAN[
        $pesanan->jenis_pengambilan
    ] ?? $pesanan->jenis_pengambilan;

    $tipeTransaksiLabel = \App\Models\Pesanan::TIPE[
        $pesanan->tipe_transaksi
    ] ?? ucfirst($pesanan->tipe_transaksi);
@endphp

<div class="min-h-screen bg-slate-50">

    {{-- Header --}}
    <section class="relative overflow-hidden bg-[#001840] text-white">

        <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-[#102A71] blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-32 w-96 h-96 rounded-full bg-[#F5C400]/10 blur-3xl"></div>

        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">

            <a href="{{ route('pelanggan.pesanan.lacak') }}"
               class="inline-flex items-center gap-2 text-sm text-white/60 hover:text-white transition mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5" stroke-linecap="round"/>
                    <path d="M11 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke Lacak Pesanan
            </a>

            <div class="flex justify-center mb-6">
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

            <div class="text-center">
                <p class="text-[11px] text-[#F5C400] font-semibold uppercase tracking-[0.18em]">
                    UBB Nextmart
                </p>

                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mt-2">
                    Detail Pesanan
                </h1>

                <p class="mt-2 text-sm text-white/60">
                    Informasi lengkap pesanan dan progresnya.
                </p>
            </div>

        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Card Utama --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">

            {{-- Ringkasan Pesanan --}}
            <div class="p-5 sm:p-6">

                <div class="flex flex-wrap items-start justify-between gap-4">

                    <div>
                        <p class="text-xs text-gray-500">Nomor Resi</p>

                        <p class="text-lg font-bold text-[#001840]">
                            {{ $pesanan->no_resi ?: 'Belum tersedia' }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Dipesan
                            {{ optional($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>

                    <div class="text-left sm:text-right">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                            {{ $dibatalkan
                                ? 'bg-red-50 text-red-600'
                                : ($status === 'selesai'
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-yellow-50 text-yellow-700') }}">
                            {{ $statusLabel }}
                        </span>

                        <p class="text-xs text-gray-500 mt-2">Total Pesanan</p>

                        <p class="text-lg font-extrabold text-[#102A71]">
                            Rp{{ number_format($pesanan->total, 0, ',', '.') }}
                        </p>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-3 mt-5">

                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-xs text-gray-500">Tipe Transaksi</p>
                        <p class="text-sm font-semibold text-[#001840] mt-1">
                            {{ $tipeTransaksiLabel }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-xs text-gray-500">Pengambilan</p>
                        <p class="text-sm font-semibold text-[#001840] mt-1">
                            {{ $pengambilanLabel }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Detail Produk --}}
            <div class="p-5 sm:p-6">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-[#001840]">
                        Produk yang Dibeli
                    </h2>

                    <span class="text-xs text-gray-400">
                        {{ $pesanan->detail->count() }} item
                    </span>
                </div>

                <div class="divide-y divide-gray-100">

                    @forelse($pesanan->detail as $detail)

                        @php
                            $produk = $detail->produk;
                        @endphp

                        <div class="flex gap-3 py-3 first:pt-0 last:pb-0">

                            {{-- Gambar Produk --}}
                            <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 rounded-lg bg-slate-50 border border-gray-100 overflow-hidden flex items-center justify-center">

                                @if($produk && $produk->gambar)

                                    <img
                                        src="{{ asset('storage/' . $produk->gambar) }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M3 7h18v13H3z" stroke-linejoin="round"/>
                                        <path d="M3 7l3-4h12l3 4" stroke-linejoin="round"/>
                                        <path d="M9 11h6" stroke-linecap="round"/>
                                    </svg>

                                @endif

                            </div>

                            {{-- Informasi Produk --}}
                            <div class="flex-1 min-w-0">

                                <p class="text-sm font-semibold text-[#001840] leading-snug">
                                    {{ $produk->nama_produk ?? 'Produk tidak tersedia' }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $detail->jumlah }} ×
                                    Rp{{ number_format($detail->harga, 0, ',', '.') }}
                                </p>

                                <p class="text-sm font-bold text-[#102A71] mt-1.5">
                                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <p class="text-sm text-gray-400 py-4">
                            Tidak ada detail produk pada pesanan ini.
                        </p>

                    @endforelse

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Informasi Pembayaran --}}
            <div class="p-5 sm:p-6">

                <h2 class="text-sm font-bold text-[#001840] mb-4">
                    Informasi Pembayaran
                </h2>

                <div class="space-y-3">

                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">Status Pembayaran</span>

                        <span class="font-semibold text-[#001840] text-right">
                            @if($status === 'menunggu_pembayaran')
                                Belum Dibayar
                            @elseif($status === 'menunggu_verifikasi')
                                Menunggu Verifikasi
                            @elseif($status === 'dibatalkan')
                                Dibatalkan
                            @else
                                {{ $statusLabel }}
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">Subtotal Produk</span>

                        <span class="font-medium text-[#001840]">
                            Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4 text-sm">
                        <span class="text-gray-500">Total Pembayaran</span>

                        <span class="font-bold text-[#102A71]">
                            Rp{{ number_format($pesanan->total, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                {{-- Bukti Pembayaran --}}
                <div class="mt-4 pt-4 border-t border-gray-100">

                    <p class="text-xs text-gray-500 mb-2">
                        Bukti Pembayaran
                    </p>

                    @if($pesanan->bukti_pembayaran)

                        <a
                            href="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 3h7v7" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 14L21 3" stroke-linecap="round"/>
                                <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5" stroke-linecap="round"/>
                            </svg>

                            Lihat Bukti Pembayaran
                        </a>

                    @else

                        <p class="text-xs text-gray-400">
                            Belum ada bukti pembayaran yang diunggah.
                        </p>

                    @endif

                </div>

            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Progress Pesanan --}}
            <div class="p-5 sm:p-6">

                <h2 class="text-sm font-bold text-[#001840] mb-5">
                    Progres Pesanan
                </h2>

                @if($dibatalkan)

                    <div class="flex items-start gap-3 rounded-lg bg-red-50 border border-red-100 p-3">

                        <div class="w-8 h-8 shrink-0 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">
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

                        @foreach($tahap as $key => [$judul, $deskripsi])

                            @php
                                $i = $loop->index;

                                $selesai = $i < $indeks || $status === 'selesai';

                                $aktif = $i === $indeks && $status !== 'selesai';

                                $terakhir = $loop->last;
                            @endphp

                            <li class="relative flex gap-3 {{ $terakhir ? '' : 'pb-6' }}">

                                @unless($terakhir)

                                    <span class="absolute left-[15px] top-8 -bottom-0 w-0.5
                                        {{ $i < $indeks || $status === 'selesai'
                                            ? 'bg-[#102A71]'
                                            : 'bg-gray-200' }}">
                                    </span>

                                @endunless

                                <div class="relative z-10 w-8 h-8 shrink-0 rounded-full flex items-center justify-center text-xs font-bold border-2
                                    {{ $selesai
                                        ? 'bg-[#102A71] border-[#102A71] text-white'
                                        : ($aktif
                                            ? 'bg-[#F5C400] border-[#F5C400] text-[#001840] ring-4 ring-[#F5C400]/20'
                                            : 'bg-white border-gray-200 text-gray-300') }}">

                                    @if($selesai)
                                        ✓
                                    @else
                                        {{ $i + 1 }}
                                    @endif

                                </div>

                                <div class="pt-1">

                                    <p class="text-sm font-bold
                                        {{ $selesai || $aktif
                                            ? 'text-[#001840]'
                                            : 'text-gray-400' }}">

                                        {{ $judul }}

                                        @if($aktif)

                                            <span class="ml-1.5 rounded-full bg-[#F5C400]/20 px-2 py-0.5 text-[10px] font-semibold text-[#8a6d00]">
                                                Saat ini
                                            </span>

                                        @endif

                                    </p>

                                    <p class="mt-0.5 text-xs
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

        </div>

    </section>

</div>

@endsection