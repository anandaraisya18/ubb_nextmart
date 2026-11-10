@extends('pelanggan.layouts.app')

@section('title', 'Produk - UBB Nextmart')

@section('content')

<section class="min-h-screen bg-[#f8fafc] py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <span class="text-sm font-bold text-[#102A71] uppercase tracking-wider">
                Jelajahi Katalog
            </span>

            <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold text-[#001840]">
                Semua Produk
            </h1>

            <p class="mt-3 text-sm sm:text-base text-gray-500">
                Temukan berbagai kebutuhanmu di UBB Nextmart.
            </p>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="mb-6 flex flex-wrap items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                <span>{{ session('success') }}</span>

                <a href="{{ route('pelanggan.keranjang.index') }}"
                   class="font-bold underline">
                    Lihat Keranjang →
                </a>
            </div>
        @endif

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

        {{-- FILTER --}}
        <form method="GET"
              action="{{ route('pelanggan.produk.index') }}"
              class="grid grid-cols-1 sm:grid-cols-[1fr_220px_auto_auto] gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">

            @if(request()->filled('group'))
                <input type="hidden" name="group" value="{{ request('group') }}">
            @endif

            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari nama produk..."
                   class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]">

            <select name="kategori"
                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#F5C400]">

                <option value="">Semua Kategori</option>

                @foreach($kategori as $k)
                    <option value="{{ $k->id_kategori }}"
                            @selected(request('kategori') == $k->id_kategori)>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach

            </select>

            <button type="submit"
                    class="rounded-xl bg-[#001840] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#102A71] transition">
                Cari Produk
            </button>

            <a href="{{ route('pelanggan.produk.index', request()->filled('group') ? ['group' => request('group')] : []) }}"
               class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-center text-sm font-semibold text-gray-600 hover:border-[#102A71] hover:text-[#102A71] transition">
                Reset
            </a>

        </form>

        {{-- INFORMASI HASIL --}}
        <div class="mt-8 mb-5 flex items-center justify-between gap-3">
            <h2 class="text-lg font-bold text-[#001840]">
                Daftar Produk
            </h2>

            <span class="text-xs sm:text-sm text-gray-500">
                {{ $produk->total() }} produk ditemukan
            </span>
        </div>

        {{-- GRID PRODUK --}}
        @if($produk->count() > 0)

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">

                @foreach($produk as $item)
                    @php
                        $namaToko = $item->toko->nama_toko ?? $item->toko->nama ?? '-';
                        $stok = (int) $item->stok;
                    @endphp

                    <div class="group flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white hover:border-[#102A71]/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                        {{-- GAMBAR PRODUK --}}
                        <a href="{{ route('pelanggan.produk.show', $item) }}"
                           class="relative block aspect-square overflow-hidden bg-gray-100">

                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     alt="{{ $item->nama_produk }}"
                                     class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-4xl text-gray-300">
                                    ▣
                                </div>
                            @endif

                            @if($item->kategori)
                                <span class="absolute top-3 left-3 max-w-[70%] truncate rounded-full bg-[#F5C400] px-2.5 py-1 text-[10px] font-bold text-[#001840]">
                                    {{ $item->kategori->nama_kategori }}
                                </span>
                            @endif

                            @if($stok <= 0)
                                <span class="absolute top-3 right-3 rounded-full bg-red-500 px-2.5 py-1 text-[10px] font-bold text-white">
                                    Stok Habis
                                </span>
                            @elseif($stok <= 5)
                                <span class="absolute top-3 right-3 rounded-full bg-red-500 px-2.5 py-1 text-[10px] font-bold text-white">
                                    Sisa {{ $stok }}
                                </span>
                            @endif

                        </a>

                        {{-- INFORMASI PRODUK --}}
                        <div class="flex flex-1 flex-col p-4">

                            <p class="text-[11px] text-gray-400 truncate">
                                {{ $namaToko }}
                            </p>

                            <a href="{{ route('pelanggan.produk.show', $item) }}">
                                <h3 class="mt-1 font-bold text-sm sm:text-base text-[#001840] line-clamp-2 hover:text-[#102A71] transition">
                                    {{ $item->nama_produk }}
                                </h3>
                            </a>

                            <p class="mt-2 text-sm sm:text-base font-extrabold text-[#102A71]">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </p>

                            {{-- TAMBAH KE KERANJANG --}}
                            <div class="mt-auto pt-4">

                                @if($stok > 0)
                                    <form method="POST"
                                          action="{{ route('pelanggan.keranjang.store') }}"
                                          class="space-y-3">

                                        @csrf

                                        <input type="hidden"
                                               name="id_produk"
                                               value="{{ $item->id_produk }}">

                                        <button type="submit"
                                                class="w-full rounded-xl bg-[#F5C400] py-2.5 text-xs sm:text-sm font-bold text-[#001840] hover:bg-[#102A71] hover:text-[#F5C400] transition active:scale-[0.98]">
                                            + Keranjang
                                        </button>

                                    </form>
                                @else
                                    <button type="button"
                                            disabled
                                            class="w-full cursor-not-allowed rounded-xl bg-gray-100 py-2.5 text-xs sm:text-sm font-bold text-gray-400">
                                        Stok Habis
                                    </button>
                                @endif

                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            @if($produk->hasPages())
                <div class="mt-10">
                    {{ $produk->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center">
                <div class="text-4xl text-gray-300">▣</div>

                <p class="mt-4 font-bold text-[#001840]">
                    Produk tidak ditemukan
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Coba ubah kata kunci atau kategori pencarianmu.
                </p>

                <a href="{{ route('pelanggan.produk.index', request()->filled('group') ? ['group' => request('group')] : []) }}"
                   class="mt-5 inline-flex rounded-xl bg-[#F5C400] px-5 py-2.5 text-sm font-bold text-[#001840] hover:bg-yellow-400 transition">
                    Reset Pencarian
                </a>
            </div>

        @endif

    </div>
</section>

@endsection
