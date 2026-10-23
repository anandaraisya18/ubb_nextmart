@extends('superadmin.layouts.app')

@section('title', 'Tambah Toko')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

{{-- HEADER --}}
<div>

    <a
        href="{{ route('superadmin.toko.index') }}"
        class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#102A71]"
    >
        <svg
            class="h-4 w-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path d="m15 18-6-6 6-6"/>
        </svg>

        Kembali ke Kelola Toko
    </a>

    <h1 class="mt-4 text-2xl font-bold text-[#001840]">
        Tambah Toko
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Tambahkan informasi toko baru dan tentukan group operasionalnya.
    </p>

</div>


{{-- FORM --}}
<form
    method="POST"
    action="{{ route('superadmin.toko.store') }}"
>

    @csrf

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        {{-- =====================================================
             INFORMASI TOKO
        ====================================================== --}}

        <div class="border-b border-gray-100 p-6 md:p-8">

            <div class="mb-6">

                <h2 class="font-semibold text-[#001840]">
                    Informasi Toko
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Masukkan informasi dasar toko yang akan dikelola.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- NAMA TOKO --}}
                <div class="md:col-span-2">

                    <label
                        for="nama_toko"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Nama Toko
                    </label>

                    <input
                        id="nama_toko"
                        type="text"
                        name="nama_toko"
                        value="{{ old('nama_toko') }}"
                        required
                        placeholder="Contoh: UBB Mart"
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                    @error('nama_toko')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- GROUP OPERASIONAL --}}
                <div class="md:col-span-2">

                    <label
                        for="id_group"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Group Operasional
                    </label>

                    <select
                        id="id_group"
                        name="id_group"
                        required
                        class="w-full rounded-xl border border-gray-200
                               bg-white px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                        <option value="">
                            Pilih Group Operasional
                        </option>

                        @foreach ($groups ?? [] as $group)

                            <option
                                value="{{ $group->id_group }}"
                                @selected(old('id_group') == $group->id_group)
                            >
                                {{ $group->nama_group }}
                            </option>

                        @endforeach

                    </select>

                    @error('id_group')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                    @if(empty($groups) || count($groups) === 0)

                        <p class="mt-2 text-xs text-amber-600">
                            Belum ada group operasional. Buat group terlebih dahulu.
                        </p>

                    @endif

                </div>


                {{-- DESKRIPSI --}}
                <div class="md:col-span-2">

                    <label
                        for="deskripsi"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Deskripsi Toko
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        placeholder="Jelaskan secara singkat mengenai toko..."
                        class="w-full resize-none rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ALAMAT --}}
                <div class="md:col-span-2">

                    <label
                        for="alamat"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Alamat Toko
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        placeholder="Masukkan alamat lengkap toko"
                        class="w-full resize-none rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NOMOR TELEPON --}}
                <div>

                    <label
                        for="nomor_telepon"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Nomor Telepon
                    </label>

                    <input
                        id="nomor_telepon"
                        type="text"
                        name="nomor_telepon"
                        value="{{ old('nomor_telepon') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                    @error('nomor_telepon')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- JAM OPERASIONAL --}}
                <div>

                    <label
                        for="jam_operasional"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Jam Operasional
                    </label>

                    <input
                        id="jam_operasional"
                        type="text"
                        name="jam_operasional"
                        value="{{ old('jam_operasional') }}"
                        placeholder="07.00 - 17.00"
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                    @error('jam_operasional')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             MEDIA SOSIAL
        ====================================================== --}}

        <div class="border-b border-gray-100 p-6 md:p-8">

            <div class="mb-6">

                <h2 class="font-semibold text-[#001840]">
                    Media Sosial
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Tambahkan tautan media sosial toko jika tersedia.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- INSTAGRAM --}}
                <div>

                    <label
                        for="link_instagram"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Link Instagram
                    </label>

                    <input
                        id="link_instagram"
                        type="url"
                        name="link_instagram"
                        value="{{ old('link_instagram') }}"
                        placeholder="https://instagram.com/..."
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                    @error('link_instagram')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TIKTOK --}}
                <div>

                    <label
                        for="link_tiktok"
                        class="mb-2 block text-sm font-semibold text-[#001840]"
                    >
                        Link TikTok
                    </label>

                    <input
                        id="link_tiktok"
                        type="url"
                        name="link_tiktok"
                        value="{{ old('link_tiktok') }}"
                        placeholder="https://tiktok.com/@..."
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3 text-sm outline-none
                               transition
                               focus:border-[#F5C400]
                               focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                    @error('link_tiktok')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div
            class="flex flex-col-reverse gap-3 border-t border-gray-100
                   bg-gray-50 p-5 sm:flex-row sm:justify-end"
        >

            <a
                href="{{ route('superadmin.toko.index') }}"
                class="rounded-xl border border-gray-200 bg-white
                       px-5 py-3 text-center text-sm font-semibold
                       text-gray-600 transition hover:bg-gray-100"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-xl bg-[#F5C400]
                       px-5 py-3 text-sm font-semibold
                       text-[#001840]
                       transition hover:bg-[#e6b900]"
            >
                Simpan Toko
            </button>

        </div>

    </div>

</form>

</div>

@endsection
