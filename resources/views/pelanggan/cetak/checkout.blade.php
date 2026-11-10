@extends('pelanggan.layouts.app')

@section('title', 'Checkout Cetak - UBB Nextmart')

@section('content')

@php
    $rp = fn ($n) => 'Rp' . number_format($n, 0, ',', '.');
    $subBw    = $job['halaman_hitam_putih'] * $hargaBw * $job['jumlah_cetak'];
    $subWarna = $job['halaman_warna'] * $hargaWarna * $job['jumlah_cetak'];
@endphp

<div class="min-h-screen bg-slate-50">

    <!-- HEADER -->
    <section class="bg-[#001840] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">

                <a href="{{ route('pelanggan.cetak.create') }}"
                   class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5" stroke-linecap="round"/>
                        <path d="M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <div>
                    <p class="text-[11px] text-[#F5C400] font-semibold uppercase tracking-[0.15em]">
                        Layanan Printing
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-1">Checkout Cetak</h1>
                    <p class="text-sm text-white/55 mt-1">Periksa detail cetakmu sebelum membayar.</p>
                </div>

            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- DETAIL CETAK -->
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl border border-[#001840]/10 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-base font-bold text-[#001840]">Detail Dokumen</h2>
                        <p class="text-xs text-gray-500 mt-1">Cetak di {{ $job['nama_toko'] }}</p>
                    </div>

                    <div class="p-6 flex gap-4">

                        <div class="w-16 h-16 rounded-2xl bg-[#102A71] flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z" stroke-linejoin="round"/>
                                <path d="M14 3v5h5" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#001840] break-all">{{ $job['nama_file'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $job['jumlah_halaman'] }} halaman pada file</p>
                        </div>

                    </div>

                    <dl class="border-t border-slate-100 divide-y divide-slate-100 text-sm">

                        <div class="flex justify-between gap-4 px-6 py-3">
                            <dt class="text-gray-500">Halaman dicetak</dt>
                            <dd class="font-semibold text-[#001840]">{{ $job['halaman_dipilih'] }}</dd>
                        </div>

                        <div class="flex justify-between gap-4 px-6 py-3">
                            <dt class="text-gray-500">Jenis cetak</dt>
                            <dd class="font-semibold text-[#001840]">
                                {{ ['hitam_putih' => 'Hitam Putih', 'warna' => 'Warna', 'campuran' => 'Campuran'][$job['jenis_cetak']] }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4 px-6 py-3">
                            <dt class="text-gray-500">Jumlah salinan</dt>
                            <dd class="font-semibold text-[#001840]">{{ $job['jumlah_cetak'] }}</dd>
                        </div>

                        @if(!empty($job['catatan_pelanggan']))
                            <div class="flex justify-between gap-4 px-6 py-3">
                                <dt class="text-gray-500">Catatan</dt>
                                <dd class="font-semibold text-[#001840] text-right">{{ $job['catatan_pelanggan'] }}</dd>
                            </div>
                        @endif

                        <div class="flex justify-between gap-4 px-6 py-3">
                            <dt class="text-gray-500">Pengambilan</dt>
                            <dd class="font-semibold text-[#001840]">Ambil di toko</dd>
                        </div>

                    </dl>

                </div>

                <div class="rounded-xl border border-yellow-100 bg-yellow-50 px-4 py-3 text-xs text-[#967500]">
                    Admin toko akan memeriksa file dan jumlah halaman. Pesanan baru dicetak setelah file disetujui.
                </div>

            </div>


            <!-- RINGKASAN -->
            <div>

                <div class="bg-white rounded-2xl border border-[#001840]/10 shadow-sm overflow-hidden lg:sticky lg:top-6">

                    <div class="px-6 py-5 bg-[#001840] text-white">
                        <h2 class="font-bold">Ringkasan Pesanan</h2>
                        <p class="text-xs text-white/50 mt-1">{{ $job['nama_toko'] }}</p>
                    </div>

                    <div class="p-6">

                        @if($job['halaman_hitam_putih'] > 0)
                            <div class="flex justify-between text-sm mb-3">
                                <span class="text-gray-500">
                                    Hitam putih ({{ $job['halaman_hitam_putih'] }} hal. × {{ $job['jumlah_cetak'] }} × {{ $rp($hargaBw) }})
                                </span>
                                <span class="font-semibold text-[#001840] shrink-0 pl-3">{{ $rp($subBw) }}</span>
                            </div>
                        @endif

                        @if($job['halaman_warna'] > 0)
                            <div class="flex justify-between text-sm mb-3">
                                <span class="text-gray-500">
                                    Warna ({{ $job['halaman_warna'] }} hal. × {{ $job['jumlah_cetak'] }} × {{ $rp($hargaWarna) }})
                                </span>
                                <span class="font-semibold text-[#001840] shrink-0 pl-3">{{ $rp($subWarna) }}</span>
                            </div>
                        @endif

                        <div class="border-t border-slate-100 pt-5 mt-2">
                            <div class="flex justify-between items-center gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-[#001840] mt-1">{{ $rp($job['total_harga']) }}</p>
                                </div>
                                <span class="px-3 py-1.5 rounded-lg bg-[#F5C400]/15 text-[#001840] text-xs font-bold">QRIS</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('pelanggan.cetak.konfirmasi') }}" class="mt-6">
                            @csrf
                            <input type="hidden" name="payment_method" value="qris">

                            <button type="submit"
                                    class="w-full py-3.5 rounded-xl bg-[#F5C400] text-[#001840] text-sm font-bold border border-[#F5C400] hover:bg-[#102A71] hover:text-[#F5C400] transition active:scale-[0.98]">
                                Lanjut ke Pembayaran
                            </button>
                        </form>

                        <form method="POST" action="{{ route('pelanggan.cetak.batal') }}" class="mt-3">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full text-center text-xs font-medium text-gray-500 hover:text-red-500 transition">
                                Batalkan &amp; ubah file
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

@endsection