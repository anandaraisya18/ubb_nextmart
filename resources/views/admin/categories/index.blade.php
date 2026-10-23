<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Kategori | UBB Nexmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    {{-- SIDEBAR --}}
    @include('admin.components.sidebar')

    {{-- MAIN --}}
    <main class="min-h-screen lg:ml-[250px]">

        {{-- TOPBAR --}}
        @include('admin.components.topbar', [
            'title' => 'Kelola Kategori',
            'subtitle' => 'Kelola kategori produk UBB Nexmart'
        ])

        {{-- CONTENT --}}
        <section class="p-5 md:p-7 lg:p-8">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif


            {{-- PAGE BANNER --}}
            <div class="relative mb-7 overflow-hidden rounded-2xl bg-gradient-to-br from-[#001840] to-[#102A71] p-6 md:p-7 lg:p-8">

                {{-- Decorative circle --}}
                <div class="absolute -right-12 -top-16 h-44 w-44 rounded-full border-[25px] border-[#F5C400]/15"></div>

                <div class="relative z-10 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-xl font-bold text-white md:text-2xl">
                            Kelola Kategori
                        </h2>

                        <p class="mt-2 max-w-xl text-xs leading-5 text-white/80 md:text-sm">
                            Tambahkan, perbarui, atau hapus kategori produk yang tersedia di UBB Nexmart.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#F5C400] px-4 py-3 text-xs font-bold text-[#001840] transition hover:-translate-y-0.5 hover:bg-[#ffd21a]"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>

                        Tambah Kategori
                    </a>

                </div>
            </div>


            {{-- STATISTICS --}}
            <div class="mb-7 grid grid-cols-1 gap-4">

                <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg">

                    <div>
                        <p class="mb-1.5 text-xs text-gray-500">
                            Total Kategori
                        </p>

                        <h3 class="text-2xl font-bold text-[#001840]">
                            {{ $totalKategori }}
                        </h3>

                        <span class="mt-1 block text-[10px] text-gray-500">
                            Kategori terdaftar
                        </span>
                    </div>
                </div>
            </div>


            {{-- CATEGORY PANEL --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                {{-- PANEL HEADER --}}
                <div class="flex flex-col gap-3 border-b border-gray-200 p-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-base font-bold text-[#001840] md:text-lg">
                            Daftar Kategori
                        </h3>

                        <p class="mt-1 text-[11px] text-gray-500">
                            Semua kategori yang terdaftar pada sistem.
                        </p>
                    </div>

                    <div class="w-fit rounded-full bg-[#001840] px-3 py-1.5 text-[11px] font-semibold text-white">
                        <span class="text-[#F5C400]">
                            {{ $totalKategori }}
                        </span>
                        Kategori
                    </div>

                </div>


                {{-- EMPTY STATE --}}
                @if($totalKategori === 0)

                    <div class="px-5 py-16 text-center">

                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#eef2fb] text-[#102A71]">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>

                        <h3 class="mb-1.5 text-base font-bold text-[#001840]">
                            Belum Ada Kategori
                        </h3>

                        <p class="mb-5 text-xs text-gray-500">
                            Belum ada kategori produk yang terdaftar pada sistem.
                        </p>

                        <a
                            href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#F5C400] px-4 py-2.5 text-xs font-bold text-[#001840] transition hover:-translate-y-0.5 hover:bg-[#ffd21a]"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                            </svg>

                            Tambah Kategori
                        </a>

                    </div>


                {{-- CATEGORY LIST --}}
                @else

                    {{-- DESKTOP TABLE --}}
                    <div class="hidden overflow-x-auto md:block">

                        <table class="w-full border-collapse">

                            <thead>
                                <tr class="bg-[#fafbfe]">
                                    <th class="whitespace-nowrap border-b border-gray-200 px-5 py-3 text-left text-[11px] font-semibold text-gray-500">
                                        Kategori
                                    </th>
                                    <th class="whitespace-nowrap border-b border-gray-200 px-5 py-3 text-left text-[11px] font-semibold text-gray-500">
                                        Jumlah Produk
                                    </th>
                                    <th class="whitespace-nowrap border-b border-gray-200 px-5 py-3 text-left text-[11px] font-semibold text-gray-500">
                                        Status
                                    </th>
                                    <th class="border-b border-gray-200 px-5 py-3 text-right text-[11px] font-semibold text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($categories as $category)

                                    <tr class="transition hover:bg-gray-50">

                                        {{-- CATEGORY --}}
                                        <td class="border-b border-gray-100 px-5 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef2fb] text-[#102A71]">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>

                                                <div>
                                                    <strong class="block text-[13px] font-bold text-[#001840]">
                                                        {{ $category->nama_kategori }}
                                                    </strong>

                                                    <span class="mt-0.5 block max-w-xs truncate text-[10px] text-gray-500">
                                                        {{ $category->deskripsi ?: 'Kategori produk' }}
                                                    </span>
                                                </div>

                                            </div>

                                        </td>


                                        {{-- PRODUCT COUNT --}}
                                        <td class="border-b border-gray-100 px-5 py-4">
                                            <span class="text-xs font-semibold text-gray-700">
                                                {{ $category->produk_count }} Produk
                                            </span>
                                        </td>


                                        {{-- STATUS --}}
                                        <td class="border-b border-gray-100 px-5 py-4">
                                            <span class="inline-block rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700">
                                                Aktif
                                            </span>
                                        </td>


                                        {{-- ACTION --}}
                                        <td class="border-b border-gray-100 px-5 py-4">

                                            <div class="flex items-center justify-end gap-2">

                                                <a
                                                    href="{{ route('admin.categories.edit', $category) }}"
                                                    title="Edit Kategori"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-yellow-50 text-[#967500] transition hover:bg-[#F5C400] hover:text-[#001840]"
                                                >
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                    </svg>
                                                </a>

                                                <form
                                                    action="{{ route('admin.categories.destroy', $category) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        title="Hapus Kategori"
                                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-500 hover:text-white"
                                                    >
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3 6h18"/>
                                                            <path d="M8 6V4h8v2"/>
                                                            <path d="M19 6l-1 14H6L5 6"/>
                                                            <path d="M10 11v5M14 11v5"/>
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- MOBILE CARDS --}}
                    <div class="block md:hidden">

                        @foreach($categories as $category)

                            <div class="border-b border-gray-100 p-5 last:border-b-0">

                                <div class="flex gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef2fb] text-[#102A71]">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <strong class="block text-sm font-bold text-[#001840]">
                                            {{ $category->nama_kategori }}
                                        </strong>

                                        @if($category->deskripsi)
                                            <span class="mt-1 block truncate text-[11px] text-gray-500">
                                                {{ $category->deskripsi }}
                                            </span>
                                        @endif

                                        <span class="mt-1 block text-[11px] text-gray-500">
                                            {{ $category->produk_count }} Produk
                                        </span>

                                        <div class="mt-2">
                                            <span class="inline-block rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700">
                                                Aktif
                                            </span>
                                        </div>

                                    </div>

                                </div>


                                {{-- MOBILE ACTION --}}
                                <div class="mt-4 grid grid-cols-2 gap-2">

                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="flex h-9 items-center justify-center gap-1.5 rounded-lg bg-yellow-50 text-[11px] font-semibold text-[#967500] transition hover:bg-[#F5C400] hover:text-[#001840]"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="flex h-9 w-full items-center justify-center gap-1.5 rounded-lg bg-red-50 text-[11px] font-semibold text-red-600 transition hover:bg-red-500 hover:text-white"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>