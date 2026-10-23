@extends('superadmin.layouts.app')

@section('title', 'Edit Group')

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
            Edit Group Operasional
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Ubah informasi dan status group operasional.
        </p>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('superadmin.group.update', $group->id_group) }}"
        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
    >

        @csrf
        @method('PUT')


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
                    value="{{ old('nama_group', $group->nama_group) }}"
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
                        @selected(old('status', $group->status) === 'aktif')
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        @selected(old('status', $group->status) === 'nonaktif')
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


            {{-- INFO GROUP --}}
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
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path d="M12 11v5"/>

                        <path d="M12 8h.01"/>

                    </svg>


                    <div>

                        <p class="text-sm font-semibold text-[#102A71]">
                            Informasi Group
                        </p>

                        <p class="mt-1 text-xs leading-relaxed text-blue-700">
                            Group ini digunakan untuk mengelompokkan toko
                            dalam sistem. Pengaturan toko yang tergabung
                            dalam group dilakukan melalui menu Kelola Toko.
                        </p>

                    </div>

                </div>

            </div>


            {{-- GROUP ID --}}
            <div
                class="rounded-xl border border-gray-100 bg-[#F8FAFC] px-4 py-3"
            >

                <div class="flex items-center justify-between gap-4">

                    <span class="text-xs text-gray-500">
                        ID Group
                    </span>

                    <span class="text-sm font-semibold text-[#001840]">
                        #{{ $group->id_group }}
                    </span>

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
                       transition
                       hover:bg-[#102A71]
                       hover:text-[#F5C400]"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

</div>

@endsection
