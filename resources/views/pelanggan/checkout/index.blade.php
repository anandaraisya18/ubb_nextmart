{{-- resources/views/pelanggan/checkout/index.blade.php --}}

@extends('pelanggan.layouts.app')

@section('title', 'Checkout - UBB Nextmart')

@section('content')

<style>
    :root {
        --navbar-height: 80px;
    }

    .checkout-summary {
        position: sticky;
        top: calc(var(--navbar-height) + 16px);
    }

    @media (max-width: 1023px) {
        .checkout-summary {
            position: static;
        }
    }
</style>


<div class="min-h-screen bg-slate-50">

    {{-- =========================
         HEADER CHECKOUT
    ========================== --}}
    <section class="bg-[#001840] text-white">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3">

                <a href="{{ route('pelanggan.keranjang.index') }}"
                   class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>

                <div>
                    <p class="text-xs text-[#F5C400] font-semibold uppercase tracking-wider">
                        UBB Nextmart
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-bold">
                        Checkout
                    </h1>
                </div>

            </div>
        </div>
    </section>


    {{-- =========================
         CHECKOUT CONTENT
    ========================== --}}
    <main class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 py-8">

        {{-- ALERT --}}
        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Terdapat kesalahan pada data:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="checkoutForm" action="{{ route('pelanggan.checkout.store') }}" method="POST" novalidate>
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                {{-- =====================================
                     BAGIAN KIRI
                     DATA PEMBELI + PEMBAYARAN
                ====================================== --}}
                <div class="lg:col-span-2 space-y-6">


                    {{-- =========================
                         DATA PEMBELI
                    ========================== --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                        <div class="px-6 py-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-xl bg-[#102A71] flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="font-bold text-[#001840]">Data Pembeli</h2>
                                    <p class="text-xs text-slate-500">Isi data untuk proses pesanan</p>
                                </div>

                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Nama --}}
                                <div class="md:col-span-2">
                                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Nama Lengkap
                                    </label>

                                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" maxlength="100"
                                           placeholder="Masukkan nama lengkap"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none transition focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10">
                                </div>

                                {{-- Nomor HP --}}
                                <div>
                                    <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Nomor HP
                                    </label>

                                    <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}" maxlength="20"
                                           placeholder="08xxxxxxxxxx"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none transition focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10">
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Email
                                    </label>

                                    <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="100"
                                           placeholder="nama@email.com"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none transition focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10">
                                </div>

                                {{-- Catatan --}}
                                <div class="md:col-span-2">
                                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Catatan Pesanan
                                        <span class="font-normal text-slate-400">(opsional)</span>
                                    </label>

                                    <textarea id="catatan" name="catatan" rows="3" maxlength="500"
                                              placeholder="Tambahkan catatan untuk pesanan..."
                                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none resize-none transition focus:border-[#F5C400] focus:ring-4 focus:ring-[#F5C400]/10">{{ old('catatan') }}</textarea>
                                </div>

                            </div>
                        </div>

                    </div>


                    {{-- =========================
                         METODE PEMBAYARAN
                    ========================== --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                        <div class="px-6 py-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-xl bg-[#102A71] flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                        <path d="M3 10h18" />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="font-bold text-[#001840]">Pembayaran</h2>
                                    <p class="text-xs text-slate-500">Pilih metode pembayaran</p>
                                </div>

                            </div>
                        </div>

                        <div class="p-6">

                            {{-- QRIS --}}
                            <label class="block cursor-pointer">

                                <input type="radio" name="payment_method" value="qris" checked class="peer sr-only">

                                <div class="p-4 rounded-xl border-2 border-[#F5C400] bg-[#F5C400]/5 peer-checked:border-[#F5C400] transition">
                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-[#001840]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <rect x="4" y="4" width="6" height="6" />
                                                <rect x="14" y="4" width="6" height="6" />
                                                <rect x="4" y="14" width="6" height="6" />
                                                <path d="M14 14h2v2h-2zM18 14h2v6h-6v-2" />
                                            </svg>
                                        </div>

                                        <div class="flex-1">
                                            <p class="font-semibold text-[#001840]">QRIS</p>
                                            <p class="text-xs text-slate-500">Pembayaran melalui QRIS</p>
                                        </div>

                                        <div class="w-5 h-5 rounded-full border-4 border-[#F5C400]"></div>

                                    </div>
                                </div>

                            </label>


                            {{-- Informasi pembayaran --}}
                            <div class="mt-5 p-4 rounded-xl bg-[#001840] text-white">
                                <div class="flex items-start gap-3">

                                    <svg class="w-5 h-5 text-[#F5C400] mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 11v5" stroke-linecap="round" />
                                        <circle cx="12" cy="8" r=".5" fill="currentColor" />
                                    </svg>

                                    <div>
                                        <p class="text-sm font-semibold">Pembayaran QRIS</p>
                                        <p class="text-xs text-white/60 mt-1 leading-relaxed">
                                            Setelah checkout, silakan lakukan pembayaran sesuai total pesanan
                                            melalui QRIS. Bukti pembayaran dapat diunggah pada tahap pembayaran.
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================
                     BAGIAN KANAN
                     RINGKASAN PESANAN
                ====================================== --}}
                <div>

                    <div class="checkout-summary bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                        {{-- Header --}}
                        <div class="px-6 py-5 bg-[#001840] text-white">
                            <h2 class="font-bold">Ringkasan Pesanan</h2>
                            <p class="text-xs text-white/60 mt-1">
                                Grup: {{ $group }}
                            </p>
                        </div>


                        <div class="p-6">

                            {{-- Produk --}}
                            <div class="space-y-4 pb-5 border-b border-slate-100">

                                @foreach($items as $item)

                                    <div class="flex items-center gap-3">

                                        <div class="w-16 h-16 rounded-xl bg-[#102A71] flex items-center justify-center shrink-0 overflow-hidden">
                                            @if($item['gambar'])
                                                {{-- SESUAIKAN path gambar jika berbeda --}}
                                                <img src="{{ asset('storage/' . $item['gambar']) }}"
                                                     alt="{{ $item['nama'] }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-7 h-7 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                                    <path d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6" stroke-linecap="round" stroke-linejoin="round" />
                                                    <circle cx="10" cy="20" r="1" />
                                                    <circle cx="18" cy="20" r="1" />
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-sm text-[#001840] truncate">
                                                {{ $item['nama'] }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $item['nama_toko'] }} • {{ $item['jumlah'] }} item
                                            </p>
                                        </div>

                                        <p class="font-bold text-sm text-[#001840]">
                                            Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>

                                    </div>

                                @endforeach

                            </div>


                            {{-- Rincian --}}
                            <div class="space-y-3 py-5 border-b border-slate-100">

                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500">Subtotal</span>
                                    <span class="font-medium text-slate-700">
                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500">Biaya tambahan</span>
                                    <span class="font-medium text-slate-700">Rp0</span>
                                </div>

                            </div>


                            {{-- Total --}}
                            <div class="py-5">
                                <div class="flex items-center justify-between">

                                    <div>
                                        <p class="text-xs text-slate-500">Total Pembayaran</p>
                                        <p class="text-xl font-bold text-[#001840] mt-1">
                                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="px-3 py-1.5 rounded-lg bg-[#F5C400]/15 text-[#001840] text-[10px] font-bold uppercase">
                                        QRIS
                                    </div>

                                </div>
                            </div>


                            {{-- Tombol --}}
                            <button type="button"
                                    id="btnCheckout"
                                    onclick="processCheckout()"
                                    class="w-full py-3.5 rounded-xl bg-[#F5C400] hover:bg-[#e5b900] text-[#001840] font-bold text-sm transition active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed">

                                <span class="flex items-center justify-center gap-2">
                                    Lanjut ke Pembayaran

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h14" stroke-linecap="round" />
                                        <path d="M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>

                            </button>

                            <p class="text-[11px] text-slate-400 text-center mt-3">
                                Pastikan data pembeli sudah benar.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </main>

</div>



{{-- =========================
     JAVASCRIPT
========================== --}}
<script>

    /*
    |--------------------------------------------------------------------------
    | Dynamic Navbar Height
    |--------------------------------------------------------------------------
    |
    | Membaca tinggi navbar secara otomatis.
    | Ringkasan checkout akan menjaga jarak 16px
    | dari bagian bawah navbar.
    |
    */

    function updateNavbarHeight() {

        const navbar = document.querySelector('#navbar');

        if (!navbar) {
            document.documentElement.style.setProperty('--navbar-height', '80px');
            return;
        }

        const height = navbar.getBoundingClientRect().height;

        document.documentElement.style.setProperty('--navbar-height', `${height}px`);
    }

    updateNavbarHeight();

    window.addEventListener('resize', updateNavbarHeight);
    window.addEventListener('load', updateNavbarHeight);


    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    function processCheckout() {

        const nama = document.getElementById('nama').value.trim();
        const telepon = document.getElementById('telepon').value.trim();
        const email = document.getElementById('email').value.trim();

        if (!nama) {
            alert('Silakan isi nama lengkap terlebih dahulu.');
            document.getElementById('nama').focus();
            return;
        }

        if (!telepon) {
            alert('Silakan isi nomor HP terlebih dahulu.');
            document.getElementById('telepon').focus();
            return;
        }

        if (!email) {
            alert('Silakan isi email terlebih dahulu.');
            document.getElementById('email').focus();
            return;
        }

        // Cegah klik ganda agar pesanan tidak terbuat dua kali
        const button = document.getElementById('btnCheckout');
        button.disabled = true;

        document.getElementById('checkoutForm').submit();
    }

</script>

@endsection