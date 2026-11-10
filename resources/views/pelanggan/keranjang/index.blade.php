@extends('pelanggan.layouts.app')

@section('title', 'Keranjang Belanja - UBB Nextmart')

@section('content')

<div class="min-h-screen bg-slate-50">

    <!-- HEADER -->
    <section class="bg-[#001840] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-4">

                <a href="{{ route('pelanggan.dashboard') }}"
                   class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 12H5" stroke-linecap="round"/>
                        <path d="M12 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <div>
                    <p class="text-[11px] text-[#F5C400] font-semibold uppercase tracking-[0.15em]">
                        UBB Nextmart
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-bold mt-1">
                        Keranjang Belanja
                    </h1>
                    <p class="text-sm text-white/55 mt-1">
                        Periksa produk pilihanmu sebelum checkout.
                    </p>
                </div>

            </div>
        </div>
    </section>


    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- ALERT -->
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif


        <!-- KERANJANG KOSONG -->
        @if($groups->isEmpty())

            <div class="bg-white rounded-2xl border border-[#001840]/10 shadow-sm px-6 py-16 text-center">

                <div class="mx-auto mb-4 w-16 h-16 rounded-2xl bg-[#F5C400]/15 text-[#001840] flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="20" r="1"/>
                        <circle cx="18" cy="20" r="1"/>
                    </svg>
                </div>

                <h2 class="text-base font-bold text-[#001840]">
                    Keranjang masih kosong
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    Yuk, pilih produk yang kamu butuhkan dulu.
                </p>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#F5C400] px-5 py-3 text-sm font-bold text-[#001840] transition hover:bg-[#ffd21a]">
                        Lihat Produk
                    </a>
                    <a href="{{ route('pelanggan.cetak.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-[#001840]/15 px-5 py-3 text-sm font-bold text-[#001840] transition hover:bg-slate-50">
                        Cetak Dokumen
                    </a>
                </div>

            </div>

        @else

            <!-- FORM CHECKOUT -->
            <form id="checkoutForm"
                  action="{{ route('pelanggan.keranjang.checkout') }}"
                  method="POST"
                  class="hidden">
                @csrf
            </form>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- CART -->
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-2xl border border-[#001840]/10 shadow-sm overflow-hidden">

                        <!-- HEADER CART -->
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between gap-4">

                            <div>
                                <h2 class="text-base font-bold text-[#001840]">
                                    Produk Dipilih
                                </h2>
                                <p class="text-xs text-gray-500 mt-1">
                                    Pilih produk yang ingin kamu checkout.
                                </p>
                            </div>

                            <span id="itemCount"
                                  class="shrink-0 px-3 py-1.5 rounded-lg bg-[#F5C400]/15 text-[#001840] text-xs font-bold">
                                0 Item
                            </span>

                        </div>

                        @if($groups->count() > 1)
                            <div id="groupHint"
                                 class="px-6 py-3 bg-yellow-50 border-b border-yellow-100 text-xs text-[#967500]">
                                Produk dari grup berbeda tidak bisa di-checkout bersamaan.
                                Pilih produk dari satu grup saja.
                            </div>
                        @endif


                        <!-- PER GRUP -->
                        @foreach($groups as $group)

                            @php $isFirstGroup = $loop->first; @endphp

                            <div class="cart-group" data-group="{{ $group['id_group'] }}">

                                <!-- HEADER GRUP -->
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-[#F5F7FB] px-6 py-3">

                                    <div>
                                        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                            Grup
                                        </p>
                                        <p class="text-sm font-bold text-[#001840]">
                                            {{ $group['nama_group'] }}
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="selectGroup('{{ $group['id_group'] }}')"
                                            class="text-xs font-semibold text-[#102A71] hover:text-[#001840] transition">
                                        Pilih Semua
                                    </button>

                                </div>


                                {{-- PRODUK BIASA --}}
                                @foreach($group['items'] as $item)

                                    <div class="cart-item p-6 border-b border-slate-100 transition"
                                         data-id="{{ $item['id_produk'] }}"
                                         data-tipe="produk"
                                         data-group="{{ $item['id_group'] }}"
                                         data-price="{{ $item['harga'] }}"
                                         data-stok="{{ $item['stok'] }}">

                                        <div class="flex flex-col sm:flex-row gap-4">

                                            <!-- CHECKBOX -->
                                            <div class="flex items-start sm:pt-2">
                                                <input type="checkbox"
                                                       name="items[]"
                                                       value="{{ $item['id_produk'] }}"
                                                       form="checkoutForm"
                                                       class="cart-checkbox w-5 h-5 rounded accent-[#F5C400] cursor-pointer disabled:cursor-not-allowed"
                                                       @checked($isFirstGroup)
                                                       onchange="updateCart()">
                                            </div>


                                            <!-- GAMBAR PRODUK -->
                                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-[#102A71] flex items-center justify-center shrink-0 overflow-hidden">

                                                @if($item['gambar'])
                                                    <img src="{{ asset('storage/' . $item['gambar']) }}"
                                                         alt="{{ $item['nama'] }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-9 h-9 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                                        <path d="M3 3h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 7H6" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <circle cx="10" cy="20" r="1"/>
                                                        <circle cx="18" cy="20" r="1"/>
                                                    </svg>
                                                @endif

                                            </div>


                                            <!-- INFORMASI PRODUK -->
                                            <div class="flex-1 min-w-0">

                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                                                    <div class="min-w-0">

                                                        <p class="text-[10px] text-[#F5C400] font-bold uppercase tracking-wider">
                                                            {{ $item['nama_toko'] }}
                                                        </p>

                                                        <h3 class="text-sm sm:text-base font-bold text-[#001840] mt-1">
                                                            {{ $item['nama'] }}
                                                        </h3>

                                                        <p class="text-xs text-gray-500 mt-1">
                                                            Rp{{ number_format($item['harga'], 0, ',', '.') }} / item
                                                            • Stok {{ $item['stok'] }}
                                                        </p>

                                                    </div>

                                                    <p class="product-subtotal text-sm sm:text-base font-bold text-[#001840]">
                                                        Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                                    </p>

                                                </div>


                                                <!-- JUMLAH DAN HAPUS -->
                                                <div class="mt-4 flex items-center justify-between gap-4">

                                                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden">

                                                        <button type="button"
                                                                onclick="changeQuantity(this, -1)"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-slate-50 hover:text-[#001840] transition">
                                                            −
                                                        </button>

                                                        <input type="text"
                                                               inputmode="numeric"
                                                               pattern="[0-9]*"
                                                               name="qty[{{ $item['id_produk'] }}]"
                                                               form="checkoutForm"
                                                               value="{{ $item['jumlah'] }}"
                                                               autocomplete="off"
                                                               class="quantity w-12 h-9 text-center text-sm font-semibold text-[#001840] border-x border-slate-200 outline-none focus:bg-slate-50"
                                                               oninput="onQtyInput(this)">

                                                        <button type="button"
                                                                onclick="changeQuantity(this, 1)"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-slate-50 hover:text-[#001840] transition">
                                                            +
                                                        </button>

                                                    </div>


                                                    <button type="button"
                                                            onclick="removeItem(this)"
                                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 hover:text-red-600 transition">

                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                            <path d="M3 6h18" stroke-linecap="round"/>
                                                            <path d="M8 6V4h8v2" stroke-linecap="round"/>
                                                            <path d="M19 6l-1 14H6L5 6" stroke-linejoin="round"/>
                                                            <path d="M10 11v5M14 11v5" stroke-linecap="round"/>
                                                        </svg>

                                                        Hapus
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach


                                {{-- PEKERJAAN CETAK --}}
                                @foreach($group['cetak'] ?? [] as $job)

                                    <div class="cart-item p-6 border-b border-slate-100 transition"
                                         data-id="{{ $job['job_id'] }}"
                                         data-tipe="cetak"
                                         data-group="{{ $job['id_group'] }}"
                                         data-price="{{ $job['total_harga'] }}"
                                         data-stok="1">

                                        <div class="flex flex-col sm:flex-row gap-4">

                                            <!-- CHECKBOX -->
                                            <div class="flex items-start sm:pt-2">
                                                <input type="checkbox"
                                                       name="cetak[]"
                                                       value="{{ $job['job_id'] }}"
                                                       form="checkoutForm"
                                                       class="cart-checkbox w-5 h-5 rounded accent-[#F5C400] cursor-pointer disabled:cursor-not-allowed"
                                                       @checked($isFirstGroup)
                                                       onchange="updateCart()">
                                            </div>


                                            <!-- IKON CETAK -->
                                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-[#102A71] flex items-center justify-center shrink-0">
                                                <svg class="w-9 h-9 text-[#F5C400]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                                    <path d="M6 9V3h12v6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <rect x="6" y="14" width="12" height="7"/>
                                                </svg>
                                            </div>


                                            <!-- INFORMASI CETAK -->
                                            <div class="flex-1 min-w-0">

                                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                                                    <div class="min-w-0">

                                                        <p class="text-[10px] text-[#F5C400] font-bold uppercase tracking-wider">
                                                            {{ $job['nama_toko'] }} • Cetak Dokumen
                                                        </p>

                                                        <h3 class="text-sm sm:text-base font-bold text-[#001840] mt-1 break-all">
                                                            {{ $job['nama_file'] }}
                                                        </h3>

                                                        <p class="text-xs text-gray-500 mt-1">
                                                            Halaman: {{ $job['halaman_dipilih'] }}
                                                            • Hitam putih {{ $job['halaman_hitam_putih'] }}
                                                            • Warna {{ $job['halaman_warna'] }}
                                                            • {{ $job['jumlah_cetak'] }} salinan
                                                        </p>

                                                        @if(!empty($job['catatan_pelanggan']))
                                                            <p class="text-xs text-gray-400 mt-1">
                                                                Catatan: {{ $job['catatan_pelanggan'] }}
                                                            </p>
                                                        @endif

                                                    </div>

                                                    <p class="product-subtotal text-sm sm:text-base font-bold text-[#001840]">
                                                        Rp{{ number_format($job['total_harga'], 0, ',', '.') }}
                                                    </p>

                                                </div>


                                                <div class="mt-4 flex justify-end">
                                                    <button type="button"
                                                            onclick="removeCetak(this)"
                                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 hover:text-red-600 transition">

                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                            <path d="M3 6h18" stroke-linecap="round"/>
                                                            <path d="M8 6V4h8v2" stroke-linecap="round"/>
                                                            <path d="M19 6l-1 14H6L5 6" stroke-linejoin="round"/>
                                                            <path d="M10 11v5M14 11v5" stroke-linecap="round"/>
                                                        </svg>

                                                        Hapus
                                                    </button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @endforeach

                    </div>

                </div>


                <!-- RINGKASAN BELANJA -->
                <div>

                    <div class="bg-white rounded-2xl border border-[#001840]/10 shadow-sm overflow-hidden lg:sticky lg:top-6">

                        <div class="px-6 py-5 bg-[#001840] text-white">

                            <p class="text-[10px] text-[#F5C400] uppercase tracking-wider font-semibold">
                                Checkout
                            </p>

                            <h2 class="font-bold mt-1">
                                Ringkasan Belanja
                            </h2>

                            <p class="text-xs text-white/50 mt-1">
                                Total produk yang dipilih.
                            </p>

                        </div>

                        <div class="p-6">

                            <div class="flex justify-between text-sm mb-3">
                                <span class="text-gray-500">Subtotal</span>
                                <span id="subtotal" class="font-semibold text-[#001840]">Rp0</span>
                            </div>

                            <div class="flex justify-between text-sm mb-5">
                                <span class="text-gray-500">Biaya tambahan</span>
                                <span class="font-semibold text-[#001840]">Rp0</span>
                            </div>

                            <div class="border-t border-slate-100 pt-5">

                                <div class="flex justify-between items-center gap-4">

                                    <div>
                                        <p class="text-xs text-gray-500">Total</p>
                                        <p id="total" class="text-2xl font-bold text-[#001840] mt-1">
                                            Rp0
                                        </p>
                                    </div>

                                    <div class="w-11 h-11 rounded-xl bg-[#F5C400]/15 text-[#001840] flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M3 7h18" stroke-linecap="round"/>
                                            <path d="M5 7v13h14V7" stroke-linejoin="round"/>
                                            <path d="M8 7V5a4 4 0 0 1 8 0v2" stroke-linecap="round"/>
                                        </svg>
                                    </div>

                                </div>

                            </div>


                            <!-- TOMBOL CHECKOUT -->
                            <button type="button"
                                    onclick="goToCheckout()"
                                    class="w-full mt-6 py-3.5 rounded-xl bg-[#F5C400] text-[#001840] text-sm font-bold border border-[#F5C400] hover:bg-[#102A71] hover:text-[#F5C400] transition active:scale-[0.98]">

                                <span class="flex items-center justify-center gap-2">
                                    Lanjut Checkout

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h14" stroke-linecap="round"/>
                                        <path d="M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>

                            </button>

                            <a href="{{ route('pelanggan.produk.index') }}"
                               class="block text-center text-xs font-medium text-gray-500 hover:text-[#102A71] mt-4 transition">
                                ← Lanjut Belanja
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    </main>

</div>


<!-- POP-UP LOGIN DIPERLUKAN -->
<div id="loginWarningModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-[#001840]/70 px-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl border border-[#F5C400]/20 bg-white p-7 shadow-2xl">

        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F5C400]/15">

            <svg class="h-8 w-8 text-[#001840]" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                <rect x="4" y="10" width="16" height="11" rx="2"/>
                <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke-linecap="round"/>
                <path d="M12 14v3" stroke-linecap="round"/>
            </svg>

        </div>

        <div class="text-center">

            <h2 class="text-xl font-bold text-[#001840]">
                Login Diperlukan
            </h2>

            <p class="mt-3 text-sm leading-relaxed text-gray-500">
                Silakan login terlebih dahulu untuk melanjutkan proses checkout.
                Kamu tetap bisa menjelajahi produk UBB Nextmart tanpa login.
            </p>

        </div>

        <div class="mt-7 space-y-3">

            <a href="{{ route('pelanggan.login') }}"
               class="flex w-full items-center justify-center gap-2 rounded-xl border border-[#F5C400] bg-[#F5C400] py-3 text-sm font-bold text-[#001840] transition hover:bg-[#102A71] hover:text-[#F5C400]">

                Login Sekarang

                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14" stroke-linecap="round"/>
                    <path d="m13 6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

            </a>

            <button type="button"
                    onclick="closeLoginWarning()"
                    class="w-full rounded-xl border border-gray-200 bg-white py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                Kembali ke Keranjang
            </button>

        </div>

    </div>

</div>


<!-- JAVASCRIPT -->
@if($groups->isNotEmpty())
<script>

    const isCustomerLoggedIn = @json(auth('pelanggan')->check());

    const csrf = "{{ csrf_token() }}";
    const updateUrl = "{{ route('pelanggan.keranjang.update', ['id' => '__ID__']) }}";
    const destroyUrl = "{{ route('pelanggan.keranjang.destroy', ['id' => '__ID__']) }}";
    const destroyCetakUrl = "{{ route('pelanggan.keranjang.cetak.destroy', ['jobId' => '__ID__']) }}";

    const saveTimers = {};


    function formatRupiah(number) {
        return 'Rp' + Number(number).toLocaleString('id-ID');
    }


    function readQty(item) {

        // Pekerjaan cetak: jumlah selalu 1 (total harga sudah termasuk salinan)
        if (item.dataset.tipe === 'cetak') return 1;

        const stok = parseInt(item.dataset.stok, 10);
        let qty = parseInt(item.querySelector('.quantity').value, 10);

        if (isNaN(qty) || qty < 1) qty = 1;
        if (qty > stok) qty = stok;

        return qty;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    |--------------------------------------------------------------------------
    */
    function updateCart() {

        let subtotal = 0;
        let selectedCount = 0;
        let activeGroup = null;

        const items = document.querySelectorAll('.cart-item');

        items.forEach(item => {

            const checkbox = item.querySelector('.cart-checkbox');
            const price = parseInt(item.dataset.price, 10);
            const qty = readQty(item);

            item.querySelector('.product-subtotal').textContent =
                formatRupiah(price * qty);

            if (checkbox.checked) {
                subtotal += price * qty;
                selectedCount++;
                activeGroup = item.dataset.group;
            }

        });


        // Kunci produk dari grup lain
        items.forEach(item => {

            const checkbox = item.querySelector('.cart-checkbox');
            const locked = activeGroup !== null &&
                           item.dataset.group !== activeGroup;

            checkbox.disabled = locked;
            item.classList.toggle('opacity-50', locked);

        });


        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('total').textContent = formatRupiah(subtotal);

        document.getElementById('itemCount').textContent =
            selectedCount + ' Item' + (selectedCount !== 1 ? 's' : '');

    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN JUMLAH KE SERVER
    |--------------------------------------------------------------------------
    */
    function persistQty(item) {

        if (item.dataset.tipe === 'cetak') return;

        const id = item.dataset.id;

        clearTimeout(saveTimers[id]);

        saveTimers[id] = setTimeout(() => {

            fetch(updateUrl.replace('__ID__', id), {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    jumlah: readQty(item)
                }),
            }).catch(() => {});

        }, 400);

    }


    function changeQuantity(button, amount) {

        const item = button.closest('.cart-item');
        const input = item.querySelector('.quantity');

        input.value = Math.max(1, readQty(item) + amount);
        input.value = readQty(item);

        updateCart();
        persistQty(item);

    }


    function onQtyInput(input) {

        input.value = input.value.replace(/[^0-9]/g, '');

        updateCart();
        persistQty(input.closest('.cart-item'));

    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ITEM (PRODUK / CETAK)
    |--------------------------------------------------------------------------
    */
    async function deleteFromServer(url, failMessage) {

        try {

            const res = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
            });

            if (!res.ok) throw new Error();

            return true;

        } catch (e) {

            alert(failMessage);
            return false;

        }

    }


    function afterRemove(item) {

        const group = item.closest('.cart-group');

        item.remove();

        if (group && !group.querySelector('.cart-item')) {
            group.remove();
        }

        if (!document.querySelector('.cart-item')) {
            window.location.reload();
            return;
        }

        updateCart();

    }


    async function removeItem(button) {

        const item = button.closest('.cart-item');
        if (!item) return;

        const ok = await deleteFromServer(
            destroyUrl.replace('__ID__', item.dataset.id),
            'Gagal menghapus produk. Coba lagi.'
        );

        if (ok) afterRemove(item);

    }


    async function removeCetak(button) {

        const item = button.closest('.cart-item');
        if (!item) return;

        const ok = await deleteFromServer(
            destroyCetakUrl.replace('__ID__', item.dataset.id),
            'Gagal menghapus pekerjaan cetak. Coba lagi.'
        );

        if (ok) afterRemove(item);

    }


    /*
    |--------------------------------------------------------------------------
    | PILIH SEMUA DALAM SATU GRUP
    |--------------------------------------------------------------------------
    */
    function selectGroup(groupId) {

        const boxes = document.querySelectorAll(
            '.cart-item[data-group="' + groupId + '"] .cart-checkbox'
        );

        const allChecked = Array.from(boxes).every(box => box.checked);

        document.querySelectorAll('.cart-checkbox').forEach(box => {
            box.checked = false;
            box.disabled = false;
        });

        if (!allChecked) {
            boxes.forEach(box => box.checked = true);
        }

        updateCart();

    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */
    function goToCheckout() {

        const selected = document.querySelectorAll('.cart-checkbox:checked');

        if (selected.length === 0) {
            alert('Silakan pilih minimal satu produk atau pekerjaan cetak terlebih dahulu.');
            return;
        }


        // Jika guest, tampilkan peringatan login
        if (!isCustomerLoggedIn) {
            openLoginWarning();
            return;
        }


        // Normalisasi jumlah (hanya produk biasa)
        document.querySelectorAll('.cart-item:not([data-tipe="cetak"])').forEach(item => {
            item.querySelector('.quantity').value = readQty(item);
        });


        document.getElementById('checkoutForm').submit();

    }


    /*
    |--------------------------------------------------------------------------
    | POP-UP LOGIN
    |--------------------------------------------------------------------------
    */
    function openLoginWarning() {

        const modal = document.getElementById('loginWarningModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

    }


    function closeLoginWarning() {

        const modal = document.getElementById('loginWarningModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    // Tutup pop-up jika pengguna menekan area luar
    document.getElementById('loginWarningModal').addEventListener('click', function(event) {

        if (event.target === this) {
            closeLoginWarning();
        }

    });


    // Tutup pop-up menggunakan tombol Escape
    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {
            closeLoginWarning();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI JUMLAH
    |--------------------------------------------------------------------------
    */
    document.addEventListener('focusout', function(event) {

        if (event.target.classList.contains('quantity')) {

            const item = event.target.closest('.cart-item');

            event.target.value = readQty(item);

            updateCart();
            persistQty(item);

        }

    });


    updateCart();

</script>
@endif

@endsection