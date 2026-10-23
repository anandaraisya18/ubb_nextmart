@extends('pelanggan.layouts.app')

@section('title', 'Resi Digital - UBB Nextmart')

@section('content')

@php
    $noResi = request('no_resi') ?: session('pesanan_terakhir');

    $pesanan = $noResi
        ? \App\Models\Pesanan::with(['pelanggan', 'detail.produk.toko'])
            ->where('no_resi', $noResi)
            ->first()
        : null;

    $kolomNama = \Illuminate\Support\Facades\Schema::hasColumn('pelanggan', 'nama_pelanggan')
        ? 'nama_pelanggan'
        : 'nama';

    $kolomTelepon = collect(['no_hp', 'telepon', 'no_telp', 'no_telepon'])
        ->first(fn ($kolom) => \Illuminate\Support\Facades\Schema::hasColumn('pelanggan', $kolom));

    $items = $pesanan
        ? $pesanan->detail
        : collect();

    $namaToko = $items
        ->map(fn ($item) => $item->produk->toko->nama_toko ?? null)
        ->filter()
        ->unique()
        ->implode(', ');

    $statusLabel = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses' => 'Diproses',
        'dikirim' => 'Dikirim',
        'siap_diambil' => 'Siap Diambil',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $status = $pesanan
        ? ($statusLabel[$pesanan->status_pesanan] ?? ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)))
        : '';
@endphp

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-[#001840] text-white">
        <div class="max-w-5xl mx-auto px-5 md:px-8 py-8">

            <div class="flex items-center gap-3 mb-4">
                <a
                    href="{{ route('pelanggan.pesanan.index') }}"
                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M19 12H5" stroke-linecap="round"/>
                        <path d="M11 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <span class="text-sm text-white/60">
                    Kembali ke Pesanan
                </span>
            </div>

            <p class="text-[#F5C400] text-sm font-semibold">
                UBB NEXTMART
            </p>

            <h1 class="text-2xl md:text-3xl font-bold mt-1">
                Resi Digital
            </h1>

            <p class="text-white/60 text-sm mt-2">
                Bukti transaksi dan informasi pesanan kamu.
            </p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-5 md:px-8 py-8">

        @if (!$pesanan)

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center">
                <div class="w-14 h-14 mx-auto rounded-full bg-yellow-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-[#102A71]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v4m0 4h.01"/>
                    </svg>
                </div>

                <h2 class="text-lg font-bold text-[#001840] mt-4">
                    Resi tidak ditemukan
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Silakan pilih pesanan dari daftar pesanan kamu untuk melihat resi digital.
                </p>

                <a
                    href="{{ route('pelanggan.pesanan.index') }}"
                    class="inline-block mt-6 px-5 py-3 rounded-xl bg-[#001840] text-white text-sm font-semibold hover:bg-[#102A71] transition"
                >
                    Lihat Pesanan
                </a>
            </div>

        @else

            {{-- Receipt --}}
            <div
                id="receipt"
                class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden"
            >

                {{-- Receipt Header --}}
                <div class="bg-[#001840] text-white px-6 md:px-8 py-7">
                    <div class="flex items-center justify-between gap-4">

                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-[#102A71] border border-[#F5C400]/30 flex items-center justify-center">
                                <img
                                    src="{{ asset('images/logoubb.png') }}"
                                    alt="UBB Nextmart"
                                    class="w-8 h-8 object-contain"
                                >
                            </div>

                            <div>
                                <p class="font-bold text-sm">
                                    UBB Nextmart
                                </p>

                                <p class="text-[10px] text-white/50">
                                    Resi Digital
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-[10px] text-white/50 uppercase tracking-wider">
                                Status Pesanan
                            </p>

                            <p class="text-sm font-semibold text-[#F5C400] mt-1">
                                {{ $status }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Receipt Body --}}
                <div class="p-6 md:p-8">

                    {{-- Nomor Pesanan --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-6 border-b border-dashed border-gray-300">

                        <div>
                            <p class="text-[11px] text-gray-400 uppercase tracking-wider">
                                Nomor Pesanan
                            </p>

                            <p class="text-xl font-bold text-[#001840] mt-1 break-all">
                                {{ $pesanan->no_resi }}
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-[11px] text-gray-400">
                                Tanggal Pesanan
                            </p>

                            <p class="text-sm font-semibold text-gray-700 mt-1">
                                {{ $pesanan->tanggal_pesanan
                                    ? \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i')
                                    : '-' }}
                            </p>
                        </div>

                    </div>

                    {{-- Pembeli --}}
                    <div class="py-6 border-b border-gray-100">

                        <h2 class="text-sm font-bold text-[#001840] mb-4">
                            Informasi Pembeli
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-5">

                            <div>
                                <p class="text-[11px] text-gray-400">
                                    Nama
                                </p>

                                <p class="text-sm text-gray-700 font-medium mt-1">
                                    {{ $pesanan->pelanggan?->{$kolomNama} ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">
                                    Nomor HP
                                </p>

                                <p class="text-sm text-gray-700 font-medium mt-1">
                                    {{ $kolomTelepon && $pesanan->pelanggan
                                        ? ($pesanan->pelanggan->{$kolomTelepon} ?? '-')
                                        : '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">
                                    Email
                                </p>

                                <p class="text-sm text-gray-700 font-medium mt-1 break-all">
                                    {{ $pesanan->pelanggan->email ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[11px] text-gray-400">
                                    Toko
                                </p>

                                <p class="text-sm text-gray-700 font-medium mt-1">
                                    {{ $namaToko ?: '-' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Produk --}}
                    <div class="py-6 border-b border-gray-100">

                        <h2 class="text-sm font-bold text-[#001840] mb-4">
                            Detail Produk
                        </h2>

                        <div class="space-y-5">

                            @forelse ($items as $item)

                                @php
                                    $namaProduk = $item->produk->nama_produk ?? 'Produk';
                                    $jumlah = (int) $item->jumlah;
                                    $harga = (int) $item->harga;
                                    $subtotalItem = (int) $item->subtotal;
                                @endphp

                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ $namaProduk }}
                                        </p>

                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $jumlah }} × Rp{{ number_format($harga, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <p class="text-sm font-semibold text-gray-700 whitespace-nowrap">
                                        Rp{{ number_format($subtotalItem, 0, ',', '.') }}
                                    </p>

                                </div>

                            @empty

                                <p class="text-sm text-gray-500">
                                    Detail produk tidak tersedia.
                                </p>

                            @endforelse

                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="py-6 space-y-3">

                        <div class="flex justify-between items-center gap-4">
                            <span class="text-sm text-gray-500">
                                Subtotal
                            </span>

                            <span class="text-sm font-semibold text-gray-700">
                                Rp{{ number_format($pesanan->subtotal ?? $pesanan->total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center gap-4 pt-3 border-t border-gray-100">
                            <span class="text-base font-bold text-[#001840]">
                                Total Pembayaran
                            </span>

                            <span class="text-xl font-bold text-[#102A71]">
                                Rp{{ number_format($pesanan->total, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>

                    {{-- QR / Code --}}
                    <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6 text-center">

                        <div class="w-32 h-32 mx-auto bg-white border-2 border-[#001840] rounded-xl flex items-center justify-center">
                            <svg class="w-20 h-20 text-[#001840]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <rect x="4" y="4" width="6" height="6"/>
                                <rect x="14" y="4" width="6" height="6"/>
                                <rect x="4" y="14" width="6" height="6"/>
                                <path d="M14 14h3v3h-3z"/>
                                <path d="M20 17v3h-3"/>
                            </svg>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">
                            {{ $pesanan->no_resi }}
                        </p>

                        <p class="text-[10px] text-gray-400 mt-1">
                            Kode visual resi, bukan QR verifikasi pembayaran.
                        </p>

                    </div>

                    <p class="text-center text-[11px] text-gray-400 leading-relaxed mt-6">
                        Simpan resi digital ini sebagai bukti transaksi UBB Nextmart.
                    </p>

                </div>
            </div>

            {{-- Button --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-3">

                <button
                    type="button"
                    onclick="window.print()"
                    class="flex-1 py-3.5 rounded-xl bg-[#001840] text-white text-sm font-semibold hover:bg-[#102A71] transition"
                >
                    Cetak Resi
                </button>

                <a
                    href="{{ route('pelanggan.dashboard') }}"
                    class="flex-1 py-3.5 rounded-xl border border-[#102A71] text-[#102A71] text-center text-sm font-semibold hover:bg-[#102A71] hover:text-white transition"
                >
                    Kembali ke beranda
                </a>

            </div>

        @endif

    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
        }

        body * {
            visibility: hidden;
        }

        #receipt,
        #receipt * {
            visibility: visible;
        }

        #receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>

@endsection