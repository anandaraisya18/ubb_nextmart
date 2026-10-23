{{-- resources/views/superadmin/components/topbar.blade.php --}}

<header
    class="
        h-20
        bg-white
        border-b border-gray-200
        flex items-center
        justify-between
        px-5 md:px-8
        sticky top-0
        z-30
    "
>

    {{-- Left --}}
    <div class="flex items-center gap-4">

        {{-- Mobile Menu --}}
        <button
            type="button"
            onclick="toggleSidebar()"
            class="
                lg:hidden
                w-10 h-10
                rounded-xl
                bg-[#001840]
                text-white
                flex items-center justify-center
                hover:bg-[#102A71]
                transition
            "
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    d="M4 6h16M4 12h16M4 18h16"
                    stroke-linecap="round"
                />
            </svg>

        </button>


        {{-- Page Title --}}
        <div>

            <h2 class="text-lg md:text-xl font-bold text-[#001840]">
                {{ $title ?? 'Dashboard' }}
            </h2>

            <p class="hidden md:block text-xs text-gray-500 mt-0.5">
                {{ $subtitle ?? 'Pusat kendali UBB Nextmart' }}
            </p>

        </div>

    </div>


    {{-- Right --}}
    <div class="flex items-center gap-3 md:gap-5">

        {{-- Notification --}}
        <button
            type="button"
            class="
                relative
                w-10 h-10
                rounded-xl
                flex items-center justify-center
                text-gray-500
                hover:bg-gray-100
                transition
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
                    d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                />

                <path
                    d="M13.73 21a2 2 0 0 1-3.46 0"
                />
            </svg>

            <span
                class="
                    absolute
                    top-2 right-2
                    w-2 h-2
                    rounded-full
                    bg-[#F5C400]
                    border-2 border-white
                "
            ></span>

        </button>


        {{-- Divider --}}
        <div class="hidden md:block w-px h-8 bg-gray-200"></div>


        {{-- Profile --}}
        <div class="flex items-center gap-3">

            <div
                class="
                    w-9 h-9
                    rounded-full
                    bg-[#102A71]
                    text-[#F5C400]
                    flex items-center justify-center
                    font-bold
                    text-xs
                "
            >
                SA
            </div>

            <div class="hidden md:block">

                <p class="text-sm font-semibold text-[#001840]">
                    Superadmin
                </p>

                <p class="text-[10px] text-gray-400">
                    Administrator Utama
                </p>

            </div>

        </div>

    </div>

</header>
