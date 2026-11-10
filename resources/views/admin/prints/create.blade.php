@extends('pelanggan.layouts.app')

@section('title', 'Cetak Dokumen - UBB Nextmart')

@section('content')

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
            class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8 space-y-6"
        >

            @csrf

            {{-- TOKO --}}
            <div>
                <label for="id_toko" class="mb-2 block text-sm font-bold text-[#001840]">Toko Percetakan</label>

                <select
                    id="id_toko"
                    name="id_toko"
                    required
                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                >
                    @foreach($tokoCetak as $t)
                        <option value="{{ $t->id_toko }}" @selected(old('id_toko') == $t->id_toko)>
                            {{ $t->nama_toko }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILE --}}
            <div>
                <label for="file" class="mb-2 block text-sm font-bold text-[#001840]">File</label>

                <input
                    id="file"
                    type="file"
                    name="file"
                    required
                    accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png"
                    class="block w-full rounded-xl border border-gray-200 bg-white text-sm text-gray-600 file:mr-4 file:border-0 file:bg-[#001840] file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-[#102A71]"
                >

                <p class="mt-1 text-xs text-gray-400">PDF, DOC, DOCX, PPT, PPTX, JPG, PNG. Maksimal 10 MB.</p>
            </div>

            {{-- HALAMAN --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label for="jumlah_halaman" class="mb-2 block text-sm font-bold text-[#001840]">Total Halaman File</label>
                    <input
                        id="jumlah_halaman" type="number" name="jumlah_halaman" min="1" required
                        value="{{ old('jumlah_halaman') }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

                <div>
                    <label for="halaman_dipilih" class="mb-2 block text-sm font-bold text-[#001840]">Halaman yang Dicetak</label>
                    <input
                        id="halaman_dipilih" type="text" name="halaman_dipilih"
                        value="{{ old('halaman_dipilih') }}"
                        placeholder="Contoh: 1-5, 8 (kosongkan jika semua)"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

                <div>
                    <label for="halaman_hitam_putih" class="mb-2 block text-sm font-bold text-[#001840]">
                        Halaman Hitam Putih
                        <span class="font-normal text-gray-400">(Rp{{ number_format($tarif['hitam_putih'], 0, ',', '.') }}/hal.)</span>
                    </label>
                    <input
                        id="halaman_hitam_putih" type="number" name="halaman_hitam_putih" min="0" required
                        value="{{ old('halaman_hitam_putih', 0) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

                <div>
                    <label for="halaman_warna" class="mb-2 block text-sm font-bold text-[#001840]">
                        Halaman Warna
                        <span class="font-normal text-gray-400">(Rp{{ number_format($tarif['warna'], 0, ',', '.') }}/hal.)</span>
                    </label>
                    <input
                        id="halaman_warna" type="number" name="halaman_warna" min="0" required
                        value="{{ old('halaman_warna', 0) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

                <div>
                    <label for="jumlah_cetak" class="mb-2 block text-sm font-bold text-[#001840]">Jumlah Salinan</label>
                    <input
                        id="jumlah_cetak" type="number" name="jumlah_cetak" min="1" required
                        value="{{ old('jumlah_cetak', 1) }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]"
                    >
                </div>

            </div>

            {{-- ESTIMASI --}}
            <div class="rounded-xl bg-[#f8fafc] p-5">

                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-600">Estimasi Total</span>
                    <span id="estimasi" class="text-xl font-extrabold text-[#102A71]">Rp0</span>
                </div>

                <p class="mt-2 text-xs text-gray-400">
                    Admin toko akan memeriksa file dan jumlah halaman. Pesanan baru diproses setelah file disetujui.
                </p>

            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-[#F5C400] py-3 text-sm font-bold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400]"
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

    const bw      = form.querySelector('#halaman_hitam_putih');
    const warna   = form.querySelector('#halaman_warna');
    const salinan = form.querySelector('#jumlah_cetak');
    const output  = document.getElementById('estimasi');

    function hitung() {
        const total = (
            ((parseInt(bw.value, 10) || 0) * hargaBw) +
            ((parseInt(warna.value, 10) || 0) * hargaWarna)
        ) * (parseInt(salinan.value, 10) || 0);

        output.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    [bw, warna, salinan].forEach(function (el) {
        el.addEventListener('input', hitung);
    });

    hitung();
})();
</script>

@endsection