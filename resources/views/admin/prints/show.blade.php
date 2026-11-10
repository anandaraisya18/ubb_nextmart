@extends('admin.layouts.app')

@section('title', 'Periksa File Cetak')

@section('content')

@php
    $pesanan = $print->detailPesanan?->pesanan;
    $toko    = $print->detailPesanan?->produk?->toko;

    $badge = [
        'menunggu_verifikasi' => 'bg-amber-50 text-amber-600',
        'selesai'             => 'bg-green-50 text-green-700',
        'perlu_revisi'        => 'bg-red-50 text-red-600',
    ];

    $label = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'selesai'             => 'Disetujui',
        'perlu_revisi'        => 'Ditolak',
    ];

    // Hanya dua pilihan untuk admin
    $opsi = [
        'selesai'      => 'Selesai',
        'perlu_revisi' => 'Tolak',
    ];

    $statusTerpilih = old('status_verifikasi', $print->status_verifikasi);
    if ($statusTerpilih === 'menunggu_verifikasi') {
        $statusTerpilih = null; // admin harus memilih sendiri
    }
@endphp

<div class="mx-auto max-w-4xl space-y-6">

    {{-- HEADER --}}
    <div>

        <a href="{{ route('admin.prints.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#102A71]">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Kembali ke Antrian Cetak
        </a>

        <h1 class="mt-4 text-2xl font-bold text-[#001840]">Periksa File Cetak</h1>

        <p class="mt-1 text-sm text-gray-500">
            Pastikan file dan jumlah halaman sesuai. File yang ditolak tidak akan dicetak dan
            biayanya otomatis dikurangi dari total pesanan.
        </p>

    </div>


    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-600">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        {{-- FILE --}}
        <div class="border-b border-gray-100 p-6 md:p-8">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="min-w-0">
                    <h2 class="font-semibold text-[#001840]">File Pelanggan</h2>
                    <p class="mt-1 truncate text-sm text-gray-500" title="{{ $print->nama_file }}">
                        {{ $print->nama_file }}
                    </p>
                </div>

                <a href="{{ route('admin.prints.download', $print->id) }}"
                   class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#001840] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#102A71]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <path d="M7 10l5 5 5-5"/>
                        <path d="M12 15V3"/>
                    </svg>
                    Unduh File
                </a>

            </div>

        </div>


        {{-- RINCIAN --}}
        <div class="border-b border-gray-100 p-6 md:p-8">

            <h2 class="mb-5 font-semibold text-[#001840]">Rincian Cetak</h2>

            <dl class="grid grid-cols-2 gap-5 text-sm md:grid-cols-3">

                <div>
                    <dt class="text-xs text-gray-400">Total Halaman File</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $print->jumlah_halaman }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Halaman Dipilih</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $print->halaman_dipilih ?: 'Semua' }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Jumlah Salinan</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $print->jumlah_cetak }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Halaman Hitam Putih</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $print->halaman_hitam_putih }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Halaman Warna</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $print->halaman_warna }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Biaya Cetak File Ini</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">
                        Rp{{ number_format((float) $print->total_harga, 0, ',', '.') }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Toko</dt>
                    <dd class="mt-1 font-semibold text-[#001840]">{{ $toko->nama_toko ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Pesanan</dt>
                    <dd class="mt-1 font-semibold">
                        @if($pesanan)
                            <a href="{{ route('admin.orders.show', $pesanan) }}" class="text-[#102A71] hover:underline">
                                {{ $pesanan->no_resi ?? '#ORD-' . $pesanan->id_pesanan }}
                            </a>
                        @else
                            -
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-xs text-gray-400">Status Saat Ini</dt>
                    <dd class="mt-1">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge[$print->status_verifikasi] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $label[$print->status_verifikasi] ?? $print->status_verifikasi }}
                        </span>
                    </dd>
                </div>

                @if($pesanan && (float) $pesanan->potongan_cetak > 0)
                    <div class="col-span-2 md:col-span-3">
                        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-relaxed text-amber-800">
                            Total pesanan saat ini
                            <strong>Rp{{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                            (awal Rp{{ number_format($pesanan->total_awal, 0, ',', '.') }},
                            potongan cetak Rp{{ number_format($pesanan->potongan_cetak, 0, ',', '.') }}).
                            @if($pesanan->selesai_otomatis)
                                Pesanan ini <strong>selesai otomatis</strong> karena semua file cetaknya ditolak.
                            @endif
                        </div>
                    </div>
                @endif

            </dl>

        </div>


        {{-- VERIFIKASI --}}
        <form method="POST"
              action="{{ route('admin.prints.verifikasi', $print->id) }}"
              id="form-verifikasi"
              autocomplete="off">

            @csrf
            @method('PUT')

            <div class="p-6 md:p-8">

                <h2 class="mb-5 font-semibold text-[#001840]">Verifikasi</h2>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    @foreach($opsi as $value => $teks)
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-4 text-sm font-semibold text-[#001840] transition hover:bg-gray-50">
                            <input
                                type="radio"
                                name="status_verifikasi"
                                value="{{ $value }}"
                                required
                                @checked($statusTerpilih === $value)
                                class="h-4 w-4 border-gray-300 text-[#F5C400] focus:ring-[#F5C400]"
                            >
                            {{ $teks }}
                        </label>
                    @endforeach

                </div>

                {{-- Peringatan saat memilih Tolak --}}
                <div id="peringatan-tolak"
                     class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs leading-relaxed text-red-700 {{ $statusTerpilih === 'perlu_revisi' ? '' : 'hidden' }}">
                    Jika ditolak, biaya cetak
                    <strong>Rp{{ number_format((float) $print->total_harga, 0, ',', '.') }}</strong>
                    akan dikurangi dari total pesanan. Jika pesanan hanya berisi file cetak dan semuanya ditolak,
                    pesanan otomatis diselesaikan. Pelanggan akan melihat catatan di bawah ini di riwayatnya.
                </div>

                <div class="mt-5">

                    <label for="catatan_admin" class="mb-2 block text-sm font-semibold text-[#001840]">
                        Catatan untuk Pelanggan
                        <span id="tanda-wajib" class="text-red-500 {{ $statusTerpilih === 'perlu_revisi' ? '' : 'hidden' }}">*</span>
                    </label>

                    <textarea
                        id="catatan_admin"
                        name="catatan_admin"
                        rows="3"
                        maxlength="500"
                        placeholder="Wajib diisi jika file ditolak (misal: file rusak, jumlah halaman tidak sesuai)"
                        class="w-full resize-none rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                    >{{ old('catatan_admin', $print->catatan_admin) }}</textarea>

                </div>

            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 p-5 sm:flex-row sm:justify-end">

                <a href="{{ route('admin.prints.index') }}"
                   class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-100">
                    Kembali
                </a>

                <button type="submit"
                        class="rounded-xl bg-[#F5C400] px-5 py-3 text-sm font-semibold text-[#001840] transition hover:bg-[#e6b900]">
                    Simpan Verifikasi
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    (function () {
        const form       = document.getElementById('form-verifikasi');
        const radios     = form.querySelectorAll('input[name="status_verifikasi"]');
        const peringatan = document.getElementById('peringatan-tolak');
        const tanda      = document.getElementById('tanda-wajib');
        const catatan    = document.getElementById('catatan_admin');

        function terpilih() {
            const r = form.querySelector('input[name="status_verifikasi"]:checked');
            return r ? r.value : null;
        }

        function sinkron() {
            const tolak = terpilih() === 'perlu_revisi';
            peringatan.classList.toggle('hidden', !tolak);
            tanda.classList.toggle('hidden', !tolak);
            catatan.required = tolak;
        }

        radios.forEach(r => r.addEventListener('change', sinkron));
        sinkron();

        form.addEventListener('submit', function (e) {
            if (terpilih() === 'perlu_revisi') {
                const ok = confirm('Tolak file ini? Biaya cetaknya akan dikurangi dari total pesanan.');
                if (!ok) e.preventDefault();
            }
        });
    })();
</script>

@endsection