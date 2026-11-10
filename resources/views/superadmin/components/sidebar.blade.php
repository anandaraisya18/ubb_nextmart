{{-- resources/views/superadmin/components/sidebar.blade.php --}}

@php
    // Ambil data Superadmin yang sedang login
    $superadmin = auth('superadmin')->user();

    // Ambil nama sesuai akun Superadmin
    $superadminName = $superadmin?->name ?? 'Superadmin';

    // Ambil inisial nama untuk avatar
    $superadminInitial = mb_strtoupper(
        mb_substr($superadminName, 0, 1)
    );
@endphp

<aside
    id="sidebar"
    class="
        fixed
        inset-y-0 left-0
        z-50
        w-64
        bg-[#001840]
        border-r border-white/10
        text-white
        transform
        -translate-x-full
        lg:translate-x-0
        transition-transform duration-300
        flex flex-col
    "
>

    {{-- Logo --}}
    <div class="h-20 flex items-center px-6 border-b border-white/10 shrink-0">

        <div class="
            w-10 h-10
            rounded-xl
            bg-[#102A71]
            border border-[#F5C400]/30
            flex items-center justify-center
        ">
            <img
                src="{{ asset('images/logoubb.png') }}"
                alt="UBB Nextmart"
                class="w-7 h-7 object-contain"
            >
        </div>

        <div class="ml-3">
            <h1 class="font-bold text-sm">
                UBB Nextmart
            </h1>

            <p class="text-[10px] text-[#F5C400] uppercase tracking-wider">
                Superadmin
            </p>
        </div>

    </div>


    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 overflow-y-auto">

        {{-- Main Menu --}}
        <p class="
            px-3 mb-3
            text-[10px]
            font-semibold
            uppercase
            tracking-[0.15em]
            text-white/40
        ">
            Main Menu
        </p>


        {{-- Dashboard --}}
        <a
            href="{{ route('superadmin.dashboard') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('superadmin.dashboard')
                    ? 'bg-[#102A71] text-[#F5C400]'
                    : 'text-white/70 hover:bg-[#102A71]/70 hover:text-white'
                }}
            "
        >

            <svg
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>

            <span>Dashboard</span>

        </a>


        {{-- Manajemen --}}
        <p class="
            px-3
            mt-7 mb-3
            text-[10px]
            font-semibold
            uppercase
            tracking-[0.15em]
            text-white/40
        ">
            Manajemen
        </p>


        {{-- Kelola Akun Admin --}}
        <a
            href="{{ route('superadmin.admin.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('superadmin.admin.*')
                    ? 'bg-[#102A71] text-[#F5C400]'
                    : 'text-white/70 hover:bg-[#102A71]/70 hover:text-white'
                }}
            "
        >

            <svg
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <path
                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                />

                <circle
                    cx="9"
                    cy="7"
                    r="4"
                />

                <path
                    d="M22 21v-2a4 4 0 0 0-3-3.87"
                />

                <path
                    d="M16 3.13a4 4 0 0 1 0 7.75"
                />
            </svg>

            <span>Kelola Akun Admin</span>

        </a>


        {{-- Kelola Toko --}}
        <a
            href="{{ route('superadmin.toko.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('superadmin.toko.*')
                    ? 'bg-[#102A71] text-[#F5C400]'
                    : 'text-white/70 hover:bg-[#102A71]/70 hover:text-white'
                }}
            "
        >

            <svg
                class="w-5 h-5 shrink-0"
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

            <span>Kelola Toko</span>

        </a>


        {{-- Group Operasional --}}
        <a
            href="{{ route('superadmin.group.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('superadmin.group.*')
                    ? 'bg-[#102A71] text-[#F5C400]'
                    : 'text-white/70 hover:bg-[#102A71]/70 hover:text-white'
                }}
            "
        >

            <svg
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <path
                    d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"
                />

                <circle
                    cx="9"
                    cy="7"
                    r="4"
                />

                <path
                    d="M23 21v-2a4 4 0 0 0-3-3.87"
                />

                <path
                    d="M16 3.13a4 4 0 0 1 0 7.75"
                />
            </svg>

            <span>Group Operasional</span>

        </a>


        {{-- Audit Log --}}
        <a
            href="{{ route('superadmin.audit.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                text-sm
                transition

                {{ request()->routeIs('superadmin.audit.*')
                    ? 'bg-[#102A71] text-[#F5C400]'
                    : 'text-white/70 hover:bg-[#102A71]/70 hover:text-white'
                }}
            "
        >

            <svg
                class="w-5 h-5 shrink-0"
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
                    d="M12 7v5l3 2"
                />
            </svg>

            <span>Audit Log</span>

        </a>

    </nav>


    {{-- User / Logout --}}
    <div class="p-4 border-t border-white/10 shrink-0">

        {{-- Logout --}}
        @if (Route::has('superadmin.logout'))

            <form
                method="POST"
                action="{{ route('superadmin.logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="
                        w-full
                        flex items-center
                        gap-3
                        px-3 py-2.5
                        rounded-xl
                        text-sm
                        text-white/60
                        hover:bg-red-500/10
                        hover:text-red-400
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
                            d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                        />

                        <path
                            d="M16 17l5-5-5-5"
                        />

                        <path
                            d="M21 12H9"
                        />
                    </svg>

                    <span>Keluar</span>

                </button>

            </form>

        @endif

    </div>

</aside>


{{-- Mobile Overlay --}}
<div
    id="sidebarOverlay"
    class="
        fixed inset-0
        bg-black/50
        z-40
        hidden
        lg:hidden
    "
    onclick="toggleSidebar()"
></div>


<script>
    function toggleSidebar() {

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');

        overlay.classList.toggle('hidden');
    }
</script>
