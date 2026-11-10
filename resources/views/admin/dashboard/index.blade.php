<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-[#1f2937]">

    @include('admin.components.sidebar')

    <main class="lg:ml-[250px] min-h-screen">

        @include('admin.components.topbar', [
            'title' => 'Dashboard',
            'subtitle' => 'Kelola operasional UBB Nexmart'
        ])

        <section class="p-5 md:p-8">

            @php
                $adminLogin = auth('admin')->user();
                $namaAdmin  = $adminLogin->nama ?? $adminLogin->name ?? 'Admin';

                $badge = [
                    'menunggu_pembayaran' => 'bg-[#fff8d6] text-[#967500]',
                    'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
                    'diproses'            => 'bg-[#e8eefc] text-[#102A71]',
                    'siap_diambil'        => 'bg-indigo-100 text-indigo-700',
                    'selesai'             => 'bg-[#e7f7ed] text-[#218448]',
                    'dibatalkan'          => 'bg-[#feecec] text-[#c83b3b]',
                ];

               $stat = [
                    ['Total Produk',     $totalProduk,     '▣',  'bg-[#eef2fb] text-[#102A71]'],
                    ['Total Pesanan', $totalPesanan, 'clipboard-list', 'bg-[#eef2fb] text-[#102A71]'],
                    ['Pesanan Diproses', $pesananDiproses, '⟳',  'bg-[#fff8d6] text-[#b58d00]'],
                    ['Total Transaksi',  $totalTransaksi,  'Rp', 'bg-[#fff8d6] text-[#b58d00]'],
                ];

                $akses = [
                    ['Tambah Produk',   route('admin.products.create'),  '+',  'bg-[#102A71] text-white'],
                    ['Kelola Produk',   route('admin.products.index'),   '▣',  'bg-[#102A71] text-white'],
                    ['Kelola Kategori', route('admin.categories.index'), '☷',  'bg-[#F5C400] text-[#001840]'],
                    ['Lihat Pesanan', route('admin.orders.index'), 'clipboard-list', 'bg-[#102A71] text-white'],
                    ['Transaksi',       route('admin.payment.payment'),  'Rp', 'bg-[#F5C400] text-[#001840]'],
                ];
            @endphp

            {{-- WELCOME --}}
            <div class="bg-gradient-to-br from-[#001840] to-[#102A71] rounded-[18px] px-6 py-7 md:px-8 text-white flex items-center justify-between mb-7 overflow-hidden relative">
                <div class="absolute -right-12 -top-16 h-44 w-44 rounded-full border-[25px] border-[#F5C400]/15"></div>

                <div>
                    <h2 class="text-xl md:text-[22px] font-bold mb-2">Selamat Datang, {{ $namaAdmin }}! 👋</h2>
                    <p class="text-xs md:text-[13px] text-[#cbd5e8]">
                        Pantau dan kelola aktivitas toko, produk, pesanan, serta transaksi dari satu tempat.
                    </p>
                </div>

                <div class="hidden md:block bg-[#F5C400] text-[#001840] px-4 py-2.5 rounded-[10px] text-xs font-bold relative z-10">
                    ADMIN PANEL
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-[18px] mb-7">
                @foreach($stat as [$label, $nilai, $ikon, $warna])
                    <div class="bg-white rounded-[15px] p-5 border border-gray-200 flex items-center justify-between transition hover:-translate-y-1 hover:shadow-lg">
                        <div>
                            <p class="text-xs text-gray-500 mb-2">{{ $label }}</p>
                            <h3 class="text-[25px] font-bold text-[#001840]">{{ number_format($nilai, 0, ',', '.') }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl {{ $warna }} flex items-center justify-center">
                        @if ($ikon === 'clipboard-list')
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="8" y="3" width="8" height="4" rx="1"/>
                                <path d="M8 5H6a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                <path d="M10 12h4M10 16h4"/>
                            </svg>
                        @else
                            <span class="text-xl font-bold">{{ $ikon }}</span>
                        @endif
                    </div>
                    </div>
                @endforeach
            </div>

    
            {{-- AKSES CEPAT --}}
            <h2 class="text-[17px] font-bold text-[#001840] mb-[15px]">Akses Cepat</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-[15px] mb-[30px]">
                @foreach($akses as [$label, $url, $ikon, $warna])
                    <a href="{{ $url }}"
                    class="bg-white border border-gray-200 rounded-[14px] p-5 text-center text-[#001840] transition hover:border-[#F5C400] hover:-translate-y-1 hover:shadow-lg">

                        <div class="w-[45px] h-[45px] mx-auto mb-2.5 {{ $warna }} rounded-[11px] flex items-center justify-center">
                            @if ($ikon === 'clipboard-list')
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="8" y="3" width="8" height="4" rx="1"/>
                                    <path d="M8 5H6a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                    <path d="M10 12h4M10 16h4"/>
                                </svg>
                            @else
                                <span class="text-lg font-bold">{{ $ikon }}</span>
                            @endif
                        </div>

                        <span class="text-xs font-semibold">{{ $label }}</span>
                    </a>
                @endforeach
            </div>


            {{-- BAWAH --}}
            <div class="grid grid-cols-1 xl:grid-cols-[1.5fr_1fr] gap-5">

            

                {{-- PESANAN TERBARU --}}
                <div class="bg-white border border-gray-200 rounded-[15px] p-5 overflow-hidden">
                    <div class="flex items-center justify-between mb-[18px]">
                        <h3 class="text-[15px] font-bold text-[#001840]">Pesanan Terbaru</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-[11px] text-[#102A71]">Lihat Semua →</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    @foreach(['ID Pesanan', 'Pelanggan', 'Total', 'Status'] as $th)
                                        <th class="text-left text-[11px] text-gray-500 p-2.5 border-b border-gray-200 whitespace-nowrap">{{ $th }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($pesananTerbaru as $order)
                                    <tr>
                                        <td class="p-3 text-xs border-b border-gray-100">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-[#001840] hover:text-[#102A71]">
                                                #ORD-{{ $order->id_pesanan }}
                                            </a>
                                        </td>
                                        <td class="p-3 text-xs border-b border-gray-100">{{ $order->pelanggan->nama ?? '-' }}</td>
                                        <td class="p-3 text-xs border-b border-gray-100">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td class="p-3 text-xs border-b border-gray-100">
                                            <span class="inline-block px-2 py-1 rounded-full text-[10px] font-semibold {{ $badge[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ \App\Models\Pesanan::STATUS[$order->status_pesanan] ?? $order->status_pesanan }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-xs text-gray-500">Belum ada pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- STORE --}}
                <div class="bg-white border border-gray-200 rounded-[15px] p-5">
                    <div class="flex items-center justify-between mb-[18px]">
                        <h3 class="text-[15px] font-bold text-[#001840]">Store</h3>
                    </div>

                    @forelse($tokoList as $toko)
                        @php $namaToko = $toko->nama_toko ?? $toko->nama ?? 'Toko #' . $toko->id_toko; @endphp

                        <div class="flex items-center justify-between py-[13px] {{ $loop->last ? '' : 'border-b border-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="w-[38px] h-[38px] rounded-[10px] bg-[#eef2fb] text-[#102A71] flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($namaToko, 0, 1)) }}
                                </div>
                                <strong class="block text-xs text-[#001840]">{{ $namaToko }}</strong>
                            </div>

                            <div class="text-[11px] font-semibold text-[#102A71]">{{ $toko->produk_count }} produk</div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-xs text-gray-500">Belum ada toko.</p>
                    @endforelse
                </div>

            </div>

        </section>
    </main>

</body>
</html>