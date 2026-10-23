@extends('superadmin.layouts.app')

@section('title', 'Kelola Toko')

@section('content')

<div class="w-full min-w-0">

<div class="space-y-7">

    {{-- =================================================
         HEADER
    ================================================== --}}

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div class="min-w-0">

            {{-- BREADCRUMB --}}
            <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">

                <span>
                    Manajemen Toko
                </span>

                <span>
                    ›
                </span>

                <span class="font-medium text-[#102A71]">
                    Kelola Toko
                </span>

            </div>

            {{-- TITLE --}}
            <h1 class="text-[21px] font-bold text-[#001840]">
                Kelola Toko
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi toko yang terdaftar dalam sistem.
            </p>

        </div>


        {{-- TAMBAH TOKO --}}
        <a
            href="{{ route('superadmin.toko.create') }}"
            class="
                inline-flex
                shrink-0
                items-center
                justify-center
                gap-2
                rounded-lg
                bg-[#F5C400]
                px-5
                py-3
                text-sm
                font-semibold
                text-[#001840]
                shadow-sm
                transition
                duration-200
                hover:bg-[#e6b900]
            "
        >

            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>

            Tambah Toko

        </a>

    </div>


    {{-- =================================================
         SUCCESS MESSAGE
    ================================================== --}}

    @if(session('success'))

        <div
            class="
                flex
                items-center
                gap-3
                rounded-xl
                border
                border-green-200
                bg-green-50
                px-5
                py-4
                text-sm
                text-green-700
            "
        >

            <svg
                class="h-5 w-5 shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path d="M20 6L9 17l-5-5"/>
            </svg>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =================================================
         VALIDATION ERROR
    ================================================== --}}

    @if($errors->any())

        <div
            class="
                rounded-xl
                border
                border-red-200
                bg-red-50
                px-5
                py-4
                text-sm
                text-red-600
            "
        >

            <p class="font-semibold">
                Terjadi kesalahan:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =================================================
         STATISTICS
    ================================================== --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">


        {{-- TOTAL TOKO --}}

        <div
            class="
                rounded-[13px]
                border
                border-[#E2E8F0]
                bg-white
                p-5
            "
        >

            <div class="flex items-center gap-4">

                <div
                    class="
                        flex
                        h-[47px]
                        w-[47px]
                        shrink-0
                        items-center
                        justify-center
                        rounded-[11px]
                        bg-[#EEF2FF]
                        text-[#102A71]
                    "
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M3 9l2-5h14l2 5"/>
                        <path d="M5 9v11h14V9"/>
                        <path d="M9 20v-6h6v6"/>
                        <path d="M3 9h18"/>
                    </svg>

                </div>


                <div class="min-w-0">

                    <p class="text-xs text-[#64748B]">
                        Total Toko
                    </p>

                    <p class="mt-1 text-[23px] font-bold text-[#001840]">
                        {{ $stores->count() }}
                    </p>

                </div>

            </div>

        </div>


        {{-- TOKO INSTAGRAM --}}

        <div
            class="
                rounded-[13px]
                border
                border-[#E2E8F0]
                bg-white
                p-5
            "
        >

            <div class="flex items-center gap-4">

                <div
                    class="
                        flex
                        h-[47px]
                        w-[47px]
                        shrink-0
                        items-center
                        justify-center
                        rounded-[11px]
                        bg-pink-50
                        text-pink-600
                    "
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <rect
                            x="3"
                            y="3"
                            width="18"
                            height="18"
                            rx="5"
                            ry="5"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="4"
                        />

                        <circle
                            cx="17.5"
                            cy="6.5"
                            r="1"
                        />
                    </svg>

                </div>


                <div class="min-w-0">

                    <p class="text-xs text-[#64748B]">
                        Terhubung Instagram
                    </p>

                    <p class="mt-1 text-[23px] font-bold text-[#001840]">
                        {{ $stores->whereNotNull('link_instagram')->where('link_instagram', '!=', '')->count() }}
                    </p>

                </div>

            </div>

        </div>


        {{-- TOKO TIKTOK --}}

        <div
            class="
                rounded-[13px]
                border
                border-[#E2E8F0]
                bg-white
                p-5
            "
        >

            <div class="flex items-center gap-4">

                <div
                    class="
                        flex
                        h-[47px]
                        w-[47px]
                        shrink-0
                        items-center
                        justify-center
                        rounded-[11px]
                        bg-gray-100
                        text-[#001840]
                    "
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M15 4v10.5a4.5 4.5 0 1 1-4.5-4.5"
                        />

                        <path
                            d="M15 4c.5 2 1.7 3.2 4 3.5"
                        />
                    </svg>

                </div>


                <div class="min-w-0">

                    <p class="text-xs text-[#64748B]">
                        Terhubung TikTok
                    </p>

                    <p class="mt-1 text-[23px] font-bold text-[#001840]">
                        {{ $stores->whereNotNull('link_tiktok')->where('link_tiktok', '!=', '')->count() }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =================================================
         TABLE
    ================================================== --}}

    <div
        class="
            w-full
            min-w-0
            overflow-hidden
            rounded-[13px]
            border
            border-[#E2E8F0]
            bg-white
        "
    >

        {{-- TABLE HEADER --}}

        <div
            class="
                flex
                flex-col
                gap-4
                border-b
                border-[#E2E8F0]
                p-5
                md:flex-row
                md:items-center
                md:justify-between
            "
        >

            <div class="min-w-0">

                <h2 class="text-[16px] font-semibold text-[#001840]">
                    Daftar Toko
                </h2>

                <p class="mt-1 text-xs text-[#64748B]">
                    Daftar seluruh toko yang terdaftar dalam sistem.
                </p>

            </div>


            {{-- SEARCH --}}

            <form
                method="GET"
                action="{{ route('superadmin.toko.index') }}"
                class="relative w-full shrink-0 md:w-72"
            >

                <svg
                    class="
                        absolute
                        left-3
                        top-1/2
                        h-4
                        w-4
                        -translate-y-1/2
                        text-gray-400
                    "
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>


                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari toko..."
                    class="
                        w-full
                        rounded-lg
                        border
                        border-[#E2E8F0]
                        bg-white
                        py-2.5
                        pl-10
                        pr-4
                        text-sm
                        text-[#1E293B]
                        outline-none
                        transition
                        placeholder:text-gray-400
                        focus:border-[#102A71]
                        focus:ring-2
                        focus:ring-[#102A71]/10
                    "
                >

            </form>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="w-full overflow-x-auto">

            <table class="w-full min-w-[950px] text-left">

                {{-- TABLE HEAD --}}

                <thead class="bg-[#001840]">

                    <tr class="text-[11px] uppercase tracking-wider text-white">

                        <th class="px-6 py-4 font-semibold">
                            Toko
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Deskripsi
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Lokasi
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Kontak
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Sosial Media
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- TABLE BODY --}}

                <tbody class="divide-y divide-[#E2E8F0]">

                    @forelse ($stores as $store)

                        <tr class="transition duration-150 hover:bg-[#F5F7FC]">


                            {{-- =========================
                                 TOKO
                            ========================== --}}

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="
                                            flex
                                            h-10
                                            w-10
                                            shrink-0
                                            items-center
                                            justify-center
                                            rounded-xl
                                            bg-[#102A71]
                                            text-[#F5C400]
                                        "
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M3 9l2-5h14l2 5"/>
                                            <path d="M5 9v11h14V9"/>
                                            <path d="M9 20v-6h6v6"/>
                                            <path d="M3 9h18"/>
                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p
                                            class="
                                                max-w-[220px]
                                                truncate
                                                text-sm
                                                font-semibold
                                                text-[#001840]
                                            "
                                        >
                                            {{ $store->nama_toko }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-gray-400">
                                            ID #{{ $store->id_toko }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- =========================
                                 DESKRIPSI
                            ========================== --}}

                            <td class="px-6 py-4">

                                <p
                                    class="
                                        max-w-[250px]
                                        truncate
                                        text-sm
                                        text-[#475569]
                                    "
                                    title="{{ $store->deskripsi }}"
                                >
                                    {{ $store->deskripsi ?: 'Belum ada deskripsi' }}
                                </p>

                            </td>


                            {{-- =========================
                                 LOKASI
                            ========================== --}}

                            <td class="px-6 py-4">

                                <div class="flex items-start gap-2">

                                    <svg
                                        class="mt-0.5 h-4 w-4 shrink-0 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="10"
                                            r="2.5"
                                        />
                                    </svg>


                                    <span
                                        class="
                                            max-w-[220px]
                                            text-sm
                                            leading-relaxed
                                            text-[#475569]
                                        "
                                    >
                                        {{ $store->alamat ?: 'Alamat belum diatur' }}
                                    </span>

                                </div>

                            </td>


                            {{-- =========================
                                 KONTAK
                            ========================== --}}

                            <td class="px-6 py-4">

                                @if($store->nomor_telepon)

                                    <div class="flex items-center gap-2">

                                        <svg
                                            class="h-4 w-4 shrink-0 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2
                                                   19.79 19.79 0 0 1-8.63-3.07
                                                   19.5 19.5 0 0 1-6-6
                                                   19.79 19.79 0 0 1-3.07-8.67
                                                   A2 2 0 0 1 4.11 2h3a2 2 0 0 1
                                                   2 1.72c.12.9.33 1.78.62 2.63
                                                   a2 2 0 0 1-.45 2.11L8 9.73
                                                   a16 16 0 0 0 6 6l1.27-1.27
                                                   a2 2 0 0 1 2.11-.45
                                                   c.85.29 1.73.5 2.63.62
                                                   A2 2 0 0 1 22 16.92z"
                                            />
                                        </svg>

                                        <span class="text-sm text-[#475569]">
                                            {{ $store->nomor_telepon }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-xs text-gray-400">
                                        Belum diatur
                                    </span>

                                @endif

                            </td>


                            {{-- =========================
                                 SOCIAL MEDIA
                            ========================== --}}

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-2">

                                    @if($store->link_instagram)

                                        <a
                                            href="{{ $store->link_instagram }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Instagram"
                                            class="
                                                flex
                                                h-8
                                                w-8
                                                items-center
                                                justify-center
                                                rounded-lg
                                                bg-pink-50
                                                text-pink-600
                                                transition
                                                hover:bg-pink-100
                                            "
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                viewBox="0 0 24 24"
                                            >
                                                <rect
                                                    x="3"
                                                    y="3"
                                                    width="18"
                                                    height="18"
                                                    rx="5"
                                                    ry="5"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="4"
                                                />

                                                <circle
                                                    cx="17.5"
                                                    cy="6.5"
                                                    r="1"
                                                />
                                            </svg>

                                        </a>

                                    @endif


                                    @if($store->link_tiktok)

                                        <a
                                            href="{{ $store->link_tiktok }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="TikTok"
                                            class="
                                                flex
                                                h-8
                                                w-8
                                                items-center
                                                justify-center
                                                rounded-lg
                                                bg-gray-100
                                                text-[#001840]
                                                transition
                                                hover:bg-gray-200
                                            "
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M15 4v10.5a4.5 4.5 0 1 1-4.5-4.5"
                                                />

                                                <path
                                                    d="M15 4c.5 2 1.7 3.2 4 3.5"
                                                />
                                            </svg>

                                        </a>

                                    @endif


                                    @if(!$store->link_instagram && !$store->link_tiktok)

                                        <span class="text-xs text-gray-400">
                                            Belum ada
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- =========================
                                 AKSI
                            ========================== --}}

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('superadmin.toko.edit', $store->id_toko) }}"
                                        title="Edit"
                                        class="
                                            flex
                                            h-9
                                            w-9
                                            shrink-0
                                            items-center
                                            justify-center
                                            rounded-lg
                                            bg-yellow-50
                                            text-yellow-600
                                            transition
                                            hover:bg-[#F5C400]
                                            hover:text-[#001840]
                                        "
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M12 20h9"/>

                                            <path
                                                d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"
                                            />
                                        </svg>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        method="POST"
                                        action="{{ route('superadmin.toko.destroy', $store->id_toko) }}"
                                        onsubmit="return confirm('Hapus toko {{ addslashes($store->nama_toko) }}?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus"
                                            class="
                                                flex
                                                h-9
                                                w-9
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-lg
                                                bg-red-50
                                                text-red-500
                                                transition
                                                hover:bg-red-500
                                                hover:text-white
                                            "
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4h8v2"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v5"/>
                                                <path d="M14 11v5"/>
                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- =================================================
                             EMPTY STATE
                        ================================================== --}}

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div
                                    class="
                                        mx-auto
                                        flex
                                        h-14
                                        w-14
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-[#EEF2FF]
                                        text-[#102A71]
                                    "
                                >

                                    <svg
                                        class="h-7 w-7"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M3 9l2-5h14l2 5"/>
                                        <path d="M5 9v11h14V9"/>
                                        <path d="M9 20v-6h6v6"/>
                                        <path d="M3 9h18"/>
                                    </svg>

                                </div>


                                <p
                                    class="
                                        mt-4
                                        text-sm
                                        font-semibold
                                        text-[#001840]
                                    "
                                >
                                    Belum ada toko
                                </p>


                                <p class="mt-1 text-xs text-[#64748B]">
                                    Tambahkan toko untuk mulai mengelola operasional.
                                </p>


                                <a
                                    href="{{ route('superadmin.toko.create') }}"
                                    class="
                                        mt-4
                                        inline-flex
                                        items-center
                                        gap-2
                                        rounded-lg
                                        bg-[#F5C400]
                                        px-4
                                        py-2
                                        text-xs
                                        font-semibold
                                        text-[#001840]
                                        transition
                                        hover:bg-[#e6b900]
                                    "
                                >

                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M12 5v14"/>
                                        <path d="M5 12h14"/>
                                    </svg>

                                    Tambah Toko

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection
