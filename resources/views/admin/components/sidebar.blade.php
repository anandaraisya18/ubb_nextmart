{{-- resources/views/admin/components/sidebar.blade.php --}}

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
                Admin Panel
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
            href="{{ route('admin.dashboard') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('admin.dashboard')
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


        {{-- Operasional --}}
        <p class="
            px-3
            mt-7 mb-3
            text-[10px]
            font-semibold
            uppercase
            tracking-[0.15em]
            text-white/40
        ">
            Operasional
        </p>


        {{-- Produk --}}
        <a
            href="{{ route('admin.products.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('admin.products.*')
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
                <path d="M20 7h-9"/>
                <path d="M14 17H4"/>
                <path d="M17 17h3"/>
                <path d="M4 7h3"/>
                <circle cx="9" cy="7" r="2"/>
                <circle cx="12" cy="17" r="2"/>
            </svg>

            <span>Produk</span>

        </a>


        {{-- Kategori --}}
        <a
            href="{{ route('admin.categories.index') }}"
            class="
                flex items-center gap-3
                px-3 py-3
                rounded-xl
                mb-2
                text-sm
                transition

                {{ request()->routeIs('admin.categories.*')
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

            <span>Kategori</span>

        </a>


        {{-- Pesanan --}}
<a
    href="{{ route('admin.orders.index') }}"
    class="
        flex items-center gap-3
        px-3 py-3
        rounded-xl
        mb-2
        text-sm
        transition

        {{ request()->routeIs('admin.orders.*')
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
        <path d="M6 2h12l2 4v16H4V6l2-4z"/>
        <path d="M4 6h16"/>
        <path d="M9 10h6"/>
        <path d="M9 14h6"/>
    </svg>

    <span>Pesanan</span>

</a>

{{-- Transaksi --}}
<a
    href="{{ route('admin.payment.payment') }}"
    class="
        flex items-center gap-3
        px-3 py-3
        rounded-xl
        mb-2
        text-sm
        transition

        {{ request()->routeIs('admin.payment.*')
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
        <rect x="3" y="5" width="18" height="14" rx="2"/>
        <path d="M3 10h18"/>
        <path d="M7 15h4"/>
    </svg>

    <span>Transaksi</span>

</a>

        

    </nav>


    {{-- User / Logout --}}
    <div class="p-4 border-t border-white/10 shrink-0">

        <div class="
            flex items-center
            gap-3
            p-3
            rounded-xl
            bg-[#102A71]/60
            mb-3
        ">

            <div class="
                w-9 h-9
                rounded-full
                bg-[#F5C400]
                text-[#001840]
                flex items-center
                justify-center
                font-bold
                text-sm
            ">
                A
            </div>

            <div class="min-w-0">

                <p class="text-sm font-semibold truncate">
                    Administrator
                </p>

                <p class="text-[10px] text-white/50 truncate">
                    Admin
                </p>

            </div>

        </div>


        {{-- Logout --}}
        @if (Route::has('admin.logout'))

            <form
                method="POST"
                action="{{ route('admin.logout') }}"
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
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <path d="M16 17l5-5-5-5"/>
                        <path d="M21 12H9"/>
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