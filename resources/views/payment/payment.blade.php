<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-[250px]">

        @include('admin.components.topbar', [
            'title' => 'Transaksi',
            'subtitle' => 'Riwayat transaksi pembayaran yang telah dikonfirmasi'
        ])

        <section class="p-4 sm:p-5 md:p-7 lg:p-8">

            {{-- BANNER --}}
            <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#001840] to-[#102A71] p-5 sm:p-6">
                <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full border-[25px] border-[#F5C400]/10"></div>
                <div class="absolute -bottom-16 right-24 h-32 w-32 rounded-full border-[18px] border-white/5"></div>

                <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-[#F5C400]">Transaction Management</span>
                        <h2 class="mt-1 text-xl font-bold text-white sm:text-2xl">Riwayat Transaksi</h2>
                        <p class="mt-1 max-w-2xl text-xs leading-5 text-white/80">
                            Kelola dan pantau transaksi pembayaran yang telah berhasil dikonfirmasi oleh admin.
                        </p>
                    </div>

                    <a href="{{ route('admin.payment.export', request()->query()) }}" target="_blank"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#F5C400] px-4 py-3 text-xs font-bold text-[#001840] shadow-sm transition hover:bg-yellow-300 sm:w-auto">
                        Export Laporan
                    </a>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="mb-6 grid grid-cols-2 gap-4 xl:grid-cols-4">
                @php
                    $rata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
                    $stat = [
                        ['Total Transaksi',     $totalTransaksi,                                   'bg-[#eef2fb] text-[#102A71]'],
                        ['Transaksi Berhasil',  $transaksiBerhasil,                                'bg-green-50 text-green-600'],
                        ['Total Pendapatan',    'Rp ' . number_format($totalPendapatan, 0, ',', '.'), 'bg-[#fff8d6] text-[#806800]'],
                        ['Rata-rata Transaksi', 'Rp ' . number_format($rata, 0, ',', '.'),         'bg-blue-50 text-blue-600'],
                    ];
                @endphp

                @foreach($stat as [$label, $nilai, $warna])
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $warna }} text-sm font-bold">Rp</div>
                        <p class="mt-4 text-xl font-bold text-[#001840]">{{ $nilai }}</p>
                        <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- RINGKASAN METODE --}}
            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff8d6] text-xs font-black text-[#806800]">QR</div>
                        <div>
                            <p class="text-xs font-bold text-[#001840]">QRIS</p>
                            <p class="mt-1 text-[10px] text-gray-400">Total transaksi melalui QRIS</p>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-[#102A71]">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</p>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef2fb] text-xs font-black text-[#102A71]">TF</div>
                        <div>
                            <p class="text-xs font-bold text-[#001840]">Transfer Bank</p>
                            <p class="mt-1 text-[10px] text-gray-400">Total transaksi melalui transfer</p>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-[#102A71]">Rp {{ number_format($transferTotal, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- DAFTAR --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <div class="border-b border-gray-200 p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-[#001840]">Daftar Transaksi</h2>
                            <p class="mt-1 text-[10px] text-gray-500">Transaksi yang telah berhasil dikonfirmasi admin.</p>
                        </div>

                        <form method="GET" action="{{ route('admin.payment.payment') }}" class="flex flex-col gap-2 sm:flex-row">
                            <input type="text" name="q" value="{{ request('q') }}" maxlength="100"
                                   placeholder="Cari transaksi / pelanggan..."
                                   class="h-10 w-full rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs outline-none transition focus:border-[#102A71] focus:bg-white sm:w-52">

                            <select name="metode" class="h-10 rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs text-gray-600 outline-none focus:border-[#102A71]">
                                <option value="">Semua Pembayaran</option>
                                <option value="QRIS" @selected(request('metode') === 'QRIS')>QRIS</option>
                                <option value="Transfer Bank" @selected(request('metode') === 'Transfer Bank')>Transfer Bank</option>
                            </select>

                            <select name="periode" class="h-10 rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs text-gray-600 outline-none focus:border-[#102A71]">
                                <option value="">Semua Periode</option>
                                <option value="hari_ini" @selected(request('periode') === 'hari_ini')>Hari Ini</option>
                                <option value="minggu_ini" @selected(request('periode') === 'minggu_ini')>Minggu Ini</option>
                                <option value="bulan_ini" @selected(request('periode') === 'bulan_ini')>Bulan Ini</option>
                            </select>

                            <button type="submit" class="h-10 rounded-lg bg-[#102A71] px-4 text-xs font-semibold text-white transition hover:bg-[#001840]">Terapkan</button>

                            <a href="{{ route('admin.payment.payment') }}"
                               class="flex h-10 items-center justify-center rounded-lg border border-gray-200 px-4 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">Reset</a>
                        </form>
                    </div>
                </div>

                @if($transactions->count() > 0)

                    {{-- DESKTOP --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="w-full min-w-[950px]">
                            <thead>
                                <tr class="border-b border-gray-100 bg-[#fafbfe]">
                                    @foreach(['Transaksi', 'Pesanan', 'Pelanggan', 'Tanggal', 'Pembayaran', 'Nominal', 'Status'] as $th)
                                        <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">{{ $th }}</th>
                                    @endforeach
                                    <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wide text-gray-400">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($transactions as $t)
                                    <tr class="transition hover:bg-[#fafbfe]">
                                        <td class="px-5 py-4">
                                            <p class="text-xs font-bold text-[#001840]">TRX-{{ $t->id }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $t->verified_at }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="text-xs font-semibold text-[#102A71]">ORD-{{ $t->order_id }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="text-xs font-semibold text-gray-700">{{ $t->customer }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $t->phone ?? '-' }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="text-xs text-gray-700">{{ $t->date }}</p>
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $t->time }} WIB</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex rounded-lg px-2.5 py-1 text-[9px] font-semibold {{ $t->payment === 'QRIS' ? 'bg-yellow-50 text-yellow-700' : 'bg-blue-50 text-blue-700' }}">
                                                {{ $t->payment }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="text-xs font-bold text-[#102A71]">Rp {{ number_format($t->total, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-[9px] font-semibold text-green-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Berhasil
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <a href="{{ route('admin.orders.show', $t->order_id) }}"
                                               class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-2 text-[10px] font-semibold text-[#102A71] transition hover:border-[#102A71] hover:bg-[#102A71] hover:text-white">
                                                Detail Pesanan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE --}}
                    <div class="divide-y divide-gray-100 md:hidden">
                        @foreach($transactions as $t)
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-bold text-[#001840]">TRX-{{ $t->id }}</p>
                                        <p class="mt-1 text-[10px] text-gray-400">{{ $t->date }}</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-[9px] font-semibold text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Berhasil
                                    </span>
                                </div>

                                <div class="mt-4 rounded-xl bg-[#f8f9fc] p-4">
                                    <p class="text-xs font-bold text-gray-700">{{ $t->customer }}</p>
                                    <p class="mt-1 text-[10px] text-gray-400">{{ $t->phone ?? '-' }}</p>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wide text-gray-400">Pesanan</p>
                                        <p class="mt-1 text-xs font-semibold text-[#102A71]">ORD-{{ $t->order_id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wide text-gray-400">Pembayaran</p>
                                        <p class="mt-1 text-xs font-semibold text-gray-700">{{ $t->payment }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-[9px] uppercase tracking-wide text-gray-400">Nominal</p>
                                        <p class="mt-1 text-base font-bold text-[#102A71]">Rp {{ number_format($t->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <a href="{{ route('admin.orders.show', $t->order_id) }}"
                                   class="mt-4 flex w-full items-center justify-center rounded-lg border border-gray-200 px-4 py-3 text-[10px] font-semibold text-[#102A71] transition hover:bg-[#102A71] hover:text-white">
                                    Lihat Detail Pesanan
                                </a>
                            </div>
                        @endforeach
                    </div>

                @else

                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#eef2fb] text-xl text-[#102A71]">Rp</div>
                        <h3 class="mt-4 text-sm font-bold text-[#001840]">Belum Ada Transaksi</h3>
                        <p class="mx-auto mt-1 max-w-sm text-xs text-gray-500">
                            {{ request()->hasAny(['q', 'metode', 'periode']) ? 'Tidak ada transaksi yang sesuai dengan filter.' : 'Transaksi yang telah berhasil dikonfirmasi admin akan muncul di halaman ini.' }}
                        </p>
                    </div>

                @endif

            </div>

        </section>
    </main>

</body>
</html>