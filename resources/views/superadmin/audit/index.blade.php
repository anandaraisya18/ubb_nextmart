@extends('superadmin.layouts.app')

@section('title', 'Audit Log')

@section('content')

<div class="w-full min-w-0">
    <div class="space-y-6">

    {{-- HEADER --}}
    <div class="min-w-0">
        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">
            <span>Manajemen Sistem</span>
            <span>›</span>
            <span class="font-medium text-[#102A71]">Audit Log</span>
        </div>

        <h1 class="text-[21px] font-bold text-[#001840]">Audit Log</h1>

        <p class="mt-1 text-sm text-gray-500">
            Pantau seluruh aktivitas yang terjadi pada sistem.
        </p>
    </div>

    {{-- FILTER --}}
    <div class="w-full overflow-hidden rounded-[13px] border border-[#E2E8F0] bg-white">
        <div class="border-b border-[#E2E8F0] px-5 py-4">
            <div class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EEF2FF] text-[#102A71]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 5h16"/>
                        <path d="M7 12h10"/>
                        <path d="M10 19h4"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-[#001840]">Filter Aktivitas</h2>
                    <p class="text-xs text-gray-400">Gunakan filter untuk menemukan aktivitas tertentu.</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('superadmin.audit.index') }}" class="p-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

                {{-- AKTOR --}}
                <div>
                    <label for="actor" class="mb-2 block text-xs font-semibold text-[#001840]">
                        Aktor
                    </label>

                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                        </svg>

                        <input
                            id="actor"
                            type="text"
                            name="actor"
                            value="{{ request('actor') }}"
                            maxlength="100"
                            placeholder="Nama admin..."
                            class="w-full rounded-lg border border-[#E2E8F0] bg-white py-2.5 pl-10 pr-4 text-sm text-[#1E293B] outline-none transition placeholder:text-gray-400 focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10"
                        >
                    </div>
                </div>

                {{-- AKTIVITAS --}}
                <div>
                    <label for="action" class="mb-2 block text-xs font-semibold text-[#001840]">
                        Aktivitas
                    </label>

                    <select
                        id="action"
                        name="action"
                        class="w-full rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm text-[#1E293B] outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10"
                    >
                        <option value="">Semua Aktivitas</option>
                        <option value="create" @selected(request('action') === 'create')>Menambah</option>
                        <option value="update" @selected(request('action') === 'update')>Mengubah</option>
                        <option value="delete" @selected(request('action') === 'delete')>Menghapus</option>
                        <option value="access" @selected(request('action') === 'access')>Akses</option>
                        <option value="login" @selected(request('action') === 'login')>Login</option>
                        <option value="logout" @selected(request('action') === 'logout')>Logout</option>
                    </select>
                </div>

                {{-- DARI TANGGAL --}}
                <div>
                    <label for="from" class="mb-2 block text-xs font-semibold text-[#001840]">
                        Dari Tanggal
                    </label>

                    <input
                        id="from"
                        type="date"
                        name="from"
                        value="{{ request('from') }}"
                        max="{{ request('to') ?: now()->format('Y-m-d') }}"
                        class="w-full rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm text-[#1E293B] outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10"
                    >
                </div>

                {{-- SAMPAI TANGGAL --}}
                <div>
                    <label for="to" class="mb-2 block text-xs font-semibold text-[#001840]">
                        Sampai Tanggal
                    </label>

                    <input
                        id="to"
                        type="date"
                        name="to"
                        value="{{ request('to') }}"
                        min="{{ request('from') }}"
                        max="{{ now()->format('Y-m-d') }}"
                        class="w-full rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm text-[#1E293B] outline-none transition focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10"
                    >
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-[#102A71] bg-[#102A71] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#001840]"
                >
                    Terapkan Filter
                </button>

                <a
                    href="{{ route('superadmin.audit.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm font-semibold text-[#475569] transition hover:bg-gray-50"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- RIWAYAT AKTIVITAS --}}
    <div class="w-full min-w-0 overflow-hidden rounded-[13px] border border-[#E2E8F0] bg-white">

        <div class="flex flex-col gap-3 border-b border-[#E2E8F0] p-5 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-[16px] font-semibold text-[#001840]">Riwayat Aktivitas</h2>
                <p class="mt-1 text-xs text-[#64748B]">
                    Seluruh aktivitas admin dan sistem yang tercatat.
                </p>
            </div>

            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-[#EEF2FF] px-3 py-1.5 text-[11px] font-semibold text-[#102A71]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#102A71]"></span>
                Monitoring
            </span>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-[900px] text-left">
                <thead class="bg-[#001840]">
                    <tr class="text-[11px] uppercase tracking-wider text-white">
                        <th class="px-6 py-4 font-semibold">Waktu</th>
                        <th class="px-6 py-4 font-semibold">Aktor</th>
                        <th class="px-6 py-4 font-semibold">Aktivitas</th>
                        <th class="px-6 py-4 font-semibold">Target</th>
                        <th class="px-6 py-4 font-semibold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2E8F0]">
                    @forelse ($logs as $log)
                        <tr class="transition duration-150 hover:bg-[#F8FAFC]">

                            {{-- WAKTU --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F1F4FA] text-[#102A71]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>
                                    </div>

                                    <span class="whitespace-nowrap text-xs text-[#64748B]">
                                        {{ $log->created_at?->format('d M Y H:i:s') ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            {{-- AKTOR --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#102A71] text-xs font-bold text-white">
                                        {{ strtoupper(substr($log->actor_name ?: 'S', 0, 1)) }}
                                    </div>

                                    <div>
                                        <span class="block text-sm font-semibold text-[#001840]">
                                            {{ $log->actor_name ?: 'Sistem' }}
                                        </span>

                                        <span class="text-[11px] text-gray-400">
                                            {{ $log->actor_type ?: 'unknown' }}
                                            @if($log->actor_id)
                                                · ID {{ $log->actor_id }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- AKTIVITAS --}}
                            <td class="px-6 py-4">
                                @php
                                    $actionLabels = [
                                        'create' => 'Menambah',
                                        'update' => 'Mengubah',
                                        'delete' => 'Menghapus',
                                        'access' => 'Akses',
                                        'login' => 'Login',
                                        'logout' => 'Logout',
                                    ];

                                    $actionColors = [
                                        'create' => 'bg-green-50 text-green-700',
                                        'update' => 'bg-yellow-50 text-yellow-700',
                                        'delete' => 'bg-red-50 text-red-600',
                                        'access' => 'bg-[#EEF2FF] text-[#102A71]',
                                        'login' => 'bg-blue-50 text-blue-700',
                                        'logout' => 'bg-gray-100 text-gray-700',
                                    ];

                                    $actionKey = strtolower($log->action ?? '');
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-semibold {{ $actionColors[$actionKey] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $actionLabels[$actionKey] ?? ucfirst($log->action ?? 'Lainnya') }}
                                </span>

                                @if(($log->status ?? '') === 'failed')
                                    <span class="mt-1 inline-flex rounded-full bg-red-50 px-2 py-1 text-[10px] font-semibold text-red-600">
                                        Gagal
                                    </span>
                                @elseif(($log->status ?? '') === 'success')
                                    <span class="mt-1 inline-flex rounded-full bg-green-50 px-2 py-1 text-[10px] font-semibold text-green-700">
                                        Berhasil
                                    </span>
                                @endif
                            </td>

                            {{-- TARGET --}}
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-[#475569]">
                                    {{ $log->target_type ?: '-' }}
                                    @if($log->target_id)
                                        #{{ $log->target_id }}
                                    @endif
                                </span>
                            </td>

                            {{-- KETERANGAN --}}
                            <td class="px-6 py-4">
                                <div class="max-w-[320px]">
                                    <p class="text-xs leading-relaxed text-[#64748B]">
                                        {{ $log->description }}
                                    </p>

                                    @if($log->ip_address)
                                        <p class="mt-1 text-[10px] text-gray-400">
                                            IP: {{ $log->ip_address }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EEF2FF] text-[#102A71]">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                                <p class="mt-4 text-sm font-semibold text-[#001840]">
                                    Belum ada aktivitas
                                </p>

                                <p class="mt-1 text-xs text-[#64748B]">
                                    Belum terdapat aktivitas yang sesuai dengan filter.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($logs->hasPages() || $logs->total() > 0)
            <div class="flex flex-col gap-3 border-t border-[#E2E8F0] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-[#64748B]">
                    Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}
                    dari {{ $logs->total() }} aktivitas
                </p>

                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif

    </div>
</div>

</div>

@endsection
