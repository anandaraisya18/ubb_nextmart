<nav
    id="main-navbar"
    class="sticky top-0 z-50 bg-[#001840]/95 backdrop-blur-md border-b border-white/10 transition-all duration-300 ease-out"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-[72px] flex items-center justify-between gap-6">

            {{-- LOGO --}}
            <a href="{{ route('pelanggan.dashboard') }}" class="group flex items-center gap-3 shrink-0">
                <div id="navbar-logo"
                     class="relative w-10 h-10 rounded-xl bg-white border border-[#F5C400]/30 flex items-center justify-center shadow-lg shadow-black/10 transition-all duration-300 group-hover:border-[#F5C400]/60 group-hover:scale-105">

                    <div class="absolute inset-0 rounded-xl bg-[#F5C400]/10 blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <img src="{{ asset('images/logoubb.png') }}"
                         alt="UBB Nextmart"
                         class="relative w-7 h-7 object-contain">
                </div>

                <div class="leading-none">
                    <h1 class="text-white font-bold text-sm tracking-tight">
                        UBB Nextmart
                    </h1>
                    <p class="text-[10px] text-[#F5C400] font-medium mt-1 tracking-wide">
                        Marketplace UBB
                    </p>
                </div>
            </a>


            {{-- DESKTOP NAVIGATION --}}
            <div class="hidden md:flex items-center gap-1 p-1 rounded-xl bg-white/[0.04] border border-white/[0.06]">

                {{-- BERANDA --}}
                <a href="{{ route('pelanggan.dashboard') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('pelanggan.dashboard') ? 'bg-[#102A71] text-[#F5C400] shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/5' }}">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M3 10.5L12 3l9 7.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 9.5V21h14V9.5" stroke-linejoin="round"/>
                        <path d="M9 21v-6h6v6" stroke-linejoin="round"/>
                    </svg>

                    Beranda
                </a>


                {{-- PRODUK --}}
                <a href="{{ route('pelanggan.produk.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('pelanggan.produk.*') ? 'bg-[#102A71] text-[#F5C400] shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/5' }}">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M4 7h16v13H4z" stroke-linejoin="round"/>
                        <path d="M8 7V5a4 4 0 0 1 8 0v2" stroke-linecap="round"/>
                        <path d="M8 12h8" stroke-linecap="round"/>
                    </svg>

                    Produk
                </a>


                {{-- PESANAN --}}
                <a href="{{ route('pelanggan.pesanan.lacak') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2 {{ request()->routeIs('pelanggan.pesanan.*') ? 'bg-[#102A71] text-[#F5C400] shadow-sm' : 'text-white/60 hover:text-white hover:bg-white/5' }}">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M6 3h12v18H6z" stroke-linejoin="round"/>
                        <path d="M9 7h6M9 11h6M9 15h4" stroke-linecap="round"/>
                    </svg>

                    Pesanan
                </a>

            </div>


            {{-- RIGHT ACTION --}}
            <div class="flex items-center gap-3 shrink-0">

     
                {{-- SEARCH PRODUK --}}
                <form
                    action="{{ route('pelanggan.produk.index') }}"
                    method="GET"
                    class="hidden lg:flex items-center gap-2 px-3 h-10 rounded-xl border border-white/10 bg-white/[0.04] text-white/70 focus-within:border-[#F5C400]/60 transition"
                >
                    <button type="submit" aria-label="Cari produk">
                        <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="6"/>
                            <path d="m16 16 4 4" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari produk..."
                        class="w-36 bg-transparent text-xs text-white placeholder:text-white/35 outline-none focus:w-48 transition-all duration-300"
                        autocomplete="off"
                    >
                </form>


                {{-- KERANJANG --}}
                <a href="{{ route('pelanggan.keranjang.index') }}"
                   class="relative w-10 h-10 rounded-xl bg-[#102A71] border border-white/5 flex items-center justify-center text-[#F5C400] transition-all duration-200 hover:bg-[#F5C400] hover:text-[#001840] hover:scale-105"
                   aria-label="Keranjang">

                    <svg class="w-[19px] h-[19px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M6 6h15l-1.5 9h-12z" stroke-linejoin="round"/>
                        <path d="M6 6L4 3H2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="20" r="1"/>
                        <circle cx="18" cy="20" r="1"/>
                    </svg>

                    @php
                        $jumlahKeranjang = count(session('keranjang', []))
                                        + count(session('keranjang_cetak', []));
                    @endphp
                    <span id="cart-badge"
                          class="{{ $jumlahKeranjang > 0 ? '' : 'hidden' }} absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-[#F5C400] text-[#001840] text-[9px] font-bold flex items-center justify-center border-2 border-[#001840]">
                        {{ $jumlahKeranjang > 99 ? '99+' : $jumlahKeranjang }}
                    </span>
                </a>


                {{-- AKUN PELANGGAN --}}
                @auth('pelanggan')

                    <div class="relative">
                        <details class="relative group">

                            {{-- ICON DAN NAMA --}}
                            <summary
                                class="list-none cursor-pointer flex flex-col items-center justify-center min-w-[48px] gap-0.5 text-white hover:text-[#F5C400] transition"
                                title="{{ auth('pelanggan')->user()->nama }}">

                                <div class="w-9 h-9 rounded-full bg-[#102A71] border border-white/10 flex items-center justify-center group-hover:border-[#F5C400]/50 transition">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                         stroke-width="1.8" viewBox="0 0 24 24">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 21a8 8 0 0 1 16 0" stroke-linecap="round"/>
                                    </svg>

                                </div>

                                <span class="max-w-[90px] truncate text-[10px] font-medium">
                                    {{ auth('pelanggan')->user()->nama }}
                                </span>
                            </summary>

                           
{{-- DROPDOWN MENU --}}
<div class="absolute right-0 top-full mt-3 w-48 h-auto min-h-0 rounded-xl bg-[#001840] border border-white/10 shadow-xl shadow-black/30 overflow-hidden z-[60]">

    {{-- INFORMASI AKUN --}}
    <div class="px-4 py-3 border-b border-white/10">
        <p class="text-[10px] text-white/40">
            Login sebagai
        </p>

        <p class="text-sm font-semibold text-white truncate">
            {{ auth('pelanggan')->user()->nama }}
        </p>
    </div>

    {{-- LOGOUT --}}
    <form
        action="{{ route('pelanggan.logout') }}"
        method="POST"
        class="!m-0 !p-0 !h-auto !min-h-0"
    >
        @csrf

        <button
            type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 transition"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
            >
                <path d="M10 17l5-5-5-5"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
                <path d="M15 12H3"
                      stroke-linecap="round"/>
                <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"
                      stroke-linecap="round"/>
            </svg>

            Logout
        </button>
    </form>

</div>


                @else

                    {{-- GUEST --}}
                    <a href="{{ route('pelanggan.login') }}"
                       class="flex flex-col items-center justify-center min-w-[48px] gap-0.5 text-white/70 hover:text-[#F5C400] transition"
                       title="Login pelanggan">

                        <div class="w-9 h-9 rounded-full bg-[#102A71] border border-white/10 flex items-center justify-center">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                 stroke-width="1.8" viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 21a8 8 0 0 1 16 0" stroke-linecap="round"/>
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium">
                            Guest
                        </span>
                    </a>

                @endauth

            </div>

        </div>
    </div>
</nav>


{{-- NAVBAR SCROLL EFFECT --}}
<script>
    (() => {
        function initNavbarScroll() {
            const navbar = document.getElementById('main-navbar');
            const navbarLogo = document.getElementById('navbar-logo');

            if (!navbar || !navbarLogo) return;

            function updateNavbar() {
                if (window.scrollY > 25) {
                    navbar.classList.remove('bg-[#001840]/95');
                    navbar.classList.add('bg-[#102A71]/95', 'shadow-lg', 'shadow-black/10');

                    navbarLogo.classList.remove('bg-[#102A71]');
                    navbarLogo.classList.add('bg-[#001840]');
                } else {
                    navbar.classList.remove('bg-[#102A71]/95', 'shadow-lg', 'shadow-black/10');
                    navbar.classList.add('bg-[#001840]/95');

                    navbarLogo.classList.remove('bg-[#001840]');
                    navbarLogo.classList.add('bg-[#102A71]');
                }
            }

            window.removeEventListener('scroll', updateNavbar);
            window.addEventListener('scroll', updateNavbar, { passive: true });

            updateNavbar();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initNavbarScroll, { once: true });
        } else {
            initNavbarScroll();
        }
    })();
</script>