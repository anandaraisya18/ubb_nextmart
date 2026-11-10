@extends('superadmin.layouts.app')

@section('title', 'Group Operasional')

@section('content')

<div class="w-full min-w-0">

    <div class="space-y-6">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">

                    <span>
                        Manajemen Sistem
                    </span>

                    <span>›</span>

                    <span class="font-medium text-[#102A71]">
                        Group Operasional
                    </span>

                </div>

                <h1 class="text-[21px] font-bold text-[#001840]">
                    Group Operasional
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola group operasional dan toko yang tergabung di dalamnya.
                </p>

            </div>


            {{-- TAMBAH GROUP --}}

            <a
                href="{{ route('superadmin.group.create') }}"
                class="inline-flex shrink-0 items-center justify-center gap-2
                       rounded-lg bg-[#F5C400]
                       px-5 py-3
                       text-sm font-semibold text-[#001840]
                       shadow-sm
                       transition duration-200
                       hover:bg-[#e6b900]"
            >

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>

                Tambah Group

            </a>

        </div>


        {{-- =====================================================
             GROUP CARDS
        ====================================================== --}}

        <div class="grid w-full min-w-0 grid-cols-1 gap-5 xl:grid-cols-2">

            @forelse ($groups as $group)

                <div
                    class="min-w-0 overflow-hidden
                           rounded-2xl
                           border border-[#E2E8F0]
                           bg-white
                           shadow-sm
                           transition duration-200
                           hover:shadow-md"
                >

                    {{-- GROUP HEADER --}}

                    <div class="p-5 md:p-6">

                        <div class="flex min-w-0 items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div
                                        class="flex h-11 w-11 shrink-0
                                               items-center justify-center
                                               rounded-xl
                                               bg-[#102A71]
                                               text-[#F5C400]"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M3 7h18"/>
                                            <path d="M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"/>
                                            <rect
                                                x="3"
                                                y="7"
                                                width="18"
                                                height="14"
                                                rx="2"
                                            />
                                            <path d="M9 12h6"/>
                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <h2
                                            class="truncate
                                                   text-base
                                                   font-bold
                                                   text-[#001840]"
                                        >
                                            {{ $group->nama_group }}
                                        </h2>

                                        <p class="mt-0.5 text-xs text-gray-400">

                                            {{ $group->stores->count() }}

                                            {{ $group->stores->count() === 1 ? 'Toko' : 'Toko' }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- STATUS GROUP --}}

                            @if($group->status === 'aktif')

                                <span
                                    class="inline-flex shrink-0
                                           items-center gap-1.5
                                           rounded-full
                                           bg-green-50
                                           px-2.5 py-1
                                           text-[10px]
                                           font-semibold
                                           text-green-700"
                                >

                                    <span
                                        class="h-1.5 w-1.5
                                               rounded-full
                                               bg-green-500"
                                    ></span>

                                    Aktif

                                </span>

                            @else

                                <span
                                    class="inline-flex shrink-0
                                           items-center gap-1.5
                                           rounded-full
                                           bg-gray-100
                                           px-2.5 py-1
                                           text-[10px]
                                           font-semibold
                                           text-gray-500"
                                >

                                    <span
                                        class="h-1.5 w-1.5
                                               rounded-full
                                               bg-gray-400"
                                    ></span>

                                    Nonaktif

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         STORE LIST
                    ================================================== --}}

                    <div class="border-t border-[#E2E8F0] px-5 py-5 md:px-6">

                        <div class="mb-3 flex items-center justify-between gap-3">

                            <p
                                class="text-[11px]
                                       font-bold
                                       uppercase
                                       tracking-wider
                                       text-[#001840]"
                            >
                                Toko dalam Group
                            </p>

                            <span
                                class="rounded-full
                                       bg-[#F1F4FA]
                                       px-2.5 py-1
                                       text-[10px]
                                       font-semibold
                                       text-[#102A71]"
                            >
                                {{ $group->stores->count() }} Toko
                            </span>

                        </div>


                        <div class="space-y-2">

                            @forelse ($group->stores as $store)

                                <div
                                    class="flex min-w-0 items-center
                                           justify-between gap-3
                                           rounded-xl
                                           bg-[#F8FAFC]
                                           px-3 py-3
                                           transition
                                           hover:bg-[#F1F4FA]"
                                >

                                    <div class="min-w-0">

                                        <p
                                            class="truncate
                                                   text-sm
                                                   font-semibold
                                                   text-[#001840]"
                                        >
                                            {{ $store->nama_toko }}
                                        </p>

                                        <p
                                            class="mt-0.5
                                                   truncate
                                                   text-xs
                                                   text-gray-400"
                                        >
                                            {{ $store->alamat ?? 'Alamat belum diatur' }}
                                        </p>

                                    </div>

                                </div>

                            @empty

                                <div
                                    class="rounded-xl
                                           border border-yellow-100
                                           bg-yellow-50
                                           p-4"
                                >

                                    <div class="flex items-start gap-3">

                                        <svg
                                            class="mt-0.5 h-4 w-4
                                                   shrink-0
                                                   text-yellow-600"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M10.3 3.2 2.5 17a2 2 0 0 0 1.7 3h15.6a2 2 0 0 0 1.7-3L13.7 3.2a2 2 0 0 0-3.4 0Z"
                                            />
                                            <path d="M12 9v4"/>
                                            <path d="M12 17h.01"/>
                                        </svg>

                                        <p class="text-xs text-yellow-700">
                                            Group ini belum memiliki toko.
                                        </p>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- =================================================
                         FOOTER
                    ================================================== --}}

                    <div
                        class="flex items-center justify-between gap-3
                               border-t border-[#E2E8F0]
                               bg-[#FAFBFD]
                               px-5 py-4
                               md:px-6"
                    >

                        <span class="text-[10px] text-gray-400">
                            ID Group #{{ $group->id_group }}
                        </span>


                        <div class="flex items-center gap-3">

                            {{-- EDIT --}}

                            <a
                                href="{{ route('superadmin.group.edit', $group->id_group) }}"
                                class="inline-flex items-center gap-1.5
                                       text-xs font-semibold
                                       text-[#102A71]
                                       transition
                                       hover:text-[#001840]"
                            >

                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M12 20h9"/>
                                    <path
                                        d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1-1 1 1-4Z"
                                    />
                                </svg>

                                Edit

                            </a>


                            {{-- DELETE --}}

                            <form
                                method="POST"
                                action="{{ route('superadmin.group.destroy', $group->id_group) }}"
                                onsubmit="return confirm('Hapus group ini? Toko yang tergabung akan dilepas dari group. Lanjutkan?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-1.5
                                           text-xs font-semibold
                                           text-red-500
                                           transition
                                           hover:text-red-700"
                                >

                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4h8v2"/>
                                        <path d="M19 6l-1 14H6L5 6"/>
                                        <path d="M10 11v5"/>
                                        <path d="M14 11v5"/>
                                    </svg>

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty

                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div
                    class="xl:col-span-2
                           rounded-2xl
                           border border-[#E2E8F0]
                           bg-white
                           p-12
                           text-center"
                >

                    <div
                        class="mx-auto flex h-14 w-14
                               items-center justify-center
                               rounded-full
                               bg-[#EEF2FF]
                               text-[#102A71]"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold text-[#001840]">
                        Belum ada group operasional
                    </p>

                    <p class="mt-1 text-xs text-[#64748B]">
                        Tambahkan group untuk mulai mengelola toko.
                    </p>


                    <a
                        href="{{ route('superadmin.group.create') }}"
                        class="mt-5 inline-flex items-center gap-2
                               rounded-lg
                               bg-[#F5C400]
                               px-4 py-2.5
                               text-xs font-semibold
                               text-[#001840]
                               transition
                               hover:bg-[#e6b900]"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                        Tambah Group

                    </a>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection