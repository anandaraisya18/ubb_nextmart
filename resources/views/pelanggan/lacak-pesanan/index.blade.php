@extends('pelanggan.layouts.app')

@section('title', 'Lacak Pesanan - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-slate-50">


    {{-- =====================================================
         HERO / TRACKING SECTION
    ====================================================== --}}

    <section
        class="
            relative
            overflow-hidden
            bg-[#001840]
            text-white
        "
    >

        {{-- Decorative Glow --}}

        <div
            class="
                absolute
                -top-32
                -right-32
                w-80 h-80
                rounded-full
                bg-[#102A71]
                blur-3xl
                opacity-60
            "
        ></div>

        <div
            class="
                absolute
                -bottom-40
                -left-32
                w-96 h-96
                rounded-full
                bg-[#F5C400]/10
                blur-3xl
            "
        ></div>


        <div
            class="
                relative
                max-w-4xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
                py-16
                sm:py-20
            "
        >

            {{-- Back --}}

            <a
                href="{{ route('pelanggan.dashboard') }}"
                class="
                    inline-flex
                    items-center
                    gap-2
                    text-sm
                    text-white/60
                    hover:text-white
                    transition
                    mb-10
                "
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    
                </svg>

            </a>


            {{-- Heading --}}

            <div class="text-center">

                {{-- Icon --}}

                <div
                    class="
                        mx-auto
                        w-16 h-16
                        rounded-2xl
                        bg-white/10
                        border border-white/10
                        flex items-center justify-center
                        shadow-xl
                    "
                >

                    <svg
                        class="w-8 h-8 text-[#F5C400]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        viewBox="0 0 24 24"
                    >

                        <path
                            d="M3 7h13v10H3z"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M16 10h3l2 3v4h-5z"
                            stroke-linejoin="round"
                        />

                        <circle
                            cx="7"
                            cy="19"
                            r="1.5"
                        />

                        <circle
                            cx="18"
                            cy="19"
                            r="1.5"
                        />

                        <path
                            d="M16 13h5"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>


                <p
                    class="
                        text-[11px]
                        text-[#F5C400]
                        font-semibold
                        uppercase
                        tracking-[0.18em]
                        mt-6
                    "
                >
                    UBB Nextmart
                </p>


                <h1
                    class="
                        text-3xl
                        sm:text-4xl
                        font-bold
                        tracking-tight
                        mt-2
                    "
                >
                    Lacak Pesanan
                </h1>


                <p
                    class="
                        max-w-xl
                        mx-auto
                        text-sm
                        sm:text-base
                        text-white/55
                        mt-3
                        mb-3
                        leading-relaxed
                    "
                >
                    Masukkan nomor resi pesananmu untuk melihat
                    status dan perkembangan pesanan secara real-time.
                </p>

            </div>


            {{-- =================================================
                 TRACKING CARD
            ================================================== --}}

            <div
                class="
                    max-w-2xl
                    mx-auto
                    mt-10
                "
            >

                <div
                    class="
                        bg-white
                        rounded-2xl
                        shadow-2xl
                        shadow-black/20
                        border border-white/10
                        overflow-hidden
                    "
                >

                    {{-- Card Header --}}

                    <div
                        class="
                            px-6
                            sm:px-8
                            py-5
                            border-b
                            border-slate-100
                            bg-slate-50/80
                        "
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="
                                    w-9 h-9
                                    rounded-lg
                                    bg-[#102A71]
                                    text-[#F5C400]
                                    flex
                                    items-center
                                    justify-center
                                "
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >

                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="6"
                                    />

                                    <path
                                        d="m16 16 4 4"
                                        stroke-linecap="round"
                                    />

                                </svg>

                            </div>


                            <div>

                                <h2
                                    class="
                                        text-sm
                                        font-bold
                                        text-[#001840]
                                    "
                                >
                                    Nomor Resi
                                </h2>

                                <p
                                    class="
                                        text-xs
                                        text-gray-500
                                        mt-0.5
                                    "
                                >
                                    Gunakan nomor resi dari pesananmu.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Form --}}

                    <form
                        action="{{ route('pelanggan.pesanan.lacak') }}"
                        method="GET"
                        class="p-6 sm:p-8"
                    >

                        <label
                            for="resi"
                            class="
                                block
                                text-xs
                                font-semibold
                                text-[#001840]
                                mb-2
                            "
                        >
                            Masukkan Nomor Resi
                        </label>


                        <div
                            class="
                                relative
                                flex
                                items-center
                            "
                        >

                            {{-- Search Icon --}}

                            <div
                                class="
                                    absolute
                                    left-4
                                    text-gray-400
                                    pointer-events-none
                                "
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        d="M4 7h16"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M6 7v13h12V7"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="M9 7V5a3 3 0 0 1 6 0v2"
                                        stroke-linecap="round"
                                    />

                                </svg>

                            </div>


                            <input
                                id="resi"
                                type="text"
                                name="resi"
                                value="{{ request('resi') }}"
                                placeholder="Contoh: UBB-20261006-001"
                                autocomplete="off"
                                required
                                class="
                                    w-full
                                    h-12
                                    pl-12
                                    pr-4
                                    rounded-xl
                                    border
                                    border-slate-200
                                    bg-white
                                    text-sm
                                    text-[#001840]
                                    placeholder:text-gray-400
                                    outline-none
                                    transition
                                    focus:border-[#102A71]
                                    focus:ring-4
                                    focus:ring-[#102A71]/10
                                "
                            >

                        </div>


                        {{-- Example --}}

                        <div
                            class="
                                flex
                                items-start
                                gap-2
                                mt-3
                                text-[11px]
                                text-gray-500
                            "
                        >

                            <svg
                                class="
                                    w-3.5
                                    h-3.5
                                    mt-0.5
                                    shrink-0
                                    text-[#102A71]
                                "
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    d="M12 11v5"
                                    stroke-linecap="round"
                                />

                                <circle
                                    cx="12"
                                    cy="8"
                                    r=".5"
                                    fill="currentColor"
                                />

                            </svg>

                            <span>
                                Contoh nomor resi:
                                <span
                                    class="
                                        font-semibold
                                        text-[#001840]
                                    "
                                >
                                    UBB-20261006-001
                                </span>
                            </span>

                        </div>


                        {{-- Submit --}}

                        <button
                            type="submit"
                            class="
                                w-full
                                mt-6
                                h-12
                                rounded-xl
                                bg-[#F5C400]
                                text-[#001840]
                                font-bold
                                text-sm
                                border
                                border-[#F5C400]
                                flex
                                items-center
                                justify-center
                                gap-2
                                transition-all
                                duration-200
                                hover:bg-[#102A71]
                                hover:text-[#F5C400]
                                hover:border-[#102A71]
                                active:scale-[0.98]
                            "
                        >

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >

                                <circle
                                    cx="11"
                                    cy="11"
                                    r="6"
                                />

                                <path
                                    d="m16 16 4 4"
                                    stroke-linecap="round"
                                />

                            </svg>

                            Lacak Pesanan

                        </button>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 INFORMATION
            ================================================== --}}

            <div
                class="
                    max-w-2xl
                    mx-auto
                    mt-8
                    grid
                    grid-cols-1
                    sm:grid-cols-3
                    gap-3
                "
            >

                {{-- STEP 1 --}}

                <div
                    class="
                        rounded-xl
                        bg-white/5
                        border border-white/10
                        p-4
                    "
                >

                    <div
                        class="
                            w-8 h-8
                            rounded-lg
                            bg-[#102A71]
                            text-[#F5C400]
                            flex items-center justify-center
                            text-xs
                            font-bold
                        "
                    >
                        01
                    </div>

                    <p
                        class="
                            text-xs
                            font-semibold
                            text-white
                            mt-3
                        "
                    >
                        Siapkan Resi
                    </p>

                    <p
                        class="
                            text-[11px]
                            text-white/45
                            mt-1
                            leading-relaxed
                        "
                    >
                        Gunakan nomor resi dari pesananmu.
                    </p>

                </div>


                {{-- STEP 2 --}}

                <div
                    class="
                        rounded-xl
                        bg-white/5
                        border border-white/10
                        p-4
                    "
                >

                    <div
                        class="
                            w-8 h-8
                            rounded-lg
                            bg-[#102A71]
                            text-[#F5C400]
                            flex items-center justify-center
                            text-xs
                            font-bold
                        "
                    >
                        02
                    </div>

                    <p
                        class="
                            text-xs
                            font-semibold
                            text-white
                            mt-3
                        "
                    >
                        Masukkan Resi
                    </p>

                    <p
                        class="
                            text-[11px]
                            text-white/45
                            mt-1
                            leading-relaxed
                        "
                    >
                        Masukkan nomor resi pada kolom di atas.
                    </p>

                </div>


                {{-- STEP 3 --}}

                <div
                    class="
                        rounded-xl
                        bg-white/5
                        border border-white/10
                        p-4
                    "
                >

                    <div
                        class="
                            w-8 h-8
                            rounded-lg
                            bg-[#102A71]
                            text-[#F5C400]
                            flex items-center justify-center
                            text-xs
                            font-bold
                        "
                    >
                        03
                    </div>

                    <p
                        class="
                            text-xs
                            font-semibold
                            text-white
                            mt-3
                        "
                    >
                        Lihat Status
                    </p>

                    <p
                        class="
                            text-[11px]
                            text-white/45
                            mt-1
                            leading-relaxed
                        "
                    >
                        Pantau perkembangan pesananmu.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FOOTER INFORMATION
    ====================================================== --}}

    <section class="bg-white">

        <div
            class="
                max-w-4xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
                py-10
            "
        >

            <div
                class="
                    flex
                    flex-col
                    sm:flex-row
                    items-start
                    sm:items-center
                    justify-between
                    gap-5
                "
            >

                <div>

                    <p
                        class="
                            text-sm
                            font-bold
                            text-[#001840]
                        "
                    >
                        Tidak menemukan nomor resi?
                    </p>

                    <p
                        class="
                            text-xs
                            text-gray-500
                            mt-1
                        "
                    >
                        Silakan periksa kembali informasi pesanan
                        atau hubungi pengelola toko.
                    </p>

                </div>


                <a
                    href="{{ route('pelanggan.kontak') }}"
                    class="
                        shrink-0
                        inline-flex
                        items-center
                        gap-2
                        px-4
                        py-2.5
                        rounded-xl
                        border
                        border-slate-200
                        text-xs
                        font-semibold
                        text-[#001840]
                        hover:bg-slate-50
                        hover:border-[#102A71]/30
                        transition
                    "
                >

                    Hubungi Kami

                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >

                        <path
                            d="M5 12h14"
                            stroke-linecap="round"
                        />

                        <path
                            d="M13 6l6 6-6 6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </a>

            </div>

        </div>

    </section>

</div>

@endsection
