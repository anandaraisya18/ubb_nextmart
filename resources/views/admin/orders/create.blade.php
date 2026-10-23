<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-[250px]">

        @include('admin.components.topbar', [
            'title' => 'Tambah Pesanan',
            'subtitle' => 'Catat pesanan baru ke dalam sistem UBB Nexmart'
        ])

        <section class="p-5 md:p-7 lg:p-8">

            @if(session('success'))
                <div class="mb-5 max-w-4xl rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 max-w-4xl rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-4xl overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <div class="border-b border-gray-200 p-5">
                    <h3 class="text-base font-bold text-[#001840] md:text-lg">Informasi Pesanan</h3>
                    <p class="mt-1 text-[11px] text-gray-500">Isi data pesanan dan pilih produk yang dipesan.</p>
                </div>

                <form action="{{ route('admin.orders.store') }}" method="POST" class="p-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- PELANGGAN --}}
                        <div>
                            <label for="nama_pelanggan" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Nama Pelanggan <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_pelanggan"
                                name="nama_pelanggan"
                                value="{{ old('nama_pelanggan') }}"
                                maxlength="100"
                                placeholder="Contoh: Budi Santoso"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('nama_pelanggan') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-500">Jika nama belum terdaftar, pelanggan baru dibuat otomatis.</p>

                            @error('nama_pelanggan')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- EMAIL PELANGGAN --}}
                        <div>
                            <label for="email_pelanggan" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Email Pelanggan <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="email"
                                id="email_pelanggan"
                                name="email_pelanggan"
                                value="{{ old('email_pelanggan') }}"
                                maxlength="255"
                                placeholder="Contoh: budi@email.com"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('email_pelanggan') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            @error('email_pelanggan')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NOMOR HP PELANGGAN --}}
                        <div>
                            <label for="no_hp" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Nomor HP Pelanggan <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="no_hp"
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                maxlength="20"
                                placeholder="Contoh: 081234567890"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('no_hp') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            @error('no_hp')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NO RESI --}}
                        <div>
                            <label for="no_resi" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                No. Resi
                            </label>

                            <input
                                type="text"
                                id="no_resi"
                                name="no_resi"
                                value="{{ old('no_resi') }}"
                                maxlength="50"
                                placeholder="Kosongkan untuk dibuat otomatis"
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('no_resi') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-500">Jika dikosongkan, nomor resi dibuat otomatis.</p>

                            @error('no_resi')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TANGGAL --}}
                        <div>
                            <label for="tanggal_pesanan" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Tanggal Pesanan <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="datetime-local"
                                id="tanggal_pesanan"
                                name="tanggal_pesanan"
                                value="{{ old('tanggal_pesanan', now()->format('Y-m-d\TH:i')) }}"
                                max="{{ now()->format('Y-m-d\TH:i') }}"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('tanggal_pesanan') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            @error('tanggal_pesanan')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TIPE TRANSAKSI: DIKUNCI OFFLINE --}}
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Tipe Transaksi
                            </label>

                            <input type="hidden" name="tipe_transaksi" value="offline">

                            <input
                                type="text"
                                value="Offline"
                                readonly
                                class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-600"
                            >
                        </div>

                        {{-- JENIS PENGAMBILAN --}}
                        <div>
                            <label for="jenis_pengambilan" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Jenis Pengambilan <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="jenis_pengambilan"
                                name="jenis_pengambilan"
                                required
                                class="w-full rounded-lg border bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('jenis_pengambilan') ? 'border-red-400' : 'border-gray-300' }}"
                            >
                                <option value="">Pilih jenis pengambilan</option>
                                @foreach (\App\Models\Pesanan::PENGAMBILAN as $value => $label)
                                    <option value="{{ $value }}" @selected(old('jenis_pengambilan') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>

                            @error('jenis_pengambilan')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STATUS: DIKUNCI SELESAI --}}
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Status Pesanan
                            </label>

                            <input type="hidden" name="status_pesanan" value="selesai">

                            <input
                                type="text"
                                value="Selesai"
                                readonly
                                class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-600"
                            >
                        </div>

                    </div>

                    {{-- ITEM PESANAN --}}
                    <div class="mt-7 border-t border-gray-100 pt-6">

                        <div class="mb-3 flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-[#001840]">Item Pesanan <span class="text-red-500">*</span></h4>
                                <p class="mt-0.5 text-[11px] text-gray-500">Pilih produk dan jumlahnya. Harga diambil otomatis.</p>
                            </div>

                            <button
                                type="button"
                                id="add-item"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#eef2fb] px-3 py-2 text-xs font-semibold text-[#102A71] transition hover:bg-[#dfe7f7]"
                            >
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                </svg>
                                Tambah Produk
                            </button>
                        </div>

                        @if ($errors->has('items') || $errors->has('items.*'))
                            <div class="mb-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-[11px] text-red-700">
                                @error('items')
                                    <p>{{ $message }}</p>
                                @enderror
                                @foreach ($errors->get('items.*') as $messages)
                                    @foreach ($messages as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif

                        @if ($produk->isEmpty())
                            <p class="mb-3 text-[11px] text-gray-500">Belum ada produk aktif yang bisa dipilih.</p>
                        @endif

                        <div class="mb-2 hidden grid-cols-12 gap-3 px-1 text-[11px] font-semibold text-gray-500 md:grid">
                            <div class="col-span-5">Produk</div>
                            <div class="col-span-2">Jumlah</div>
                            <div class="col-span-2">Harga</div>
                            <div class="col-span-2">Subtotal</div>
                            <div class="col-span-1"></div>
                        </div>

                        <div id="item-rows" class="space-y-3"></div>
                    </div>

                    {{-- RINGKASAN --}}
                    <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2">

                        <div>
                            <label for="subtotal" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Subtotal
                            </label>

                            <input
                                type="text"
                                id="subtotal"
                                value="0"
                                readonly
                                class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-600 outline-none"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-500">Dihitung otomatis dari item pesanan (rupiah).</p>
                        </div>

                        <div>
                            <label for="total" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Total <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="number"
                                id="total"
                                name="total"
                                min="0"
                                value="{{ old('total', 0) }}"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('total') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-500">Terisi otomatis dari subtotal, bisa diubah.</p>

                            @error('total')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="mt-6 flex items-center justify-end gap-2 border-t border-gray-100 pt-5">
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="rounded-lg bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-200"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-[#F5C400] px-4 py-2.5 text-xs font-bold text-[#001840] transition hover:-translate-y-0.5 hover:bg-[#ffd21a]"
                        >
                            Simpan Pesanan
                        </button>
                    </div>
                </form>

            </div>

        </section>

    </main>

    @php
        $produkJs = $produk->map(fn ($p) => [
            'id'    => $p->id_produk,
            'nama'  => $p->nama_produk,
            'harga' => (int) round($p->harga),
            'stok'  => $p->stok,
        ])->values();
    @endphp

    <script>
        (function () {
            const produk = @json($produkJs);
            const oldItems = @json(old('items', []));
            const oldTotal = @json(old('total'));

            const rowsEl = document.getElementById('item-rows');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');
            const rupiah = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

            let idx = 0;
            let totalEdited = false;

            function findProduk(id) {
                return produk.find((p) => String(p.id) === String(id));
            }

            function recalc() {
                let sum = 0;

                rowsEl.querySelectorAll('.item-row').forEach((row) => {
                    const p = findProduk(row.querySelector('.item-produk').value);
                    const jumlah = parseInt(row.querySelector('.item-jumlah').value, 10) || 0;
                    const harga = p ? p.harga : 0;
                    const line = harga * jumlah;

                    row.querySelector('.item-harga').textContent = rupiah(harga);
                    row.querySelector('.item-subtotal').textContent = rupiah(line);
                    sum += line;
                });

                subtotalEl.value = sum;

                if (!totalEdited) {
                    totalEl.value = sum;
                }
            }

            function addRow(item = {}) {
                const i = idx++;
                const row = document.createElement('div');

                row.className = 'item-row grid grid-cols-1 items-center gap-3 rounded-xl border border-gray-100 bg-[#fafbfe] p-3 md:grid-cols-12 md:border-0 md:bg-transparent md:p-0';

                row.innerHTML = `
                    <div class="md:col-span-5">
                        <select name="items[${i}][id_produk]" required
                            class="item-produk w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71]">
                            <option value="">Pilih produk</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <input type="number" name="items[${i}][jumlah]" min="1" value="1" required
                            class="item-jumlah w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71]">
                    </div>
                    <div class="item-harga text-sm text-gray-600 md:col-span-2">Rp 0</div>
                    <div class="item-subtotal text-sm font-semibold text-[#001840] md:col-span-2">Rp 0</div>
                    <div class="md:col-span-1 md:text-right">
                        <button type="button"
                            class="item-remove inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-500 hover:text-white"
                            title="Hapus item">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </div>
                `;

                const select = row.querySelector('.item-produk');

                produk.forEach((p) => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.nama + ' (stok ' + p.stok + ')';
                    select.appendChild(opt);
                });

                if (item.id_produk) select.value = item.id_produk;
                if (item.jumlah) row.querySelector('.item-jumlah').value = item.jumlah;

                select.addEventListener('change', recalc);
                row.querySelector('.item-jumlah').addEventListener('input', recalc);

                row.querySelector('.item-remove').addEventListener('click', () => {
                    row.remove();
                    if (rowsEl.children.length === 0) addRow();
                    recalc();
                });

                rowsEl.appendChild(row);
                recalc();
            }

            document.getElementById('add-item').addEventListener('click', () => addRow());

            totalEl.addEventListener('input', () => {
                totalEdited = true;
            });

            const restored = Array.isArray(oldItems) ? oldItems : Object.values(oldItems);

            if (restored.length) {
                restored.forEach((item) => addRow(item));
            } else {
                addRow();
            }

            if (oldTotal !== null && oldTotal !== '') {
                totalEl.value = oldTotal;
                totalEdited = Number(oldTotal) !== Number(subtotalEl.value);
            }
        })();
    </script>

</body>

</html>