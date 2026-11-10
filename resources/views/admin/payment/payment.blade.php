{{-- resources/views/admin/transactions/index.blade.php --}}

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transaksi | UBB Nexmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-[#f4f7fc] text-gray-800">


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    @include('admin.components.sidebar')


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main class="min-h-screen lg:ml-[250px]">


        {{-- =====================================================
             TOPBAR
        ====================================================== --}}

        @include('admin.components.topbar', [
            'title' => 'Transaksi',
            'subtitle' => 'Riwayat transaksi pembayaran yang telah dikonfirmasi'
        ])


        <section class="p-4 sm:p-5 md:p-7 lg:p-8">


            {{-- =================================================
                 BANNER
            ================================================== --}}

            <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#001840] to-[#102A71] p-5 sm:p-6">

                <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full border-[25px] border-[#F5C400]/10"></div>

                <div class="absolute -bottom-16 right-24 h-32 w-32 rounded-full border-[18px] border-white/5"></div>


                <div class="relative z-10">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <div class="mb-2 flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F5C400] text-[#001840]">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >

                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M3 10h18"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M7 15h3"
                                        />

                                    </svg>

                                </div>

                                <span class="text-[10px] font-semibold uppercase tracking-wider text-[#F5C400]">
                                    Transaction Management
                                </span>

                            </div>


                            <h2 class="text-xl font-bold text-white sm:text-2xl">
                                Riwayat Transaksi
                            </h2>


                            <p class="mt-1 max-w-2xl text-xs leading-5 text-white/80">

                                Kelola dan pantau transaksi pembayaran
                                yang telah berhasil dikonfirmasi oleh admin.

                            </p>

                        </div>


                        {{-- EXPORT --}}

                        <a
                            href="{{ route('admin.payment.export') }}"
                            target="_blank"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#F5C400] px-4 py-3 text-xs font-bold text-[#001840] shadow-sm transition hover:bg-yellow-300 sm:w-auto"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v12"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 10l5 5 5-5"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 21h14"
                                />

                            </svg>

                            Export Laporan

                        </a>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 DUMMY DATA
            ================================================== --}}

            


            {{-- =================================================
                 STATISTIK
            ================================================== --}}

            <div class="mb-6 grid grid-cols-2 gap-4 xl:grid-cols-4">


                {{-- TOTAL TRANSAKSI --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">

                    <div class="flex items-center justify-between">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef2fb] text-[#102A71]">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <path
                                    d="M3 10h18"
                                />

                            </svg>

                        </div>

                    </div>


                    <p class="mt-4 text-2xl font-bold text-[#001840]">
                        {{ $totalTransaksi }}
                    </p>

                    <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">
                        Total Transaksi
                    </p>

                </div>



                {{-- BERHASIL --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">

                    <div class="flex items-center justify-between">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12l4 4L19 6"
                                />

                            </svg>

                        </div>

                    </div>


                    <p class="mt-4 text-2xl font-bold text-[#001840]">
                        {{ $transaksiBerhasil }}
                    </p>

                    <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">
                        Transaksi Berhasil
                    </p>

                </div>



                {{-- TOTAL PENDAPATAN --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">

                    <div class="flex items-center justify-between">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff8d6] text-[#806800]">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    d="M12 1v22"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M17 5.5C16.2 4.6 14.7 4 12.8 4C10.1 4 8 5.4 8 7.5C8 9.6 9.7 10.5 12.4 11.2C15.1 11.9 17 12.8 17 15C17 17.2 14.9 19 12 19C9.9 19 8.2 18.3 7 17"
                                />

                            </svg>

                        </div>

                    </div>


                    <p class="mt-4 text-xl font-bold text-[#001840]">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">
                        Total Pendapatan
                    </p>

                </div>



                {{-- RATA-RATA --}}

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">

                    <div class="flex items-center justify-between">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    d="M4 19V9"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M10 19V5"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M16 19v-7"
                                />

                            </svg>

                        </div>

                    </div>


                    <p class="mt-4 text-xl font-bold text-[#001840]">

                        Rp
                        {{ number_format(
                            $totalTransaksi > 0
                                ? $totalPendapatan / $totalTransaksi
                                : 0,
                            0,
                            ',',
                            '.'
                        ) }}

                    </p>

                    <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">
                        Rata-rata Transaksi
                    </p>

                </div>

            </div>



            {{-- =================================================
                RINGKASAN METODE PEMBAYARAN
            ================================================== --}}

            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- QRIS --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff8d6] text-[#806800]">
                                <span class="text-xs font-black">QR</span>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-[#001840]">
                                    QRIS
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400">
                                    Total transaksi melalui QRIS
                                </p>
                            </div>
                        </div>

                        <p class="text-sm font-bold text-[#102A71]">
                            Rp {{ number_format($qrisTotal, 0, ',', '.') }}
                        </p>

                    </div>
                </div>

                {{-- TRANSFER BANK --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef2fb] text-[#102A71]">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="M3 10h18" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-[#001840]">
                                    Transfer Bank
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400">
                                    Total transaksi melalui transfer
                                </p>
                            </div>
                        </div>

                        <p class="text-sm font-bold text-[#102A71]">
                            Rp {{ number_format($transferTotal, 0, ',', '.') }}
                        </p>

                    </div>
                </div>

                {{-- TUNAI --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-700">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect x="3" y="6" width="18" height="12" rx="2" />
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M7 9h.01M17 15h.01" stroke-linecap="round" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-[#001840]">
                                    Tunai
                                </p>
                                <p class="mt-1 text-[10px] text-gray-400">
                                    Total transaksi pembayaran tunai
                                </p>
                            </div>
                        </div>

                        <p class="text-sm font-bold text-green-700">
                            Rp {{ number_format($tunaiTotal, 0, ',', '.') }}
                        </p>

                    </div>
                </div>

            </div>

            



            {{-- =================================================
                 DAFTAR TRANSAKSI
            ================================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">


                {{-- HEADER --}}

                <div class="border-b border-gray-200 p-5">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        <div>

                            <h2 class="text-sm font-bold text-[#001840]">
                                Daftar Transaksi
                            </h2>

                            <p class="mt-1 text-[10px] text-gray-500">
                                Transaksi yang telah berhasil dikonfirmasi admin.
                            </p>

                        </div>


                        {{-- FILTER --}}

                        <div class="flex flex-col gap-2 sm:flex-row">


                            {{-- SEARCH --}}

                            <div class="relative">

                                <svg
                                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="7"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M20 20l-4-4"
                                    />

                                </svg>


                                <input
                                    type="text"
                                    placeholder="Cari transaksi..."
                                    class="h-10 w-full rounded-lg border border-gray-200 bg-gray-50 pl-9 pr-3 text-xs outline-none transition focus:border-[#102A71] focus:bg-white sm:w-52"
                                >

                            </div>


                            {{-- METHOD --}}

                            <select
                                class="h-10 rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs text-gray-600 outline-none focus:border-[#102A71]"
                            >

                                <option value="">
                                    Semua Pembayaran
                                </option>

                                <option value="QRIS">
                                    QRIS
                                </option>

                                <option value="Transfer Bank">
                                    Transfer Bank
                                </option>

                            </select>


                            {{-- DATE --}}

                            <select
                                class="h-10 rounded-lg border border-gray-200 bg-gray-50 px-3 text-xs text-gray-600 outline-none focus:border-[#102A71]"
                            >

                                <option value="">
                                    Semua Periode
                                </option>

                                <option>
                                    Hari Ini
                                </option>

                                <option>
                                    Minggu Ini
                                </option>

                                <option>
                                    Bulan Ini
                                </option>

                            </select>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     DESKTOP TABLE
                ================================================== --}}

                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full min-w-[950px]">


                        <thead>

                            <tr class="border-b border-gray-100 bg-[#fafbfe]">

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Transaksi
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Pesanan
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Pelanggan
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Tanggal
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Pembayaran
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Nominal
                                </th>

                                <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Status
                                </th>

                                <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                    Aksi
                                </th>

                            </tr>

                        </thead>



                        <tbody class="divide-y divide-gray-100">


                            @foreach($transactions as $transaction)

                                <tr class="transition hover:bg-[#fafbfe]">


                                    {{-- TRANSACTION ID --}}

                                    <td class="px-5 py-4">

                                        <p class="text-xs font-bold text-[#001840]">
                                            {{ $transaction->id }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-400">
                                            {{ $transaction->time }} WIB
                                        </p>

                                    </td>


                                    {{-- ORDER ID --}}

                                    <td class="px-5 py-4">

                                        <p class="text-xs font-semibold text-[#102A71]">
                                            {{ $transaction->order_id }}
                                        </p>

                                    </td>


                                    {{-- CUSTOMER --}}

                                    <td class="px-5 py-4">

                                        <p class="text-xs font-semibold text-gray-700">
                                            {{ $transaction->customer }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-400">
                                            {{ $transaction->phone }}
                                        </p>

                                    </td>


                                    {{-- DATE --}}

                                    <td class="px-5 py-4">

                                        <p class="text-xs text-gray-700">
                                            {{ $transaction->date }}
                                        </p>

                                    </td>


                   
                                        {{-- PAYMENT --}}

                                        <td class="px-5 py-4">

                                            @if($transaction->payment === 'QRIS')
                                                <span class="inline-flex rounded-lg bg-yellow-50 px-2.5 py-1 text-[9px] font-semibold text-yellow-700">
                                                    QRIS
                                                </span>
                                            @elseif($transaction->payment === 'Tunai')
                                                <span class="inline-flex rounded-lg bg-green-50 px-2.5 py-1 text-[9px] font-semibold text-green-700">
                                                    Tunai
                                                </span>
                                            @elseif($transaction->payment === 'Transfer Bank')
                                                <span class="inline-flex rounded-lg bg-blue-50 px-2.5 py-1 text-[9px] font-semibold text-blue-700">
                                                    Transfer Bank
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-[9px] font-semibold text-gray-600">
                                                    {{ $transaction->payment }}
                                                </span>
                                            @endif

                                        </td>



                                    {{-- TOTAL --}}

                                    <td class="px-5 py-4">

                                        <p class="text-xs font-bold text-[#102A71]">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </p>

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-5 py-4">

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-[9px] font-semibold text-green-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                            Berhasil

                                        </span>

                                    </td>


                                    {{-- ACTION --}}

                                    <td class="px-5 py-4 text-right">

                                        <a
                                            href="#"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2 text-[10px] font-semibold text-[#102A71] transition hover:border-[#102A71] hover:bg-[#102A71] hover:text-white"
                                        >

                                            <svg
                                                class="h-3.5 w-3.5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                />

                                            </svg>

                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @endforeach


                        </tbody>

                    </table>

                </div>



                {{-- =================================================
                     MOBILE
                ================================================== --}}

                <div class="divide-y divide-gray-100 md:hidden">


                    @foreach($transactions as $transaction)

                        <div class="p-5">


                            {{-- TOP --}}

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <p class="text-sm font-bold text-[#001840]">
                                        {{ $transaction->id }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-gray-400">
                                        {{ $transaction->date }}
                                    </p>

                                </div>


                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-[9px] font-semibold text-green-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                    Berhasil

                                </span>

                            </div>


                            {{-- CUSTOMER --}}

                            <div class="mt-4 rounded-xl bg-[#f8f9fc] p-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eef2fb] text-xs font-bold text-[#102A71]">

                                        {{ strtoupper(substr($transaction->customer, 0, 1)) }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-xs font-bold text-gray-700">
                                            {{ $transaction->customer }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-400">
                                            {{ $transaction->phone }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- DETAILS --}}

                            <div class="mt-4 grid grid-cols-2 gap-4">


                                <div>

                                    <p class="text-[9px] uppercase tracking-wide text-gray-400">
                                        Pesanan
                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-[#102A71]">
                                        {{ $transaction->order_id }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[9px] uppercase tracking-wide text-gray-400">
                                        Pembayaran
                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-gray-700">
                                        {{ $transaction->payment }}
                                    </p>

                                </div>


                                <div class="col-span-2">

                                    <p class="text-[9px] uppercase tracking-wide text-gray-400">
                                        Nominal
                                    </p>

                                    <p class="mt-1 text-base font-bold text-[#102A71]">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </p>

                                </div>

                            </div>


                            {{-- DETAIL BUTTON --}}

                            <a
                                href="#"
                                class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 px-4 py-3 text-[10px] font-semibold text-[#102A71] transition hover:bg-[#102A71] hover:text-white"
                            >

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />

                                </svg>

                                Lihat Detail Transaksi

                            </a>

                        </div>

                    @endforeach


                </div>



                {{-- EMPTY STATE --}}

                @if(count($transactions) === 0)

                    <div class="px-6 py-16 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#eef2fb] text-[#102A71]">

                            <svg
                                class="h-7 w-7"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <path
                                    d="M3 10h18"
                                />

                            </svg>

                        </div>


                        <h3 class="mt-4 text-sm font-bold text-[#001840]">
                            Belum Ada Transaksi
                        </h3>


                        <p class="mx-auto mt-1 max-w-sm text-xs text-gray-500">

                            Transaksi yang telah berhasil dikonfirmasi
                            admin akan muncul di halaman ini.

                        </p>

                    </div>

                @endif


            </div>


        </section>

    </main>


</body>

</html>