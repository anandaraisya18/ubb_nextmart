{{-- resources/views/superadmin/components/topbar.blade.php --}}

@php
    // Ambil data Superadmin yang sedang login
    $superadmin = auth('superadmin')->user();

    // Ambil nama Superadmin sesuai akun login
    $superadminName = $superadmin?->name ?? 'Superadmin';

    // Ambil huruf pertama nama untuk avatar
    $superadminInitial = mb_strtoupper(
        mb_substr($superadminName, 0, 1)
    );
@endphp

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

        {{-- Divider --}}
        <div class="hidden md:block w-px h-8 bg-gray-200"></div>

        {{-- Profile --}}
        <div class="flex items-center gap-3">

            {{-- Avatar Superadmin Dinamis --}}
            <div
                class="
                    w-9 h-9
                    rounded-full
                    bg-[#102A71]
                    text-[#F5C400]
                    flex items-center justify-center
                    font-bold
                    text-xs
                    shrink-0
                "
            >
                {{ $superadminInitial }}
            </div>

            <div class="hidden md:block min-w-0">

                {{-- Nama Sesuai Akun Superadmin --}}
                <p
                    class="text-sm font-semibold text-[#001840] truncate"
                    title="{{ $superadminName }}"
                >
                    {{ $superadminName }}
                </p>

                {{-- Jabatan Superadmin --}}
                <p class="text-[10px] text-gray-400">
                    Administrator Utama
                </p>

            </div>

        </div>

    </div>

</header>
