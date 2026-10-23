<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-[250px]">

        @include('admin.components.topbar', [
            'title' => 'Pesanan',
            'subtitle' => 'Kelola dan pantau pesanan pelanggan'
        ])

        <section class="p-4 sm:p-5 md:p-7 lg:p-8">

            @php
                $badge = [
                    'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-700',
                    'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
                    'diproses'            => 'bg-blue-100 text-blue-700',
                    'siap_diambil'        => 'bg-indigo-100 text-indigo-700',
                    'selesai'             => 'bg-green-100 text-green-700',
                    'dibatalkan'          => 'bg-red-100 text-red-700',
                ];

                $stat = [
                [
                    'Total Pesanan', $total, 'bg-[#eef2fb] text-[#102A71]',
                    'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                ],
                [
                    'Menunggu Pembayaran', $counts['menunggu_pembayaran'] ?? 0, 'bg-yellow-50 text-yellow-600',
                    'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                ],
                [
                    'Menunggu Verifikasi', $counts['menunggu_verifikasi'] ?? 0, 'bg-orange-50 text-orange-600',
                    'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'Diproses', $counts['diproses'] ?? 0, 'bg-blue-50 text-blue-600',
                    'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                ],
                [
                    'Selesai', $counts['selesai'] ?? 0, 'bg-green-50 text-green-600',
                    'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
            ];
            @endphp

            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#ccebd8] bg-[#e7f7ed] px-4 py-3 text-xs text-[#218448]">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-[#f5d0d0] bg-[#feecec] px-4 py-3 text-xs text-[#c83b3b]">{{ session('error') }}</div>
            @endif

            {{-- BANNER --}}
            <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#001840] to-[#102A71] p-5 sm:p-6">
                <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full border-[25px] border-[#F5C400]/10"></div>
                <div class="absolute -bottom-16 right-24 h-32 w-32 rounded-full border-[18px] border-white/5"></div>

                <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-[#F5C400]">Order Management</span>
                        <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">Kelola Pesanan</h2>
                        <p class="mt-1 max-w-xl text-xs leading-5 text-white/80">
                            Pantau pesanan pelanggan, status, dan proses pesanan dari satu halaman.
                        </p>
                    </div>

                    <a href="{{ route('admin.orders.create') }}"
                       class="inline-flex w-fit items-center gap-2 rounded-xl bg-[#F5C400] px-4 py-2.5 text-xs font-bold text-[#001840] transition hover:bg-[#ffd21a]">
                        <span class="text-base">+</span> Tambah Pesanan
                    </a>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="mb-6 grid grid-cols-2 gap-3 md:grid-cols-3 xl:grid-cols-5">
                @foreach($stat as [$label, $jumlah, $warna, $icon])
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $warna }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                            </svg>
                        </div>
                        <p class="mt-4 text-2xl font-bold text-[#001840]">{{ $jumlah }}</p>
                        <p class="mt-1 text-[10px] text-gray-500">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- FILTER + TABEL --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <div class="border-b border-gray-200 p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-[#001840]">Daftar Pesanan</h2>
                            <p class="mt-1 text-[10px] text-gray-500">Daftar seluruh pesanan pelanggan UBB Nexmart.</p>
                        </div>

                        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col gap-2 sm:flex-row">
                            <input type="text" name="q" value="{{ request('q') }}" maxlength="100"
                                   placeholder="Cari no. resi / pelanggan..."
                                   class="h-10 w-full rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs outline-none transition focus:border-[#102A71] focus:bg-white sm:w-56">

                            <select name="status"
                                    class="h-10 rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs text-gray-600 outline-none focus:border-[#102A71]">
                                <option value="">Semua Status</option>
                                @foreach(\App\Models\Pesanan::STATUS as $value => $label)
                                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>

                            <button type="submit"
                                    class="h-10 rounded-lg bg-[#102A71] px-4 text-xs font-semibold text-white transition hover:bg-[#001840]">
                                Terapkan
                            </button>

                            <a href="{{ route('admin.orders.index') }}"
                               class="flex h-10 items-center justify-center rounded-lg border border-gray-200 px-4 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                                Reset
                            </a>
                        </form>
                    </div>
                </div>

                @if($orders->count() > 0)

                    {{-- DESKTOP --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="w-full min-w-[900px]">
                            <thead>
                                <tr class="border-b border-gray-100 bg-[#fafbfe]">
                                    @foreach(['Pesanan', 'Pelanggan', 'Tanggal', 'Total', 'Transaksi', 'Status'] as $th)
                                        <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">{{ $th }}</th>
                                    @endforeach
                                    <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wide text-gray-400">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($orders as $order)
                                    <tr class="transition hover:bg-[#fafbfe]">

                                        <td class="px-5 py-4">
                                            <p class="text-xs font-bold text-[#001840]">{{ $order->no_resi ?: '#' . $order->id_pesanan }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">ID {{ $order->id_pesanan }}</p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <p class="text-xs font-semibold text-gray-700">{{ $order->pelanggan->nama ?? '-' }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $order->pelanggan->no_hp ?? '-' }}</p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <p class="text-xs text-gray-700">{{ $order->tanggal_pesanan?->translatedFormat('d F Y') ?? '-' }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $order->tanggal_pesanan?->format('H:i') }} WIB</p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <p class="text-xs font-bold text-[#102A71]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <p class="text-xs font-medium text-gray-700">{{ \App\Models\Pesanan::TIPE[$order->tipe_transaksi] ?? $order->tipe_transaksi }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ \App\Models\Pesanan::PENGAMBILAN[$order->jenis_pengambilan] ?? $order->jenis_pengambilan }}</p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $badge[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700' }}">
                                                {{ \App\Models\Pesanan::STATUS[$order->status_pesanan] ?? $order->status_pesanan }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                   class="rounded-lg border border-gray-200 px-3 py-2 text-[10px] font-semibold text-[#102A71] transition hover:border-[#102A71] hover:bg-[#102A71] hover:text-white">
                                                    Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE --}}
                    <div class="divide-y divide-gray-100 md:hidden">
                        @foreach($orders as $order)
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-bold text-[#001840]">{{ $order->no_resi ?: '#' . $order->id_pesanan }}</p>
                                        <p class="mt-1 text-[10px] text-gray-400">
                                            {{ $order->tanggal_pesanan?->translatedFormat('d F Y') }} • {{ $order->tanggal_pesanan?->format('H:i') }} WIB
                                        </p>
                                    </div>
                                    <span class="inline-flex h-fit rounded-full px-2.5 py-1 text-[9px] font-semibold {{ $badge[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ \App\Models\Pesanan::STATUS[$order->status_pesanan] ?? $order->status_pesanan }}
                                    </span>
                                </div>

                                <div class="mt-4 rounded-xl bg-[#f8f9fc] p-4">
                                    <p class="text-xs font-bold text-gray-700">{{ $order->pelanggan->nama ?? '-' }}</p>
                                    <p class="mt-1 text-[10px] text-gray-400">{{ $order->pelanggan->no_hp ?? '-' }}</p>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wide text-gray-400">Transaksi</p>
                                        <p class="mt-1 text-xs font-semibold text-gray-700">{{ \App\Models\Pesanan::TIPE[$order->tipe_transaksi] ?? $order->tipe_transaksi }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wide text-gray-400">Total</p>
                                        <p class="mt-1 text-sm font-bold text-[#102A71]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="flex items-center justify-center rounded-lg bg-[#001840] px-4 py-3 text-[10px] font-semibold text-white">Detail</a>
                                    <a href="{{ route('admin.orders.edit', $order) }}"
                                       class="flex items-center justify-center rounded-lg bg-[#fff8d6] px-4 py-3 text-[10px] font-semibold text-[#967500]">Ubah Status</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($orders->hasPages())
                        <div class="border-t border-gray-100 px-5 py-4">{{ $orders->links() }}</div>
                    @endif

                @else

                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#eef2fb] text-xl text-[#102A71]">▤</div>
                        <h3 class="mt-4 text-sm font-bold text-[#001840]">Belum Ada Pesanan</h3>
                        <p class="mx-auto mt-1 max-w-sm text-xs text-gray-500">
                            {{ request()->hasAny(['q', 'status']) ? 'Tidak ada pesanan yang sesuai dengan filter.' : 'Pesanan pelanggan yang masuk akan ditampilkan di halaman ini.' }}
                        </p>
                    </div>

                @endif

            </div>

        </section>
    </main>

</body>
</html>