<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-[250px]">

        @include('admin.components.topbar', [
            'title' => 'Edit Kategori',
            'subtitle' => 'Perbarui data kategori produk'
        ])

        <section class="p-5 md:p-7 lg:p-8">

            <div class="max-w-xl overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <div class="border-b border-gray-200 p-5">
                    <h3 class="text-base font-bold text-[#001840] md:text-lg">Form Edit Kategori</h3>
                    <p class="mt-1 text-[11px] text-gray-500">Ubah nama kategori lalu simpan.</p>
                </div>

                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-5">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="nama_kategori" class="mb-1.5 block text-xs font-semibold text-gray-700">
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            id="nama_kategori"
                            name="nama_kategori"
                            value="{{ old('nama_kategori', $category->nama_kategori) }}"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm outline-none transition focus:border-[#102A71] {{ $errors->has('nama_kategori') ? 'border-red-400' : 'border-gray-300' }}"
                        >

                        @error('nama_kategori')
                            <p class="mt-1.5 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            type="submit"
                            class="rounded-lg bg-[#F5C400] px-4 py-2.5 text-xs font-bold text-[#001840] transition hover:-translate-y-0.5 hover:bg-[#ffd21a]"
                        >
                            Perbarui
                        </button>

                        <a
                            href="{{ route('admin.categories.index') }}"
                            class="rounded-lg bg-gray-100 px-4 py-2.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-200"
                        >
                            Batal
                        </a>
                    </div>
                </form>

            </div>

        </section>

    </main>

</body>

</html>