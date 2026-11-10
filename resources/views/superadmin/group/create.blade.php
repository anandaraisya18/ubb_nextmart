@extends('superadmin.layouts.app')

@section('title', 'Tambah Group')

@section('content')

<div class="w-full min-w-0">

<div class="max-w-4xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div>

        <a
            href="{{ route('superadmin.group.index') }}"
            class="inline-flex items-center text-sm font-medium text-[#102A71] transition hover:text-[#F5C400]"
        >
            ← Kembali ke Group Operasional
        </a>

        <h1 class="mt-4 text-2xl font-bold text-[#001840]">
            Tambah Group Operasional
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Buat group operasional baru untuk mengelompokkan beberapa toko.
        </p>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('superadmin.group.store') }}"
        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
    >

        @csrf

        <div class="space-y-6">

            {{-- NAMA GROUP --}}
            <div>

                <label
                    for="nama_group"
                    class="mb-2 block text-sm font-semibold text-[#001840]"
                >
                    Nama Group
                </label>

                <input
                    id="nama_group"
                    type="text"
                    name="nama_group"
                    value="{{ old('nama_group') }}"
                    placeholder="Contoh: Group Operasional Pangkalpinang"
                    required
                    maxlength="100"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3
                           text-sm text-gray-700 outline-none
                           transition
                           focus:border-[#F5C400]
                           focus:ring-2 focus:ring-[#F5C400]/20"
                >

                @error('nama_group')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- STATUS --}}
            <div>

                <label
                    for="status"
                    class="mb-2 block text-sm font-semibold text-[#001840]"
                >
                    Status Group
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="w-full rounded-xl border border-gray-200 px-4 py-3
                           text-sm text-gray-700 outline-none
                           transition
                           focus:border-[#F5C400]
                           focus:ring-2 focus:ring-[#F5C400]/20"
                >

                    <option
                        value="aktif"
                        @selected(old('status', 'aktif') === 'aktif')
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        @selected(old('status') === 'nonaktif')
                    >
                        Nonaktif
                    </option>

                </select>

                @error('status')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- INFO --}}
            <div
                class="rounded-xl border border-blue-100 bg-blue-50 p-4"
            >

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0 text-[#102A71]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 11v5"/>
                        <path d="M12 8h.01"/>
                    </svg>

                    <div>

                        <p class="text-sm font-semibold text-[#102A71]">
                            Pengelompokan Toko
                        </p>

                        <p class="mt-1 text-xs leading-relaxed text-blue-700">
                            Setelah group dibuat, toko dapat dimasukkan ke
                            group melalui pengelolaan toko. Satu toko hanya
                            memiliki satu group operasional.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="mt-8 flex justify-end gap-3">

            <a
                href="{{ route('superadmin.group.index') }}"
                class="rounded-xl border border-gray-200 px-5 py-2.5
                       text-sm font-semibold text-gray-600
                       transition hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-xl bg-[#F5C400] px-5 py-2.5
                       text-sm font-semibold text-[#001840]
                       transition hover:bg-[#102A71]
                       hover:text-[#F5C400]"
            >
                Simpan Group
            </button>

        </div>

    </form>

</div>

</div>

@endsection
