<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-[#1f2937]">

    {{-- SIDEBAR --}}
    @include('admin.components.sidebar')

    {{-- lg:ml-64 = 256px, sama dengan lebar sidebar (w-64) --}}
    <main class="min-h-screen lg:ml-64">

        {{-- TOPBAR --}}
        @include('admin.components.topbar', [
            'title' => 'Edit Produk',
            'subtitle' => 'Perbarui informasi produk di katalog UBB Nexmart'
        ])

        <section class="p-4 sm:p-6 lg:p-8">

            {{-- ALERT --}}
            @if ($errors->any())
                <div class="mb-5 max-w-4xl rounded-xl border border-[#f5d0d0] bg-[#feecec] px-4 py-3 text-xs text-[#c83b3b]">
                    <strong>Terdapat kesalahan pada data:</strong>
                    <ul class="ml-4 mt-1.5 list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5 max-w-4xl rounded-xl border border-[#ccebd8] bg-[#e7f7ed] px-4 py-3 text-xs text-[#218448]">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FORM --}}
            <div class="max-w-4xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                    <h3 class="text-sm font-bold text-[#001840] sm:text-base">Informasi Produk</h3>
                    <p class="mt-1 text-[10px] text-gray-500 sm:text-xs">Ubah data produk lalu simpan perubahan.</p>
                </div>

                <form
                    action="{{ route('admin.products.update', $product) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-5 sm:p-6"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NAMA PRODUK --}}
                        <div class="md:col-span-2">
                            <label for="nama_produk" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Nama Produk <span class="text-red-600">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk', $product->nama_produk) }}"
                                maxlength="150"
                                placeholder="Contoh: Pulpen Joyko"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('nama_produk') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            @error('nama_produk')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- KATEGORI --}}
                        <div>
                            <label for="id_kategori" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Kategori <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="id_kategori"
                                name="id_kategori"
                                required
                                class="w-full rounded-lg border bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('id_kategori') ? 'border-red-400' : 'border-gray-300' }}"
                            >
                                <option value="">Pilih kategori</option>

                                @foreach ($kategori as $item)
                                    <option
                                        value="{{ $item->id_kategori }}"
                                        @selected(old('id_kategori', $product->id_kategori) == $item->id_kategori)
                                    >
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            @error('id_kategori')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TOKO --}}
                        <div>
                            <label for="id_toko" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Toko <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="id_toko"
                                name="id_toko"
                                required
                                class="w-full rounded-lg border bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('id_toko') ? 'border-red-400' : 'border-gray-300' }}"
                            >
                                <option value="">Pilih toko</option>

                                @foreach ($toko as $item)
                                    <option
                                        value="{{ $item->id_toko }}"
                                        @selected(old('id_toko', $product->id_toko) == $item->id_toko)
                                    >
                                        {{ $item->nama_toko }}
                                    </option>
                                @endforeach
                            </select>

                            @error('id_toko')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- HARGA --}}
                        <div>
                            <label for="harga" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Harga (Rp) <span class="text-red-600">*</span>
                            </label>

                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga', $product->harga) }}"
                                placeholder="Contoh: 5000"
                                min="0"
                                step="1"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('harga') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-400">Masukkan harga dalam rupiah.</p>

                            @error('harga')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STOK --}}
                        <div>
                            <label for="stok" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Stok <span class="text-red-600">*</span>
                            </label>

                            <input
                                type="number"
                                id="stok"
                                name="stok"
                                value="{{ old('stok', $product->stok) }}"
                                placeholder="Contoh: 100"
                                min="0"
                                step="1"
                                required
                                class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('stok') ? 'border-red-400' : 'border-gray-300' }}"
                            >

                            @error('stok')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label for="status" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Status Produk <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-lg border bg-white px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('status') ? 'border-red-400' : 'border-gray-300' }}"
                            >
                                <option value="aktif" @selected(old('status', $product->status) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status', $product->status) === 'nonaktif')>Nonaktif</option>
                            </select>

                            @error('status')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Deskripsi Produk
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="5"
                                placeholder="Masukkan deskripsi produk..."
                                class="w-full resize-y rounded-lg border px-3 py-2.5 text-sm leading-6 outline-none transition focus:border-[#102A71] focus:ring-4 focus:ring-[#102A71]/10 {{ $errors->has('deskripsi') ? 'border-red-400' : 'border-gray-300' }}"
                            >{{ old('deskripsi', $product->deskripsi) }}</textarea>

                            @error('deskripsi')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- GAMBAR --}}
                        <div class="md:col-span-2">
                            <label for="gambar" class="mb-1.5 block text-xs font-semibold text-gray-700">
                                Gambar Produk
                            </label>

                            @if ($product->gambar)
                                <div class="mb-4">
                                    <img
                                        src="{{ asset('storage/' . $product->gambar) }}"
                                        alt="Gambar {{ $product->nama_produk }}"
                                        class="h-36 w-36 rounded-xl border border-gray-200 object-cover"
                                    >
                                    <p class="mt-1.5 text-[11px] text-gray-400">Gambar produk saat ini</p>
                                </div>
                            @endif

                            <input
                                type="file"
                                id="gambar"
                                name="gambar"
                                accept=".jpg,.jpeg,.png,.webp"
                                onchange="previewImage(event)"
                                class="w-full cursor-pointer rounded-lg border border-gray-300 p-2.5 text-sm file:mr-3 file:cursor-pointer file:rounded-md file:border-0 file:bg-[#eef2fb] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-[#102A71] hover:file:bg-[#dfe6f6]"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-400">
                                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                Jika tidak memilih gambar baru, gambar lama tetap digunakan.
                            </p>

                            @error('gambar')
                                <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror

                            <div id="imagePreview" class="mt-4 hidden">
                                <img
                                    id="preview"
                                    src=""
                                    alt="Preview gambar produk baru"
                                    class="h-36 w-36 rounded-xl border border-gray-200 object-cover"
                                >
                                <p class="mt-1.5 text-[11px] text-gray-400">Gambar baru yang akan digunakan</p>
                            </div>
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="mt-7 flex flex-col-reverse gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('admin.products.index') }}"
                            class="rounded-lg bg-gray-100 px-5 py-2.5 text-center text-xs font-semibold text-[#102A71] transition hover:bg-gray-200"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-[#102A71] px-5 py-2.5 text-xs font-bold text-white transition hover:bg-[#001840]"
                        >
                            Update Produk
                        </button>
                    </div>

                </form>
            </div>

        </section>

    </main>

    {{-- PREVIEW GAMBAR --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const container = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                container.classList.add('hidden');
            }
        }
    </script>

</body>
</html>