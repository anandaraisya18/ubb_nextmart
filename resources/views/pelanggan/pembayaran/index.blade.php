@extends('pelanggan.layouts.app')

@section('title', 'Pembayaran - UBB Nextmart')

@section('content')

@php
    $noResi = session('pesanan_terakhir');

    $pesanan = $noResi
        ? \App\Models\Pesanan::where('no_resi', $noResi)->first()
        : null;
@endphp

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-[#001840] text-white">
        <div class="max-w-5xl mx-auto px-5 md:px-8 py-8">
            <p class="text-[#F5C400] text-sm font-semibold">
                UBB NEXTMART
            </p>

            <h1 class="text-2xl md:text-3xl font-bold mt-1">
                Pembayaran
            </h1>

            <p class="text-white/60 text-sm mt-2">
                Lakukan pembayaran dan unggah bukti pembayaran
                untuk menyelesaikan pesanan.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-5 md:px-8 py-8">

        @if (!$pesanan)
            <div class="bg-white border border-red-200 rounded-2xl p-6 text-center">
                <h2 class="font-bold text-red-700">
                    Pesanan tidak ditemukan
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Silakan lakukan checkout terlebih dahulu.
                </p>

                <a
                    href="{{ route('pelanggan.keranjang.index') }}"
                    class="inline-block mt-5 px-5 py-3 rounded-xl bg-[#001840] text-white text-sm font-semibold"
                >
                    Kembali ke Keranjang
                </a>
            </div>
        @else

            {{-- Informasi Pesanan --}}
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-yellow-50 border border-yellow-200 mb-6">
                <div class="w-10 h-10 rounded-full bg-[#F5C400]/20 flex items-center justify-center shrink-0">
                    <svg
                        class="w-5 h-5 text-[#102A71]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-[#001840] text-sm">
                        {{ $pesanan->status_pesanan === 'menunggu_pembayaran'
                            ? 'Menunggu Pembayaran'
                            : ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Nomor Pesanan: {{ $pesanan->no_resi }}
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">

                {{-- Detail Pembayaran --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="font-bold text-[#001840] text-lg">
                        Pembayaran QRIS
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Scan QRIS menggunakan aplikasi pembayaran.
                    </p>

                    <div class="mt-6 rounded-2xl bg-gray-50 border border-gray-200 p-6 flex items-center justify-center">
                        <div class="w-52 h-52 bg-white border-4 border-[#001840] rounded-xl flex items-center justify-center text-center p-5">
                            <div>
                                <svg
                                    class="w-16 h-16 mx-auto text-[#001840]"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    viewBox="0 0 24 24"
                                >
                                    <rect x="4" y="4" width="6" height="6"/>
                                    <rect x="14" y="4" width="6" height="6"/>
                                    <rect x="4" y="14" width="6" height="6"/>
                                    <path d="M14 14h3v3h-3z"/>
                                    <path d="M20 17v3h-3"/>
                                </svg>

                                <p class="text-xs text-gray-500 mt-2">
                                    QRIS
                                </p>

                                <p class="text-[10px] text-red-500 mt-1">
                                    Ganti dengan QRIS asli
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Dinamis --}}
                    <div class="mt-5 p-4 rounded-xl bg-[#001840] text-white">
                        <p class="text-xs text-white/60">
                            Total Pembayaran
                        </p>

                        <p class="text-2xl font-bold text-[#F5C400] mt-1">
                            Rp{{ number_format($pesanan->total, 0, ',', '.') }}
                        </p>

                        <p class="text-xs text-white/60 mt-2">
                            Sesuai total pesanan {{ $pesanan->no_resi }}
                        </p>
                    </div>
                </div>

                {{-- Upload Bukti --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="font-bold text-[#001840] text-lg">
                        Upload Bukti Pembayaran
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Upload bukti pembayaran setelah transaksi berhasil.
                    </p>

                    <form
                        action="{{ route('pelanggan.pembayaran.bukti') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-6"
                    >
                        @csrf

                        <label
                            for="proof"
                            class="block text-sm font-semibold text-[#001840] mb-2"
                        >
                            Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            id="proof"
                            name="proof"
                            accept="image/jpeg,image/png,image/jpg"
                            required
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-[#001840] file:px-3 file:py-2 file:text-white"
                        >

                        <p class="text-xs text-gray-400 mt-2">
                            Format yang diperbolehkan: JPG, JPEG, PNG.
                        </p>

                        <div class="mt-6 p-4 rounded-xl bg-[#102A71]/5 border border-[#102A71]/10">
                            <div class="flex gap-3">
                                <svg
                                    class="w-5 h-5 text-[#102A71] shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 11v5"/>
                                    <circle cx="12" cy="8" r=".7" fill="currentColor"/>
                                </svg>

                                <p class="text-xs text-gray-600 leading-relaxed">
                                    Setelah bukti pembayaran dikirim,
                                    pesanan akan menunggu verifikasi admin.
                                </p>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full mt-6 py-3.5 rounded-xl bg-[#F5C400] text-[#001840] font-bold text-sm hover:bg-yellow-300 transition"
                        >
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection