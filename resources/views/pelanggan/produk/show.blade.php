@extends('pelanggan.layouts.app')

@section('title', $produk->nama_produk . ' - UBB Nextmart')

@section('content')

@php
    $gambar = $produk->gambar
        ? asset('storage/' . $produk->gambar)
        : asset('images/product-placeholder.png');
@endphp

<div class="min-h-screen bg-slate-50">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-[#102A71] transition">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
            </svg>
            <a href="{{ route('pelanggan.produk.index') }}" class="hover:text-[#102A71] transition">Produk</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
            </svg>
            <span class="text-gray-700">Detail Produk</span>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                {{-- GAMBAR --}}
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="relative aspect-square rounded-2xl bg-slate-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                        <img src="{{ $gambar }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-contain p-8">

                        <div class="absolute top-4 left-4 px-3 py-1.5 rounded-full bg-[#F5C400] text-[#001840] text-xs font-bold">
                            {{ $produk->kategori->nama_kategori ?? 'Produk' }}
                        </div>
                    </div>
                </div>

                {{-- INFORMASI --}}
                <div class="p-6 sm:p-8 lg:p-10 flex flex-col">

                    <div>
                        <p class="text-sm font-semibold text-[#102A71] uppercase tracking-wider mb-2">
                            {{ $produk->toko->nama_toko ?? 'UBB Nextmart' }}
                        </p>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#001840]">
                            {{ $produk->nama_produk }}
                        </h1>
                    </div>

                    <div class="mt-5">
                        <p class="text-sm text-gray-500 mb-1">Harga</p>
                        <p class="text-3xl font-extrabold text-[#102A71]">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="mt-5 flex items-center gap-2">
                        @if($produk->stok > 0)
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-sm text-gray-600">Stok tersedia ({{ $produk->stok }})</span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="text-sm text-gray-600">Stok habis</span>
                        @endif
                    </div>

                    <div class="mt-7">
                        <h2 class="text-base font-bold text-[#001840] mb-3">Deskripsi Produk</h2>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            {{ $produk->deskripsi ?: 'Belum ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <div class="border-t border-gray-100 my-7"></div>

                    {{-- JUMLAH --}}
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-[#001840] mb-3">Jumlah</label>

                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decreaseQuantity()"
                                    class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center text-[#102A71] hover:bg-[#102A71] hover:text-white transition">−</button>

                            <input id="quantity" type="number" value="1" min="1" max="{{ max($produk->stok, 1) }}"
                                   class="w-16 h-10 rounded-xl border border-gray-200 text-center font-semibold text-[#001840] focus:outline-none focus:ring-2 focus:ring-[#F5C400]">

                            <button type="button" onclick="increaseQuantity()"
                                    class="w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center text-[#102A71] hover:bg-[#102A71] hover:text-white transition">+</button>
                        </div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="mt-auto pt-8 grid grid-cols-1 sm:grid-cols-2 gap-3">

                        <a href="{{ route('pelanggan.produk.index') }}"
                           class="flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl border-2 border-[#102A71] text-[#102A71] font-semibold text-sm hover:bg-[#102A71] hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>

                        <button type="button" onclick="addToCart()"
                                @disabled($produk->stok <= 0)
                                class="flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-[#F5C400] text-[#001840] font-bold text-sm hover:bg-yellow-400 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2.5A1 1 0 006 17h11M10 21a1 1 0 11-2 0 1 1 0 012 0zm9 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                            </svg>
                            {{ $produk->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

<script>
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max) || Infinity;
        const value = parseInt(input.value) || 1;
        if (value < max) input.value = value + 1;
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value) || 1;
        if (value > 1) input.value = value - 1;
    }

    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        // TODO: ganti dengan request ke keranjang (butuh tabel/controller keranjang)
        alert('{{ addslashes($produk->nama_produk) }} ditambahkan ke keranjang (' + quantity + ' item).');
    }
</script>

@endsection