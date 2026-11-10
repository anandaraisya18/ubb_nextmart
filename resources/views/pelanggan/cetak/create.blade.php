@extends('pelanggan.layouts.app')

@section('title', 'Cetak Dokumen - UBB Nextmart')

@section('content')

@php
    $jenisLama = old('jenis_cetak', 'hitam_putih');
@endphp

<section class="min-h-screen bg-[#f8fafc] py-12 sm:py-16">
    <div class="max-w-3xl mx-auto px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <span class="text-sm font-bold text-[#102A71] uppercase tracking-wider">
                Layanan Printing
            </span>

            <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold text-[#001840]">
                Cetak Dokumen
            </h1>

            <p class="mt-3 text-sm sm:text-base text-gray-500">
                Upload file, pilih jenis cetak, lalu ambil hasilnya di toko.
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if($tokoCetak->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center">
                <p class="font-bold text-[#001840]">Layanan cetak belum tersedia</p>
                <p class="mt-1 text-sm text-gray-500">Belum ada toko yang membuka layanan cetak.</p>
            </div>

        @else

        <form
            method="POST"
            action="{{ route('pelanggan.cetak.store') }}"
            enctype="multipart/form-data"
            id="form-cetak"
            data-harga-bw="{{ $tarif['hitam_putih'] }}"
            data-harga-warna="{{ $tarif['warna'] }}"
            data-url-hitung="{{ route('pelanggan.cetak.hitung') }}"
            class="space-y-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8"
        >

            @csrf

            {{-- TOKO --}}
            <div>
                <label for="id_toko" class="mb-2 block text-sm font-bold text-[#001840]">
                    Toko Percetakan
                </label>

                @if($tokoCetak->count() === 1)

                    <input type="hidden" name="id_toko" value="{{ $tokoCetak->first()->id_toko }}">

                    <div class="rounded-xl border border-gray-200 bg-[#f8fafc] px-4 py-2.5 text-sm font-semibold text-[#001840]">
                        {{ $tokoCetak->first()->nama_toko }}
                    </div>

                @else

                    <select
                        id="id_toko"
                        name="id_toko"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                        <option value="">Pilih Toko</option>

                        @foreach($tokoCetak as $t)
                            <option value="{{ $t->id_toko }}" @selected(old('id_toko') == $t->id_toko)>
                                {{ $t->nama_toko }}
                            </option>
                        @endforeach
                    </select>

                @endif
            </div>

            {{-- FILE --}}
            <div>
                <label for="file" class="mb-2 block text-sm font-bold text-[#001840]">
                    File
                </label>

                <input
                    id="file"
                    type="file"
                    name="file"
                    required
                    accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"
                    class="block w-full rounded-xl border border-gray-200 bg-white text-sm text-gray-600 file:mr-4 file:border-0 file:bg-[#001840] file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-[#102A71]"
                >

                <p class="mt-1 text-xs text-gray-400">
                    PDF, DOC, DOCX, PPT, PPTX, JPG, PNG. Maksimal 10 MB.
                </p>
            </div>

            {{-- HALAMAN --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label for="jumlah_halaman" class="mb-2 block text-sm font-bold text-[#001840]">
                        Total Halaman File
                    </label>

                    <input
                        id="jumlah_halaman"
                        type="number"
                        name="jumlah_halaman"
                        min="1"
                        required
                        value="{{ old('jumlah_halaman') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >

                    <p id="info-halaman" class="mt-1 text-xs text-gray-400">
                        Terisi otomatis setelah file dipilih.
                    </p>
                </div>

                <div>
                    <label for="halaman_dipilih" class="mb-2 block text-sm font-bold text-[#001840]">
                        Halaman yang Dicetak
                    </label>

                    <input
                        id="halaman_dipilih"
                        type="text"
                        name="halaman_dipilih"
                        required
                        value="{{ old('halaman_dipilih') }}"
                        placeholder="Contoh: 1-5, 8 atau semua"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

                {{-- JENIS CETAK --}}
                <div class="sm:col-span-2">

                    <p class="mb-2 text-sm font-bold text-[#001840]">
                        Jenis Cetak
                    </p>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                            <input
                                type="radio"
                                name="jenis_cetak"
                                value="hitam_putih"
                                required
                                @checked($jenisLama === 'hitam_putih')
                                class="mt-0.5 h-4 w-4 border-gray-300 text-[#F5C400] focus:ring-[#F5C400]"
                            >

                            <span>
                                <span class="block text-sm font-semibold text-[#001840]">
                                    Hitam Putih
                                </span>

                                <span class="block text-xs text-gray-400">
                                    Rp{{ number_format($tarif['hitam_putih'], 0, ',', '.') }}/hal.
                                </span>
                            </span>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                            <input
                                type="radio"
                                name="jenis_cetak"
                                value="warna"
                                @checked($jenisLama === 'warna')
                                class="mt-0.5 h-4 w-4 border-gray-300 text-[#F5C400] focus:ring-[#F5C400]"
                            >

                            <span>
                                <span class="block text-sm font-semibold text-[#001840]">
                                    Warna
                                </span>

                                <span class="block text-xs text-gray-400">
                                    Rp{{ number_format($tarif['warna'], 0, ',', '.') }}/hal.
                                </span>
                            </span>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">
                            <input
                                type="radio"
                                name="jenis_cetak"
                                value="campuran"
                                @checked($jenisLama === 'campuran')
                                class="mt-0.5 h-4 w-4 border-gray-300 text-[#F5C400] focus:ring-[#F5C400]"
                            >

                            <span>
                                <span class="block text-sm font-semibold text-[#001840]">
                                    Campuran
                                </span>

                                <span class="block text-xs text-gray-400">
                                    Sebagian warna
                                </span>
                            </span>
                        </label>

                    </div>

                </div>

                {{-- CAMPURAN --}}
                <div id="blok-campuran" class="hidden sm:col-span-2">

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div>
                            <label for="halaman_hitam_putih" class="mb-2 block text-sm font-bold text-[#001840]">
                                Jumlah Halaman Hitam Putih
                            </label>

                            <input
                                id="halaman_hitam_putih"
                                type="number"
                                name="halaman_hitam_putih"
                                min="0"
                                value="{{ old('halaman_hitam_putih', 0) }}"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                            >
                        </div>

                        <div>
                            <label for="halaman_warna" class="mb-2 block text-sm font-bold text-[#001840]">
                                Jumlah Halaman Warna
                            </label>

                            <input
                                id="halaman_warna"
                                type="number"
                                name="halaman_warna"
                                min="0"
                                value="{{ old('halaman_warna', 0) }}"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                            >
                        </div>

                    </div>

                    <p class="mt-2 text-xs text-gray-400">
                        Sebutkan halaman mana yang berwarna di kolom catatan di bawah.
                    </p>

                </div>

                {{-- JUMLAH SALINAN --}}
                <div>
                    <label for="jumlah_cetak" class="mb-2 block text-sm font-bold text-[#001840]">
                        Jumlah Salinan
                    </label>

                    <input
                        id="jumlah_cetak"
                        type="number"
                        name="jumlah_cetak"
                        min="1"
                        required
                        value="{{ old('jumlah_cetak', 1) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

            </div>

            {{-- CATATAN --}}
            <div>
                <label for="catatan_pelanggan" class="mb-2 block text-sm font-bold text-[#001840]">
                    Catatan <span class="font-normal text-gray-400">(opsional)</span>
                </label>

                <textarea
                    id="catatan_pelanggan"
                    name="catatan_pelanggan"
                    rows="3"
                    maxlength="500"
                    placeholder="Contoh: halaman 3 dan 7 berwarna, dijilid spiral, bolak-balik"
                    class="w-full resize-none rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                >{{ old('catatan_pelanggan') }}</textarea>
            </div>

            {{-- ESTIMASI --}}
            <div class="rounded-xl bg-[#f8fafc] p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-600">
                        Estimasi Total
                    </span>

                    <span id="estimasi" class="text-xl font-extrabold text-[#102A71]">
                        Rp0
                    </span>
                </div>

                <p class="mt-2 text-xs text-gray-400">
                    Admin toko akan memeriksa file dan jumlah halaman. Pesanan baru diproses setelah file disetujui.
                </p>

            </div>

            {{-- TOMBOL --}}
            <button
                id="btn-pesan-cetak"
                type="submit"
                disabled
                class="w-full rounded-xl bg-gray-300 py-3 text-sm font-bold text-gray-500 cursor-not-allowed transition"
            >
                Pesan Cetak
            </button>

        </form>

        @endif

    </div>
</section>

<script>
(function () {
    const form = document.getElementById('form-cetak');
    if (!form) return;

    const hargaBw    = parseInt(form.dataset.hargaBw, 10) || 0;
    const hargaWarna = parseInt(form.dataset.hargaWarna, 10) || 0;
    const urlHitung  = form.dataset.urlHitung;

    const fileInput = form.querySelector('#file');
    const total     = form.querySelector('#jumlah_halaman');
    const dipilih   = form.querySelector('#halaman_dipilih');
    const bw        = form.querySelector('#halaman_hitam_putih');
    const warna     = form.querySelector('#halaman_warna');
    const salinan   = form.querySelector('#jumlah_cetak');
    const blok      = document.getElementById('blok-campuran');
    const output    = document.getElementById('estimasi');
    const info      = document.getElementById('info-halaman');
    const tombolSubmit = document.getElementById('btn-pesan-cetak');
    const csrf      = form.querySelector('input[name="_token"]').value;

    function mode() {
        return form.querySelector('input[name="jenis_cetak"]:checked')?.value || '';
    }

    function hitungDipilih() {
        const n   = parseInt(total.value, 10) || 0;
        const isi = dipilih.value.trim();

        if (isi.toLowerCase() === 'semua') return n;
        if (isi === '') return 0;

        const set = new Set();

        isi.split(',').forEach(function (bagian) {
            bagian = bagian.trim();

            const rentang = bagian.match(/^(\d+)\s*-\s*(\d+)$/);

            if (rentang) {
                let a = parseInt(rentang[1], 10);
                let b = parseInt(rentang[2], 10);

                if (a > b) {
                    const t = a;
                    a = b;
                    b = t;
                }

                for (let i = Math.max(a, 1); i <= Math.min(b, n); i++) {
                    set.add(i);
                }

            } else if (/^\d+$/.test(bagian)) {
                const x = parseInt(bagian, 10);

                if (x >= 1 && x <= n) {
                    set.add(x);
                }
            }
        });

        return set.size;
    }

    function hitung() {
        const dicetak = hitungDipilih();
        let b = 0, w = 0;

        if (mode() === 'hitam_putih') {
            b = dicetak;
        } else if (mode() === 'warna') {
            w = dicetak;
        } else if (mode() === 'campuran') {
            b = parseInt(bw.value, 10) || 0;
            w = parseInt(warna.value, 10) || 0;
        }

        const nilai = ((b * hargaBw) + (w * hargaWarna))
            * (parseInt(salinan.value, 10) || 0);

        output.textContent = 'Rp' + nilai.toLocaleString('id-ID');
    }

    function validasiForm() {
        const jenis = mode();
        const campuran = jenis === 'campuran';

        bw.required = campuran;
        warna.required = campuran;

        if (!campuran) {
            bw.setCustomValidity('');
            warna.setCustomValidity('');
        }

        let valid = form.checkValidity();

        if (campuran) {
            const jumlahBw = parseInt(bw.value, 10);
            const jumlahWarna = parseInt(warna.value, 10);

            if (
                !Number.isInteger(jumlahBw) ||
                !Number.isInteger(jumlahWarna) ||
                jumlahBw < 0 ||
                jumlahWarna < 0 ||
                jumlahBw + jumlahWarna !== hitungDipilih() ||
                jumlahBw + jumlahWarna <= 0
            ) {
                valid = false;
            }
        }

        tombolSubmit.disabled = !valid;

        tombolSubmit.classList.toggle('bg-[#F5C400]', valid);
        tombolSubmit.classList.toggle('text-[#001840]', valid);
        tombolSubmit.classList.toggle('hover:bg-[#102A71]', valid);
        tombolSubmit.classList.toggle('hover:text-[#F5C400]', valid);

        tombolSubmit.classList.toggle('bg-gray-300', !valid);
        tombolSubmit.classList.toggle('text-gray-500', !valid);
        tombolSubmit.classList.toggle('cursor-not-allowed', !valid);
    }

    function aturMode() {
        const campuran = mode() === 'campuran';

        blok.classList.toggle('hidden', !campuran);

        bw.disabled = !campuran;
        warna.disabled = !campuran;

        bw.required = campuran;
        warna.required = campuran;

        hitung();
        validasiForm();
    }

    form.querySelectorAll('input[name="jenis_cetak"]').forEach(function (el) {
        el.addEventListener('change', aturMode);
    });

    [total, dipilih, bw, warna, salinan].forEach(function (el) {
        el.addEventListener('input', function () {
            hitung();
            validasiForm();
        });
    });

    form.querySelectorAll('input, select, textarea').forEach(function (el) {
        el.addEventListener('input', validasiForm);
        el.addEventListener('change', validasiForm);
    });

    // Deteksi jumlah halaman otomatis saat file dipilih
    fileInput.addEventListener('change', async function () {
        if (!fileInput.files.length) {
            info.textContent = 'Terisi otomatis setelah file dipilih.';
            validasiForm();
            return;
        }

        info.textContent = 'Mendeteksi jumlah halaman...';
        validasiForm();

        const data = new FormData();
        data.append('file', fileInput.files[0]);
        data.append('_token', csrf);

        try {
            const res = await fetch(urlHitung, {
                method: 'POST',
                body: data,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const json = await res.json();

            if (res.ok && json.halaman) {
                total.value = json.halaman;
                info.textContent = 'Terdeteksi otomatis: ' + json.halaman + ' halaman.';
            } else {
                info.textContent = 'Jumlah halaman tidak bisa dideteksi. Isi manual.';
            }

        } catch (e) {
            info.textContent = 'Gagal mendeteksi. Isi jumlah halaman manual.';
        }

        hitung();
        validasiForm();
    });

    aturMode();
    validasiForm();
})();
</script>

@endsection
