
@extends('pelanggan.layouts.app')

@section('title', 'Katalog Produk - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-white">

    {{-- HEADER KATALOG --}}
    <section class="border-b border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 py-12">

            <p class="text-sm font-semibold text-[#102A71] mb-2">
                UBB Nextmart
            </p>

            <h1 class="text-3xl md:text-4xl font-bold text-[#001840]">
                Katalog Produk
            </h1>

            <p class="text-gray-500 mt-3 max-w-2xl">
                Temukan berbagai kebutuhan mahasiswa, layanan printing,
                serta pilihan makanan dan minuman dari toko yang tersedia
                di UBB Nextmart.
            </p>

        </div>
    </section>

    {{-- DAFTAR PRODUK BERDASARKAN GRUP --}}
    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-12">

        @forelse($groups as $group)

            @php
                $namaGrup = $group->nama_group;
                $produkGrup = $produkPerGrup->get(
                    $group->id_group,
                    collect()
                );
            @endphp

            <section class="mb-16 last:mb-0">

                {{-- HEADER GRUP --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-6 pb-5 border-b border-gray-200">

                    <div>
                        <h2 class="text-2xl font-bold text-[#001840]">
                            {{ $namaGrup }}
                        </h2>

                        <p class="text-sm text-gray-500 mt-2">
                            {{ $produkGrup->count() }} produk tersedia
                        </p>
                    </div>

                </div>

                {{-- GRID PRODUK --}}
                @if($produkGrup->isNotEmpty())

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

                        @foreach($produkGrup as $p)

                            @php
                                $namaToko = $p->toko->nama_toko
                                    ?? $p->toko->nama
                                    ?? '-';

                                $stok = (int) $p->stok;
                            @endphp

                            <article class="flex flex-col bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-gray-400 transition-colors duration-200">

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
                                            loading="lazy"
                                        >

                                    @else

                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                            Tidak ada gambar
                                        </div>

                                    @endif

                                </a>

                                {{-- INFORMASI PRODUK --}}
                                <div class="p-4 flex flex-col flex-1">

                                    <p class="text-xs text-gray-500 mb-2">
                                        {{ $namaToko }}
                                    </p>

                                    @if($p->kategori)
                                        <p class="text-xs text-[#102A71] font-medium mb-2">
                                            {{ $p->kategori->nama_kategori }}
                                        </p>
                                    @endif

                                    <a href="{{ route('pelanggan.produk.show', $p) }}">
                                        <h3 class="text-sm md:text-base font-semibold text-[#001840] leading-snug line-clamp-2 hover:text-[#102A71]">
                                            {{ $p->nama_produk }}
                                        </h3>
                                    </a>

                                    <p class="text-lg font-bold text-[#001840] mt-3">
                                        Rp{{ number_format($p->harga, 0, ',', '.') }}
                                    </p>

                                    {{-- STATUS STOK --}}
                                    <div class="mt-2 text-xs">

                                        @if($stok > 5)

                                            <span class="text-gray-500">
                                                Stok: {{ $stok }}
                                            </span>

                                        @elseif($stok > 0)

                                            <span class="text-orange-600 font-medium">
                                                Tersisa {{ $stok }}
                                            </span>

                                        @else

                                            <span class="text-red-600 font-medium">
                                                Stok Habis
                                            </span>

                                        @endif

                                    </div>

                                    {{-- TOMBOL KERANJANG --}}
                                    <div class="mt-auto pt-5">

                                        @if($stok > 0)

                                            <form
                                                method="POST"
                                                action="{{ route('pelanggan.keranjang.store') }}"
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
                                                    class="w-full bg-[#001840] text-white text-sm font-semibold py-2.5 px-3 rounded-md hover:bg-[#102A71] transition-colors duration-200"
                                                >
                                                    + Keranjang
                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                disabled
                                                class="w-full bg-gray-100 text-gray-400 text-sm font-semibold py-2.5 px-3 rounded-md cursor-not-allowed"
                                            >
                                                Stok Habis
                                            </button>

                                        @endif

                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    {{-- JIKA GRUP BELUM MEMILIKI PRODUK --}}
                    <div class="border border-dashed border-gray-300 rounded-lg py-12 px-5 text-center">

                        <p class="text-[#001840] font-semibold">
                            Belum ada produk tersedia
                        </p>

                        <p class="text-gray-500 text-sm mt-2">
                            Produk dari grup ini akan tampil setelah ditambahkan oleh admin.
                        </p>

                    </div>

                @endif

            </section>

        @empty

            <div class="text-center py-20">

                <h2 class="text-xl font-semibold text-[#001840]">
                    Belum ada grup toko
                </h2>

                <p class="text-gray-500 mt-2">
                    Belum ada grup operasional yang tersedia saat ini.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection
