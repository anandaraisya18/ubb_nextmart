@extends('pelanggan.layouts.app')

@section('title', 'UBB Nextmart - Beranda')

@section('content')

@php
    $jumlahToko = $tokoList->count();
@endphp


{{-- =========================================================
    HERO - UBB NEXTMART
========================================================= --}}
<section class="relative isolate overflow-hidden bg-[#001840]">

    <div class="absolute inset-0 grid grid-cols-2" aria-hidden="true">

        <div class="relative h-full overflow-hidden">
            <img
                src="{{ asset('images/ubbmart-depan.png') }}"
                alt=""
                class="h-full w-full object-cover object-center"
            >
        </div>

        <div class="relative h-full overflow-hidden">
            <img
                src="{{ asset('images/ubbmart-dalam.png') }}"
                alt=""
                class="h-full w-full object-cover object-center"
            >
        </div>

    </div>

    <div class="absolute inset-0 bg-[#001840]/60 pointer-events-none"></div>
    <div class="absolute inset-y-0 left-0 w-full lg:w-[65%] bg-[#001840]/20 pointer-events-none"></div>

    <div class="relative z-10 mx-auto flex min-h-[540px] max-w-7xl items-center px-6 py-20 sm:min-h-[580px] lg:px-8">

        <div class="max-w-2xl">

            <p class="mb-5 text-xs font-semibold uppercase tracking-[0.16em] text-[#F5C400] sm:text-sm">
                Marketplace Universitas Bangka Belitung
            </p>

            <h1 class="max-w-2xl text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-[56px]">
                Semua kebutuhan dalam satu tempat.
            </h1>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-white/85 sm:text-lg">
                Temukan kebutuhan mahasiswa, layanan printing,
                dan berbagai pilihan produk lainnya melalui
                UBB Nextmart.
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-3">

                <a
                    href="{{ route('pelanggan.produk.index') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-[#F5C400] px-6 py-3 text-sm font-semibold text-[#001840] transition-colors duration-200 hover:bg-[#e5b700]"
                >
                    Lihat Produk
                </a>

                <a
                    href="{{ route('pelanggan.pesanan.lacak') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-white/70 bg-transparent px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10"
                >
                    Lacak Pesanan
                </a>

                @if($tokoList->where('bisa_cetak', true)->isNotEmpty())
                    <a
                        href="{{ route('pelanggan.cetak.create') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-[#F5C400] bg-transparent px-6 py-3 text-sm font-semibold text-[#F5C400] transition-colors duration-200 hover:bg-[#F5C400] hover:text-[#001840]"
                    >
                        Cetak Dokumen
                    </a>
                @endif

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    PILIH GRUP OPERASIONAL
========================================================= --}}
@if($groups->isNotEmpty())
<section class="bg-[#f8fafc] border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        <div class="mb-8">
            <p class="text-sm font-semibold text-[#102A71]">
                Mulai Belanja
            </p>

            <h2 class="mt-2 text-2xl lg:text-3xl font-bold text-[#001840]">
                Pilih Grup Operasional
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Setiap grup memiliki daftar toko dan proses checkout masing-masing.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @foreach($groups as $i => $g)
                @php
                    $namaGrup = $g->nama_group ?? $g->nama ?? 'Grup ' . $g->id_group;
                    $tokoGrup = $tokoList->where('id_group', $g->id_group);
                    $jumlahProdukGrup = $tokoGrup->sum('produk_count');
                @endphp

                <a
                    href="{{ route('pelanggan.produk.index', ['group' => $g->id_group]) }}"
                    class="rounded-2xl border border-gray-200 bg-white p-6 hover:shadow-md hover:border-[#102A71]/30 transition"
                >

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 rounded-xl {{ $i % 2 ? 'bg-[#F5C400] text-[#001840]' : 'bg-[#001840] text-white' }} flex items-center justify-center text-base font-bold">
                                {{ $i + 1 }}
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Grup Operasional {{ $i + 1 }}
                                </p>

                                <h3 class="mt-1 text-lg font-bold text-[#001840]">
                                    {{ $namaGrup }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $jumlahProdukGrup }} produk tersedia
                                </p>
                            </div>

                        </div>

                        <span class="text-[#102A71] text-lg">
                            →
                        </span>

                    </div>

                    @if($tokoGrup->isNotEmpty())
                        <div class="mt-5 flex flex-wrap gap-2">

                            @foreach($tokoGrup as $t)
                                <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-[#001840]">
                                    {{ $t->nama_toko ?? $t->nama ?? 'Toko' }}
                                </span>
                            @endforeach

                        </div>
                    @endif

                </a>
            @endforeach

        </div>
    </div>
</section>
@endif


{{-- =========================================================
    PRODUK TERBARU
========================================================= --}}
<section id="produk" class="bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">

            <div>
                <p class="text-sm font-semibold text-[#102A71]">
                    Pilihan Produk
                </p>

                <h2 class="mt-2 text-2xl lg:text-3xl font-bold text-[#001840]">
                    Produk Terbaru
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Temukan kebutuhan yang kamu perlukan di UBB Nextmart.
                </p>
            </div>

            <a
                href="{{ route('pelanggan.produk.index') }}"
                class="inline-flex items-center text-sm font-semibold text-[#102A71] hover:text-[#001840] transition"
            >
                Lihat Semua →
            </a>

        </div>

        {{-- KATEGORI --}}
        @if($kategoriList->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-8">

                @foreach($kategoriList as $k)
                    <a
                        href="{{ route('pelanggan.produk.index', ['kategori' => $k->id_kategori]) }}"
                        class="rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-[#001840] hover:bg-[#001840] hover:text-white hover:border-[#001840] transition"
                    >
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach

            </div>
        @endif


        {{-- DAFTAR PRODUK --}}
        @if($produkTerbaru->isNotEmpty())

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

                @foreach($produkTerbaru as $p)
                    @php
                        $namaToko = $p->toko->nama_toko ?? $p->toko->nama ?? '-';
                        $stok = (int) $p->stok;
                    @endphp

                    <div class="flex flex-col rounded-2xl border border-gray-200 bg-white overflow-hidden hover:shadow-md transition">

                        {{-- GAMBAR PRODUK --}}
                        <a
                            href="{{ route('pelanggan.produk.show', $p) }}"
                            class="block aspect-square bg-gray-100 overflow-hidden"
                        >

                            @if($p->gambar)
                                <img
                                    src="{{ asset('storage/' . $p->gambar) }}"
                                    alt="{{ $p->nama_produk }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl text-gray-300">
                                    ▣
                                </div>
                            @endif

                        </a>

                        <div class="p-4 flex flex-1 flex-col">

                            <div class="flex items-start justify-between gap-3">

                                <p class="text-[11px] text-gray-400">
                                    {{ $namaToko }}
                                </p>

                                @if($p->kategori)
                                    <span class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-semibold text-[#001840]">
                                        {{ $p->kategori->nama_kategori }}
                                    </span>
                                @endif

                            </div>

                            <a href="{{ route('pelanggan.produk.show', $p) }}">
                                <h3 class="mt-2 text-sm sm:text-base font-bold text-[#001840] line-clamp-2 hover:text-[#102A71] transition">
                                    {{ $p->nama_produk }}
                                </h3>
                            </a>

                            <p class="mt-2 text-[#102A71] font-extrabold">
                                Rp{{ number_format($p->harga, 0, ',', '.') }}
                            </p>

                            <div class="mt-2 text-xs">

                                @if($stok > 0)
                                    <span class="text-green-600 font-medium">
                                        Stok tersedia
                                    </span>
                                @else
                                    <span class="text-red-500 font-medium">
                                        Stok habis
                                    </span>
                                @endif

                            </div>

                            <div class="mt-auto pt-4">

                                @if($stok > 0)

                                    {{-- PRODUK JASA CETAK --}}
                                    @if($p->nama_produk === 'Jasa Cetak')

                                        <a
                                            href="{{ route('pelanggan.cetak.create') }}"
                                            class="block w-full rounded-xl bg-[#F5C400] py-2.5 text-center text-xs font-bold text-[#001840] hover:bg-[#e5b900] transition"
                                        >
                                            + Keranjang
                                        </a>

                                    @else

                                        {{-- PRODUK BIASA --}}
                                        <form
                                            method="POST"
                                            action="{{ route('pelanggan.keranjang.store') }}"
                                            class="form-keranjang"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="id_produk"
                                                value="{{ $p->id_produk }}"
                                            >

                                            <input
                                                type="hidden"
                                                name="jumlah"
                                                value="1"
                                            >

                                            <button
                                                type="submit"
                                                class="w-full rounded-xl bg-[#F5C400] py-2.5 text-xs font-bold text-[#001840] hover:bg-[#e5b900] transition"
                                            >
                                                + Keranjang
                                            </button>
                                        </form>

                                    @endif

                                @else

                                    <button
                                        type="button"
                                        disabled
                                        class="w-full cursor-not-allowed rounded-xl bg-gray-100 py-2.5 text-xs font-bold text-gray-400"
                                    >
                                        Stok Habis
                                    </button>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- BELUM ADA PRODUK --}}
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 py-16 text-center">

                <p class="font-bold text-[#001840]">
                    Belum ada produk
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Produk yang ditambahkan admin akan tampil di sini.
                </p>

            </div>

        @endif

    </div>
</section>


{{-- =========================================================
    INFORMASI / MEDIA SOSIAL
========================================================= --}}
<section id="media-sosial" class="bg-[#f8fafc] border-t border-gray-200">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        {{-- JUDUL --}}
        <div class="mb-8">

            <p class="text-sm font-semibold text-[#102A71]">
                Informasi
            </p>

            <h2 class="mt-2 text-2xl lg:text-3xl font-bold text-[#001840]">
                Ikuti Media Sosial Kami
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Dapatkan informasi produk terbaru dan aktivitas UBB Mart & Gubuk Printing.
            </p>

        </div>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            {{-- =================================================
                INSTAGRAM EMBED
            ================================================== --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <div class="mb-5">

                    <h3 class="text-xl font-bold text-[#001840]">
                        Instagram
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Ikuti aktivitas dan informasi terbaru dari Instagram kami (jangan lupa follow ya).
                    </p>

                    <a
                        href="https://www.instagram.com/ubbmart_gubukprinting/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 inline-block text-sm font-semibold text-[#102A71] hover:underline"
                    >
                        @ubbmart_gubukprinting
                    </a>

                </div>

                <div class="flex justify-center overflow-hidden">

                    <blockquote
                        class="instagram-media"
                        data-instgrm-permalink="https://www.instagram.com/ubbmart_gubukprinting/"
                        data-instgrm-version="14"
                        style="background:#FFF; border:0; border-radius:12px; margin:0; max-width:540px; min-width:280px; padding:0; width:100%;"
                    >

                        <div style="padding:16px;">

                            <a
                                href="https://www.instagram.com/ubbmart_gubukprinting/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm font-semibold text-[#102A71]"
                            >
                                Lihat Instagram @ubbmart_gubukprinting
                            </a>

                        </div>

                    </blockquote>

                </div>

            </div>


            {{-- =================================================
                TIKTOK EMBED
            ================================================== --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <div class="mb-5">

                    <h3 class="text-xl font-bold text-[#001840]">
                        TikTok
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Tonton video terbaru dari akun TikTok kami (jangan lupa follow ya).
                    </p>

                    <a
                        href="https://www.tiktok.com/@ubbmart_gubukprinting"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 inline-block text-sm font-semibold text-[#102A71] hover:underline"
                    >
                        @ubbmart_gubukprinting
                    </a>

                </div>

                <div class="flex justify-center overflow-hidden">

                    <blockquote
                        class="tiktok-embed"
                        cite="https://www.tiktok.com/@ubbmart_gubukprinting"
                        data-unique-id="ubbmart_gubukprinting"
                        data-embed-type="creator"
                        style="max-width: 780px; min-width: 280px; width: 100%;"
                    >

                        <section>

                            <a
                                target="_blank"
                                rel="noopener noreferrer"
                                href="https://www.tiktok.com/@ubbmart_gubukprinting"
                            >
                                @ubbmart_gubukprinting
                            </a>

                        </section>

                    </blockquote>

                </div>

            </div>

        </div>

            {{-- =================================================
                WHATSAPP UBB MART
            ================================================== --}}
            <div class="lg:col-span-2 mt-6 rounded-2xl border border-green-200 bg-white p-5 sm:p-6 hover:shadow-md transition">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    {{-- ICON DAN INFORMASI --}}
                    <div class="flex items-center gap-5">

                        {{-- LOGO WHATSAPP --}}
                        <div
                            class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center shadow-sm"
                            style="background-color: #25D366;"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="36"
                                height="36"
                                fill="#FFFFFF"
                                aria-hidden="true"
                            >
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.198.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.76-1.653-2.058-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.173.198-.297.297-.495.1-.198.05-.372-.025-.52-.074-.149-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.009-.372-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.064 2.875 1.213 3.073.149.198 2.095 3.2 5.077 4.487.709.306 1.262.489 1.693.625.711.227 1.358.195 1.869.119.57-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.493h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.981.998-3.648-.235-.374a9.86 9.86 0 0 1-1.512-5.26c.002-5.447 4.436-9.88 9.887-9.88a9.82 9.82 0 0 1 6.986 2.895 9.823 9.823 0 0 1 2.893 6.986c-.002 5.447-4.436 9.88-9.88 9.88m8.413-18.295A11.81 11.81 0 0 0 12.051.1C5.5.1.172 5.428.169 11.978a11.85 11.85 0 0 0 1.583 5.946L.07 24l6.233-1.635a11.9 11.9 0 0 0 5.744 1.463h.005c6.551 0 11.88-5.328 11.883-11.88A11.82 11.82 0 0 0 20.464 3.58z"/>
                            </svg>

                        </div>

                        {{-- INFORMASI WHATSAPP --}}
                        <div>

                            <h3 class="text-xl font-bold text-[#001840]">
                                WhatsApp UBB Mart & Gubuk Printing
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 leading-relaxed">
                                Hubungi WhatsApp kami untuk informasi
                                produk, layanan printing, pemesanan,
                                serta pertanyaan lainnya ya.
                            </p>

                            <a
                                href="https://wa.me/6283863292976"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-3 inline-block text-base font-bold text-[#102A71] hover:underline"
                            >
                                +62 838-6329-2976
                            </a>

                        </div>

                    </div>


                    {{-- TOMBOL CHAT WHATSAPP --}}
                    <a
                        href="https://wa.me/6283863292976?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20produk%20di%20UBB%20Mart%20%26%20Gubuk%20Printing."
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Hubungi UBB Mart melalui WhatsApp"
                        class="inline-flex shrink-0 items-center justify-center gap-3 rounded-xl px-6 py-3.5 text-sm font-bold transition-all duration-200 hover:opacity-90 hover:shadow-lg"
                        style="background-color: #25D366; color: #FFFFFF;"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.19 18a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 1.28 3.18 2 2 0 0 1 3.27 1h3a2 2 0 0 1 2 1.72c.12.96.35 1.91.68 2.81a2 2 0 0 1-.45 2.11L7.23 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.85.56 2.81.68A2 2 0 0 1 22 16.92z"/>
                        </svg>

                        Chat via WhatsApp

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>

                    </a>

                </div>


                {{-- KETERANGAN WHATSAPP --}}
                <div class="mt-6 border-t border-gray-100 pt-4">

                    <p class="text-xs text-gray-500">
                        Klik tombol Chat via WhatsApp untuk menghubungi
                        pengelola UBB Mart & Gubuk Printing secara langsung.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    SOCIAL MEDIA EMBED SCRIPTS
========================================================= --}}

{{-- Instagram Embed Script --}}
<script async src="https://www.instagram.com/embed.js"></script>

{{-- Tiktok Embed Script --}}
<script async src="https://www.tiktok.com/embed.js"></script>


{{-- =========================================================
    TAMBAH KERANJANG TANPA REFRESH
========================================================= --}}
<script>
document.querySelectorAll('.form-keranjang').forEach(function (form) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn = form.querySelector('button[type="submit"]');
        const teksAsli = btn.textContent;

        btn.disabled = true;
        btn.textContent = 'Menambahkan...';

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            });

            if (res.ok) {
                // Ambil angka terbaru dari navbar
                // pada halaman hasil redirect.
                const html = await res.text();

                const doc = new DOMParser().parseFromString(
                    html,
                    'text/html'
                );

                const baru = doc.getElementById('cart-badge');
                const badge = document.getElementById('cart-badge');

                if (baru && badge) {
                    badge.textContent = baru.textContent.trim();

                    badge.classList.toggle(
                        'hidden',
                        baru.classList.contains('hidden')
                    );
                }

                btn.textContent = '✓ Ditambahkan';

            } else {
                btn.textContent = 'Gagal, coba lagi';
            }

        } catch (err) {
            btn.textContent = 'Gagal, coba lagi';
        }

        setTimeout(function () {
            btn.textContent = teksAsli;
            btn.disabled = false;
        }, 1500);
    });
});
</script>

@endsection
