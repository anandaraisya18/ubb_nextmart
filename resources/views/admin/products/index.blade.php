<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-[#1f2937]">

    @include('admin.components.sidebar')

    <main class="lg:ml-[250px] min-h-screen">

        @include('admin.components.topbar', [
            'title' => 'Kelola Produk',
            'subtitle' => 'Kelola produk yang tersedia di UBB Nexmart'
        ])

        <section class="p-4 sm:p-6 lg:p-8">

            {{-- ALERT --}}
            @if(session('success'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-[#e7f7ed] border border-[#ccebd8] text-[#218448] text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-[#feecec] border border-[#f5d0d0] text-[#c83b3b] text-xs">
                    {{ session('error') }}
                </div>
            @endif

            {{-- BANNER --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-[#001840] to-[#102A71] rounded-2xl px-5 py-6 sm:px-7 lg:px-8 lg:py-7 mb-7 text-white">
                <div class="absolute -right-12 -top-16 h-44 w-44 rounded-full border-[25px] border-[#F5C400]/15"></div>

                <div class="relative z-10">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">Kelola Produk</h2>
                    <p class="text-xs sm:text-sm text-blue-100 leading-6">
                        Tambahkan, ubah, lihat, dan kelola produk yang tersedia di UBB Nexmart.
                    </p>
                </div>

                <a href="{{ route('admin.products.create') }}"
                   class="relative z-10 inline-flex items-center gap-2 mt-5 sm:mt-0 sm:absolute sm:right-7 sm:top-1/2 sm:-translate-y-1/2 bg-[#F5C400] text-[#001840] px-4 py-2.5 rounded-xl text-xs font-bold transition hover:-translate-y-0.5 hover:bg-[#ffd21a] sm:hover:[--tw-translate-y:calc(-50%-2px)]">
                    <span class="text-base">+</span> Tambah Produk
                </a>
            </div>

            {{-- STATISTIK --}}
            <div class="mb-7 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

                {{-- Total Produk --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Total Produk</p>
                            <h3 class="text-2xl font-bold text-[#001840]">{{ $totalProduk }}</h3>
                            <p class="text-[10px] text-gray-400 mt-1">Produk terdaftar</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-[#eef2fb] text-[#102A71] flex items-center justify-center text-lg font-bold">▣</div>
                    </div>
                </div>

                {{-- Produk Tersedia --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Produk Tersedia</p>
                            <h3 class="text-2xl font-bold text-[#001840]">{{ $produkTersedia }}</h3>
                            <p class="text-[10px] text-gray-400 mt-1">Aktif dan stok tersedia</p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-[#e7f7ed] text-[#218448] flex items-center justify-center text-lg font-bold">✓</div>
                    </div>
                </div>

                {{-- Stok Habis --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Stok Habis</p>
                            <h3 class="text-2xl font-bold text-[#001840]">{{ $stokHabis }}</h3>
                            <p class="text-[10px] mt-1 {{ $stokHabis > 0 ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                                {{ $stokHabis > 0 ? 'Perlu segera diisi ulang' : 'Semua produk masih ada stok' }}
                            </p>
                        </div>
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-bold {{ $stokHabis > 0 ? 'bg-[#feecec] text-[#c83b3b]' : 'bg-[#e7f7ed] text-[#218448]' }}">
                            {{ $stokHabis > 0 ? '!' : '✓' }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- PANEL PRODUK --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-[#001840]">Daftar Produk</h3>
                        <p class="text-[10px] sm:text-xs text-gray-500 mt-1">Daftar produk yang tersedia di sistem.</p>
                    </div>
                    <div class="self-start sm:self-auto bg-[#001840] text-white px-3 py-1.5 rounded-full text-[10px] font-semibold">
                        Total: <span class="text-[#F5C400]">{{ $totalProduk }}</span>
                    </div>
                </div>

                @if($products->count() > 0)

                    {{-- DESKTOP TABLE --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Produk</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Toko</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Harga</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Stok</th>
                                    <th class="text-left px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Status</th>
                                    <th class="text-right px-5 py-3 text-[10px] font-semibold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                    @php
                                        $warnaStok = $product->stok <= 0
                                            ? 'text-red-600'
                                            : ($product->stok <= 5 ? 'text-orange-600' : 'text-gray-700');
                                    @endphp

                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">

                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3 min-w-[230px]">
                                                <div class="w-12 h-12 shrink-0 rounded-xl bg-[#eef2fb] text-[#102A71] flex items-center justify-center overflow-hidden">
                                                    @if($product->gambar)
                                                        <img src="{{ asset('storage/' . $product->gambar) }}"
                                                             alt="{{ $product->nama_produk }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-lg font-bold">▣</span>
                                                    @endif
                                                </div>

                                                <div class="min-w-0">
                                                    <strong class="block text-xs font-semibold text-[#001840]">
                                                        {{ $product->nama_produk }}
                                                    </strong>
                                                    <span class="block text-[10px] text-gray-500 mt-1 truncate max-w-[220px]">
                                                        {{ $product->deskripsi ?: 'Tidak ada deskripsi' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-xs text-gray-600">
                                            {{ $product->toko->nama_toko ?? '-' }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <span class="text-xs font-bold text-[#001840] whitespace-nowrap">
                                                Rp{{ number_format($product->harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4">
                                            <span class="text-xs font-semibold {{ $warnaStok }}">{{ $product->stok }}</span>
                                        </td>

                                        <td class="px-5 py-4">
                                            @if($product->status === 'nonaktif')
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">Nonaktif</span>
                                            @elseif($product->stok > 0)
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#e7f7ed] text-[#218448]">Tersedia</span>
                                            @else
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[#feecec] text-[#c83b3b]">Stok Habis</span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">

                                                <a href="{{ route('admin.products.edit', $product) }}" title="Edit"
                                                   class="w-8 h-8 rounded-lg bg-[#fff8d6] text-[#967500] flex items-center justify-center hover:bg-[#F5C400] hover:text-[#001840] transition">✎</a>

                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus"
                                                            class="w-8 h-8 rounded-lg bg-[#feecec] text-[#c83b3b] flex items-center justify-center hover:bg-[#dc4545] hover:text-white transition">🗑</button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE CARDS --}}
                    <div class="md:hidden">
                        @foreach($products as $product)
                            <div class="p-4 border-b border-gray-100 last:border-b-0">

                                <div class="flex gap-3">
                                    <div class="w-12 h-12 shrink-0 rounded-xl bg-[#eef2fb] text-[#102A71] flex items-center justify-center overflow-hidden">
                                        @if($product->gambar)
                                            <img src="{{ asset('storage/' . $product->gambar) }}"
                                                 alt="{{ $product->nama_produk }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="font-bold">▣</span>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <strong class="block text-sm text-[#001840]">{{ $product->nama_produk }}</strong>
                                        <p class="text-xs font-bold text-[#102A71] mt-1">
                                            Rp{{ number_format($product->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="text-[10px] text-gray-500 mt-1">
                                            {{ $product->toko->nama_toko ?? '-' }} · Stok: {{ $product->stok }}
                                            @if($product->status === 'nonaktif') · Nonaktif @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 mt-4">

                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="h-9 rounded-lg bg-[#fff8d6] text-[#967500] flex items-center justify-center text-[10px] font-semibold">Edit</a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full h-9 rounded-lg bg-[#feecec] text-[#c83b3b] text-[10px] font-semibold">Hapus</button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- PAGINATION --}}
                    @if($products->hasPages())
                        <div class="px-5 py-4 border-t border-gray-100">
                            {{ $products->links() }}
                        </div>
                    @endif

                @else

                    {{-- EMPTY STATE --}}
                    <div class="px-5 py-16 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#eef2fb] text-[#102A71] flex items-center justify-center text-2xl font-bold">▣</div>
                        <h3 class="text-base font-bold text-[#001840] mb-2">Belum Ada Produk</h3>
                        <p class="text-xs text-gray-500 mb-5">Belum ada produk yang ditambahkan ke sistem.</p>
                        <a href="{{ route('admin.products.create') }}"
                           class="inline-flex items-center gap-2 bg-[#102A71] text-white px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#001840] transition">
                            <span class="text-base">+</span> Tambah Produk
                        </a>
                    </div>

                @endif

            </div>

        </section>

    </main>

</body>
</html>