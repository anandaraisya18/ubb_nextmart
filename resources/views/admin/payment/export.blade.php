<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            @page { size: A4 landscape; margin: 12mm; }
            body { background: white !important; }
            body * { visibility: hidden; }
            #report, #report * { visibility: visible; }
            #report {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }
            .print-hidden { display: none !important; }
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="print-hidden">
        @include('admin.components.sidebar')
    </div>

    <main class="lg:ml-[250px] min-h-screen">

        <div class="print-hidden">
            @include('admin.components.topbar', [
                'title' => 'Laporan Transaksi',
                'subtitle' => 'Laporan pesanan yang telah selesai'
            ])
        </div>

        <div class="p-4 sm:p-6 lg:p-8">

            @php
                $namaPeriode = [
                    'hari_ini' => 'Hari Ini (' . now()->translatedFormat('d F Y') . ')',
                    'minggu_ini' => 'Minggu Ini (' .
                        now()->startOfWeek()->translatedFormat('d F Y') . ' - ' .
                        now()->endOfWeek()->translatedFormat('d F Y') . ')',
                    'bulan_ini' => 'Bulan Ini (' . now()->translatedFormat('F Y') . ')',
                ];

                if (request('periode') && isset($namaPeriode[request('periode')])) {
                    $periodeLabel = $namaPeriode[request('periode')];
                } else {
                    $tglAwal = $transactions->pluck('tanggal_pesanan')->filter()->min();
                    $tglAkhir = $transactions->pluck('tanggal_pesanan')->filter()->max();

                    $periodeLabel = $tglAwal
                        ? \Carbon\Carbon::parse($tglAwal)->translatedFormat('d F Y') . ' - ' .
                            \Carbon\Carbon::parse($tglAkhir)->translatedFormat('d F Y')
                        : 'Semua periode';
                }

                $rata = $totalTransaksi > 0
                    ? $totalPendapatan / $totalTransaksi
                    : 0;
            @endphp

            {{-- TOMBOL --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-6 print-hidden">
                <a href="{{ route('admin.payment.payment', request()->query()) }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-[#102A71] bg-white text-[#102A71] text-sm font-semibold hover:bg-[#102A71] hover:text-white transition">
                    ← Kembali ke Transaksi
                </a>

                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#F5C400] text-[#001840] text-sm font-bold hover:bg-yellow-400 transition shadow-sm">
                    Export / Simpan sebagai PDF
                </button>
            </div>

            {{-- LAPORAN --}}
            <div id="report" class="max-w-6xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 md:px-10 py-8 border-b-2 border-[#001840]">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">
                        <div>
                            <p class="text-xl md:text-2xl font-extrabold text-[#001840]">
                                UBB NEXTMART
                            </p>
                            <p class="text-sm font-semibold text-[#102A71] mt-1">
                                Laporan Pesanan Selesai
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Sistem Informasi UBB Nextmart
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-xs font-bold text-[#001840] uppercase tracking-wider">
                                LAPORAN TRANSAKSI
                            </p>
                            <p class="text-[11px] text-gray-500 mt-2">
                                Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                            <p class="text-[11px] text-gray-500 mt-1">
                                Status: Pesanan Selesai
                            </p>
                        </div>
                    </div>
                </div>

                {{-- PERIODE --}}
                <div class="px-6 md:px-10 pt-6">
                    <div class="bg-[#f4f7fc] border-l-4 border-[#F5C400] rounded-r-lg px-4 py-3">
                        <p class="text-[10px] uppercase tracking-wider text-gray-400">
                            Periode Laporan
                        </p>
                        <p class="text-sm font-bold text-[#001840] mt-1">
                            {{ $periodeLabel }}
                        </p>

                        @if(request('metode') || request('q'))
                            <p class="text-[10px] text-gray-500 mt-1">
                                Filter:
                                @if(request('metode'))
                                    Metode {{ request('metode') }}
                                @endif
                                @if(request('q'))
                                    · Kata kunci "{{ request('q') }}"
                                @endif
                            </p>
                        @endif
                    </div>
                </div>

                {{-- RINGKASAN --}}
                <div class="px-6 md:px-10 py-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-[9px] uppercase text-gray-400">Total Pesanan Selesai</p>
                            <p class="text-xl font-bold text-[#001840] mt-2">
                                {{ $totalTransaksi }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-[9px] uppercase text-gray-400">Pesanan Berhasil</p>
                            <p class="text-xl font-bold text-green-600 mt-2">
                                {{ $transaksiBerhasil }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-[9px] uppercase text-gray-400">Total Pendapatan</p>
                            <p class="text-lg font-bold text-[#102A71] mt-2">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-[9px] uppercase text-gray-400">Rata-rata Pesanan</p>
                            <p class="text-lg font-bold text-[#001840] mt-2">
                                Rp {{ number_format($rata, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- TABEL PESANAN --}}
                <div class="px-6 md:px-10 pb-8">
                    <h2 class="text-sm font-bold text-[#001840] mb-4">
                        Detail Pesanan Selesai
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-[#001840] text-white">
                                    <th class="px-3 py-3 text-left text-[9px]">No</th>
                                    <th class="px-3 py-3 text-left text-[9px]">ID Pesanan</th>
                                    <th class="px-3 py-3 text-left text-[9px]">No. Resi</th>
                                    <th class="px-3 py-3 text-left text-[9px]">Pelanggan</th>
                                    <th class="px-3 py-3 text-left text-[9px]">Tanggal</th>
                                    <th class="px-3 py-3 text-left text-[9px]">Jenis Transaksi</th>
                                    <th class="px-3 py-3 text-right text-[9px]">Nominal</th>
                                    <th class="px-3 py-3 text-left text-[9px]">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($transactions as $index => $t)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-3 py-3 text-xs text-gray-600">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-3 py-3 text-xs font-bold text-[#001840]">
                                            ORD-{{ $t->order_id }}
                                        </td>

                                        <td class="px-3 py-3 text-xs font-semibold text-[#102A71]">
                                            {{ $t->no_resi ?? '-' }}
                                        </td>

                                        <td class="px-3 py-3 text-xs text-gray-700">
                                            {{ $t->customer ?? '-' }}
                                        </td>

                                        <td class="px-3 py-3 text-xs text-gray-600">
                                            {{ $t->date }}
                                        </td>

                                        <td class="px-3 py-3 text-xs text-gray-600">
                                            {{ $t->payment }}
                                        </td>

                                        <td class="px-3 py-3 text-xs font-bold text-[#102A71] text-right">
                                            Rp {{ number_format($t->total, 0, ',', '.') }}
                                        </td>

                                        <td class="px-3 py-3 text-xs font-semibold text-green-600">
                                            Selesai
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-3 py-10 text-center text-xs text-gray-500">
                                            Tidak ada pesanan selesai pada periode ini.
                                        </td>
                                    </tr>
                                @endforelse

                                <tr class="bg-[#f4f7fc]">
                                    <td colspan="6" class="px-3 py-4 text-right text-xs font-bold text-[#001840]">
                                        TOTAL PENDAPATAN
                                    </td>
                                    <td class="px-3 py-4 text-right text-sm font-bold text-[#102A71]">
                                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- RINGKASAN JENIS TRANSAKSI --}}
                <div class="px-6 md:px-10 pb-8">
                    <h2 class="text-sm font-bold text-[#001840] mb-4">
                        Ringkasan Jenis Transaksi
                    </h2>

                    <div class="max-w-md">

                        <div class="flex justify-between py-3 border-b border-gray-200 text-xs">
                            <span class="text-gray-500">QRIS (Online)</span>
                            <span class="font-semibold text-[#001840]">
                                Rp {{ number_format($qrisTotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 text-xs">
                            <span class="text-gray-500">Tunai (Offline)</span>
                            <span class="font-semibold text-[#001840]">
                                Rp {{ number_format($tunaiTotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between py-3 border-t-2 border-[#001840] text-sm font-bold">
                            <span class="text-[#001840]">TOTAL</span>
                            <span class="text-[#102A71]">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>
                </div>

                {{-- CATATAN --}}
                <div class="px-6 md:px-10 pb-8">
                    <div class="rounded-lg bg-yellow-50 border-l-4 border-[#F5C400] px-4 py-3">
                        <p class="text-[10px] leading-relaxed text-yellow-800">
                            <strong>Catatan:</strong>
                            Laporan bersumber dari tabel pesanan dan hanya menampilkan
                            pesanan dengan status selesai. Jenis transaksi ditentukan
                            berdasarkan tipe transaksi online atau offline.
                        </p>
                    </div>
                </div>

                {{-- TANDA TANGAN --}}
                <div class="px-6 md:px-10 pb-10">
                    <div class="flex justify-end">
                        <div class="w-56 text-center">
                            <p class="text-xs text-gray-500">
                                Pangkalpinang, {{ now()->translatedFormat('d F Y') }}
                            </p>
                            <div class="h-16"></div>
                            <div class="border-t border-gray-400 pt-2">
                                <p class="text-xs font-bold text-[#001840]">
                                    Administrator
                                </p>
                                <p class="text-[10px] text-gray-500 mt-1">
                                    UBB Nextmart
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
