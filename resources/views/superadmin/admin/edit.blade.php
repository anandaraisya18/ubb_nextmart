@extends('superadmin.layouts.app')

@section('title', 'Edit Admin')

@section('content')

<div class="mx-auto w-full max-w-4xl space-y-6">

    {{-- HEADER --}}
    <div>

        <a
            href="{{ route('superadmin.admin.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 transition hover:text-[#102A71]"
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

            Kembali ke Kelola Admin
        </a>

        <h1 class="mt-4 text-2xl font-bold text-[#001840]">
            Edit Admin
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Perbarui informasi akun dan group operasional admin.
        </p>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('superadmin.admin.update', $admin->id_admin) }}"
    >

        @csrf
        @method('PUT')

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

            {{-- INFORMASI AKUN --}}
            <div class="border-b border-gray-100 p-6 md:p-8">

                <div class="mb-6">
                    <h2 class="font-semibold text-[#001840]">
                        Informasi Akun
                    </h2>

                    <p class="mt-1 text-xs text-gray-400">
                        Ubah informasi dasar akun admin.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- NAMA --}}
                    <div>
                        <label
                            for="nama"
                            class="mb-2 block text-sm font-semibold text-[#001840]"
                        >
                            Nama Admin
                        </label>

                        <input
                            id="nama"
                            type="text"
                            name="nama"
                            value="{{ old('nama', $admin->nama) }}"
                            required
                            maxlength="255"
                            placeholder="Contoh: Andi Pratama"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                        >

                        @error('nama')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- EMAIL --}}
                    <div>
                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-[#001840]"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $admin->email) }}"
                            required
                            maxlength="255"
                            placeholder="admin@example.com"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                        >

                        @error('email')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- PASSWORD BARU --}}
                    <div>
                        <label
                            for="password"
                            class="mb-2 block text-sm font-semibold text-[#001840]"
                        >
                            Password Baru
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Kosongkan jika tidak diubah"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                        >

                        @error('password')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-1 text-xs text-gray-400">
                            Minimal 8 karakter jika ingin mengganti password.
                        </p>
                    </div>


                    {{-- KONFIRMASI PASSWORD --}}
                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-semibold text-[#001840]"
                        >
                            Konfirmasi Password
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Ulangi password baru"
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                        >
                    </div>

                </div>

            </div>


            {{-- AKSES OPERASIONAL --}}
            <div class="p-6 md:p-8">

                <div class="mb-6">
                    <h2 class="font-semibold text-[#001840]">
                        Akses Operasional
                    </h2>

                    <p class="mt-1 text-xs leading-relaxed text-gray-400">
                        Pilih satu group operasional. Admin akan memiliki cakupan akses ke seluruh toko dalam group tersebut.
                    </p>
                </div>


                {{-- GROUP OPERASIONAL --}}
                <div>

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
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-[#F5C400] focus:ring-2 focus:ring-[#F5C400]/20"
                    >

                        <option value="">
                            Pilih Group Operasional
                        </option>

                        @forelse ($groups ?? [] as $group)

                            <option
                                value="{{ $group->id_group }}"
                                @selected(
                                    (string) old('id_group', $admin->id_group)
                                    === (string) $group->id_group
                                )
                            >
                                {{ $group->nama_group }}
                            </option>

                        @empty

                            <option value="" disabled>
                                Belum ada group operasional
                            </option>

                        @endforelse

                    </select>

                    @error('id_group')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-2 text-xs text-gray-400">
                        Seluruh toko dalam group terpilih menjadi cakupan operasional admin, termasuk toko yang ditambahkan ke group tersebut di kemudian hari.
                    </p>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 p-5 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('superadmin.admin.index') }}"
                    class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-100"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-[#F5C400] px-5 py-3 text-sm font-semibold text-[#001840] shadow-sm transition hover:bg-[#e6b900]"
                >
                    Simpan Perubahan
                </button>

            </div>

        </div>

    </form>

</div>

@endsection
