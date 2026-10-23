@extends('pelanggan.layouts.app')

@section('title', 'Pesanan Saya - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-[#001840] text-white">

        <div class="max-w-6xl mx-auto px-5 md:px-8 py-8">

            {{-- Tombol Kembali --}}
            <a
                href="{{ route('pelanggan.dashboard') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    text-sm
                    text-white/70
                    hover:text-[#F5C400]
                    transition
                    mb-5
                "
            >
                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Kembali ke Beranda
            </a>

            <p class="text-[#F5C400] text-sm font-semibold">
                UBB NEXTMART
            </p>

            <h1 class="text-2xl md:text-3xl font-bold mt-1">
                Pesanan Saya
            </h1>

            <p class="text-white/60 text-sm mt-2">
                Pantau status pesanan dan lihat detail transaksi kamu.
            </p>

        </div>

    </div>


    <div class="max-w-6xl mx-auto px-5 md:px-8 py-8">

        {{-- Tracking --}}
        <div class="
            bg-white
            rounded-2xl
            border border-gray-200
            p-5 md:p-6
            shadow-sm
            mb-6
        ">

            <div class="
                flex
                flex-col
                md:flex-row
                md:items-center
                md:justify-between
                gap-4
            ">

                <div>

                    <p class="text-xs text-gray-400">
                        Lacak Pesanan
                    </p>

                    <h2 class="font-bold text-[#001840] mt-1">
                        Masukkan Nomor Pesanan
                    </h2>

                </div>


                <div class="flex w-full md:w-auto gap-2">

                    <input
                        type="text"
                        placeholder="Contoh: UBB-2026-001"
                        class="
                            flex-1
                            md:w-72
                            px-4 py-3
                            rounded-xl
                            border border-gray-200
                            bg-gray-50
                            text-sm
                            outline-none
                            focus:border-[#F5C400]
                        "
                    >

                    <button
                        type="button"
                        class="
                            px-5
                            py-3
                            rounded-xl
                            bg-[#001840]
                            text-white
                            text-sm
                            font-semibold
                            hover:bg-[#102A71]
                            transition
                        "
                    >
                        Lacak
                    </button>

                </div>

            </div>

        </div>


        {{-- Pesanan --}}
        <div class="space-y-5">

            {{-- Pesanan 1 --}}
            <div class="
                bg-white
                rounded-2xl
                border border-gray-200
                shadow-sm
                overflow-hidden
            ">

                <div class="
                    px-5 py-4
                    border-b border-gray-100
                    flex
                    flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-3
                ">

                    <div>

                        <p class="text-xs text-gray-400">
                            Nomor Pesanan
                        </p>

                        <p class="
                            font-bold
                            text-[#001840]
                            text-sm
                            mt-1
                        ">
                            UBB-2026-001
                        </p>

                    </div>


                    <span class="
                        inline-flex
                        w-fit
                        items-center
                        gap-2
                        px-3 py-1.5
                        rounded-full
                        bg-yellow-50
                        text-yellow-700
                        text-xs
                        font-semibold
                    ">

                        <span class="
                            w-1.5 h-1.5
                            rounded-full
                            bg-yellow-500
                        "></span>

                        Menunggu Verifikasi

                    </span>

                </div>


                <div class="p-5">

                    <div class="flex gap-4">

                        <div class="
                            w-16 h-16
                            rounded-xl
                            bg-gray-100
                            flex
                            items-center
                            justify-center
                            shrink-0
                        ">

                            <svg
                                class="w-7 h-7 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="16"
                                    rx="2"
                                />

                                <path d="M7 8h10"/>
                                <path d="M7 12h6"/>

                            </svg>

                        </div>


                        <div class="flex-1 min-w-0">

                            <h3 class="
                                font-semibold
                                text-[#001840]
                                text-sm
                            ">
                                Produk Contoh
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                UBB Mart · 1 item
                            </p>

                            <p class="
                                text-[#102A71]
                                font-bold
                                text-sm
                                mt-2
                            ">
                                Rp30.000
                            </p>

                        </div>

                    </div>


                    {{-- Progress --}}
                    <div class="mt-7">

                        <div class="
                            flex
                            items-center
                            justify-between
                            text-[11px]
                            text-gray-400
                            mb-3
                        ">

                            <span class="text-[#102A71] font-semibold">
                                Pesanan Dibuat
                            </span>

                            <span class="text-[#102A71] font-semibold">
                                Pembayaran
                            </span>

                            <span>
                                Diproses
                            </span>

                            <span>
                                Selesai
                            </span>

                        </div>


                        <div class="
                            relative
                            h-2
                            rounded-full
                            bg-gray-100
                            overflow-hidden
                        ">

                            <div
                                class="
                                    absolute
                                    left-0
                                    top-0
                                    h-full
                                    w-1/2
                                    bg-[#F5C400]
                                    rounded-full
                                "
                            ></div>

                        </div>

                    </div>


                    {{-- Tombol --}}
                    <div class="
                        mt-5
                        flex
                        flex-col
                        sm:flex-row
                        gap-3
                    ">

                        <a
                            href="{{ route('pelanggan.pesanan.show', 1) }}"
                            class="
                                flex-1
                                text-center
                                py-3
                                rounded-xl
                                bg-[#001840]
                                text-white
                                text-sm
                                font-semibold
                                hover:bg-[#102A71]
                                transition
                            "
                        >
                            Lihat Detail Pesanan
                        </a>


                        <a
                            href="{{ route('pelanggan.pesanan.resi', 1) }}"
                            class="
                                flex-1
                                text-center
                                py-3
                                rounded-xl
                                border
                                border-[#102A71]
                                text-[#102A71]
                                text-sm
                                font-semibold
                                hover:bg-[#102A71]
                                hover:text-white
                                transition
                            "
                        >
                            Lihat Resi Digital
                        </a>

                    </div>

                </div>

            </div>


            {{-- Pesanan 2 --}}
            <div class="
                bg-white
                rounded-2xl
                border border-gray-200
                shadow-sm
                overflow-hidden
            ">

                <div class="
                    px-5 py-4
                    flex
                    flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-3
                ">

                    <div>

                        <p class="text-xs text-gray-400">
                            Nomor Pesanan
                        </p>

                        <p class="
                            font-bold
                            text-[#001840]
                            text-sm
                            mt-1
                        ">
                            UBB-2026-002
                        </p>

                    </div>


                    <span class="
                        inline-flex
                        w-fit
                        items-center
                        gap-2
                        px-3 py-1.5
                        rounded-full
                        bg-green-50
                        text-green-700
                        text-xs
                        font-semibold
                    ">

                        <span class="
                            w-1.5 h-1.5
                            rounded-full
                            bg-green-500
                        "></span>

                        Selesai

                    </span>

                </div>


                <div class="px-5 pb-5">

                    <div class="
                        p-4
                        rounded-xl
                        bg-gray-50
                    ">

                        <div class="
                            flex
                            items-center
                            justify-between
                            gap-4
                        ">

                            <div>

                                <p class="
                                    font-semibold
                                    text-[#001840]
                                    text-sm
                                ">
                                    Pesanan telah selesai
                                </p>

                                <p class="
                                    text-xs
                                    text-gray-500
                                    mt-1
                                ">
                                    Transaksi berhasil diproses.
                                </p>

                            </div>


                            <a
                                href="{{ route('pelanggan.pesanan.show', 2) }}"
                                class="
                                    text-xs
                                    font-semibold
                                    text-[#102A71]
                                    hover:text-[#F5C400]
                                "
                            >
                                Detail →
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection