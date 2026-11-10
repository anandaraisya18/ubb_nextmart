@extends('superadmin.layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="w-full min-w-0">
    <div class="space-y-7">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="min-w-0">
                <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">
                    <span>Manajemen Sistem</span>
                    <span>›</span>
                    <span class="font-medium text-[#102A71]">Kelola Akun Admin</span>
                </div>

                <h1 class="text-[21px] font-bold text-[#001840]">
                    Kelola Admin
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola akun admin dan hak akses terhadap group toko.
                </p>
            </div>
            

            <a href="{{ route('superadmin.admin.create') }}"
               class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#F5C400] px-5 py-3 text-sm font-semibold text-[#001840] shadow-sm transition hover:bg-[#e6b900]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                Tambah Admin
            </a>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-[13px] border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-[47px] w-[47px] shrink-0 items-center justify-center rounded-[11px] bg-[#EEF2FF] text-[#102A71]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-[#64748B]">Total Admin</p>
                        <p class="mt-1 text-[23px] font-bold text-[#001840]">
                            {{ $admins->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-[13px] border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center gap-4">
                    <div class="flex h-[47px] w-[47px] shrink-0 items-center justify-center rounded-[11px] bg-[#EEF2FF] text-[#102A71]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-[#64748B]">Group Terdaftar</p>
                        <p class="mt-1 text-[23px] font-bold text-[#001840]">
                            {{ $admins->pluck('id_group')->filter()->unique()->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- DAFTAR ADMIN --}}
        <div class="w-full min-w-0 overflow-hidden rounded-[13px] border border-[#E2E8F0] bg-white">

            <div class="flex flex-col gap-4 border-b border-[#E2E8F0] p-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-[16px] font-semibold text-[#001840]">
                        Daftar Admin
                    </h2>
                    <p class="mt-1 text-xs text-[#64748B]">
                        Daftar akun dan group operasional yang dikelola.
                    </p>
                </div>

                <div class="relative w-full md:w-72">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                         fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>

                    <input
                        id="searchAdmin"
                        type="text"
                        placeholder="Cari nama, email, atau group..."
                        class="w-full rounded-lg border border-[#E2E8F0] bg-white py-2.5 pl-10 pr-4 text-sm text-[#1E293B] outline-none transition placeholder:text-gray-400 focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10"
                    >
                </div>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead class="bg-[#001840]">
                        <tr class="text-[11px] uppercase tracking-wider text-white">
                            <th class="px-6 py-4 font-semibold">Admin</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Group</th>
                            <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="adminTableBody" class="divide-y divide-[#E2E8F0]">
                        @forelse ($admins as $admin)
                            <tr class="admin-row transition duration-150 hover:bg-[#F5F7FC]">

                                {{-- NAMA ADMIN --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#102A71] text-sm font-bold text-white">
                                            {{ strtoupper(substr($admin->nama ?? 'A', 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p class="admin-search-name max-w-[220px] truncate text-sm font-semibold text-[#001840]">
                                                {{ $admin->nama }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-[#64748B]">
                                                ID Admin: {{ $admin->id_admin }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- EMAIL --}}
                                <td class="admin-search-email px-6 py-4 text-sm text-[#475569]">
                                    {{ $admin->email }}
                                </td>

                                {{-- GROUP --}}
                                <td class="admin-search-group px-6 py-4">
                                    @if ($admin->group)
                                        <span class="inline-flex rounded-md bg-[#102A71]/10 px-2.5 py-1 text-[11px] font-medium text-[#102A71]">
                                            {{ $admin->group->nama_group }}
                                        </span>
                                    @else
                                        <span class="text-xs text-[#94A3B8]">
                                            Belum ada group
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('superadmin.admin.edit', $admin->id_admin) }}"
                                        title="Edit Admin"
                                        aria-label="Edit Admin"
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 transition hover:bg-[#F5C400] hover:text-[#001840]">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                            </svg>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('superadmin.admin.destroy', $admin->id_admin) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus admin {{ addslashes($admin->nama) }}? Tindakan ini tidak dapat dibatalkan.')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus Admin"
                                                aria-label="Hapus Admin"
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M3 6h18"/>
                                                    <path d="M8 6V4h8v2"/>
                                                    <path d="m19 6-1 14H6L5 6"/>
                                                    <path d="M10 11v5"/>
                                                    <path d="M14 11v5"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EEF2FF] text-[#102A71]">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor"
                                             stroke-width="1.8" viewBox="0 0 24 24">
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M2 21a7 7 0 0 1 14 0"/>
                                            <path d="M19 8v6"/>
                                            <path d="M16 11h6"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 text-sm font-semibold text-[#001840]">
                                        Belum ada admin
                                    </p>
                                    <p class="mt-1 text-xs text-[#64748B]">
                                        Tambahkan akun admin untuk mulai mengelola sistem.
                                    </p>

                                    <a href="{{ route('superadmin.admin.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#F5C400] px-4 py-2 text-xs font-semibold text-[#001840] transition hover:bg-[#e6b900]">
                                        Tambah Admin
                                    </a>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="noSearchResult" class="hidden">
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-[#64748B]">
                                Admin tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- PENCARIAN ADMIN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchAdmin');
    const rows = document.querySelectorAll('.admin-row');
    const noResult = document.getElementById('noSearchResult');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            const match = text.includes(keyword);

            row.style.display = match ? '' : 'none';

            if (match) visibleCount++;
        });

        if (noResult) {
            noResult.classList.toggle(
                'hidden',
                visibleCount > 0 || keyword === ''
            );
        }
    });
});
</script>
@endsection
