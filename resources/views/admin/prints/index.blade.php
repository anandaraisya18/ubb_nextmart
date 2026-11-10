@extends('admin.layouts.app')

@section('title', 'Antrian Cetak')

@section('content')

@php
    $badge = [
        'menunggu'  => 'bg-amber-50 text-amber-700',
        'disetujui' => 'bg-green-50 text-green-700',
        'ditolak'   => 'bg-red-50 text-red-600',
    ];
@endphp

<div class="w-full min-w-0">
<div class="space-y-7">

    {{-- HEADER --}}
    <div class="min-w-0">

        <div class="mb-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">
            <span>Operasional</span>
            <span>›</span>
            <span class="font-medium text-[#102A71]">Antrian Cetak</span>
        </div>

        <h1 class="text-[21px] font-bold text-[#001840]">
            Antrian Cetak
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Cek file dari pelanggan, lalu setujui atau tolak sebelum dicetak.
        </p>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <a href="{{ route('admin.prints.index', ['status' => 'menunggu_verifikasi']) }}"
           class="rounded-[13px] border border-[#E2E8F0] bg-white p-5 transition hover:border-amber-300">
            <p class="text-xs text-[#64748B]">Menunggu Verifikasi</p>
            <p class="mt-1 text-[23px] font-bold text-amber-600">{{ $summary['menunggu_verifikasi'] }}</p>
        </a>

        <a href="{{ route('admin.prints.index', ['status' => 'selesai']) }}"
           class="rounded-[13px] border border-[#E2E8F0] bg-white p-5 transition hover:border-green-300">
            <p class="text-xs text-[#64748B]">Selesai</p>
            <p class="mt-1 text-[23px] font-bold text-green-600">{{ $summary['selesai'] }}</p>
        </a>

        <a href="{{ route('admin.prints.index', ['status' => 'perlu_revisi']) }}"
           class="rounded-[13px] border border-[#E2E8F0] bg-white p-5 transition hover:border-red-300">
            <p class="text-xs text-[#64748B]">Perlu Revisi</p>
            <p class="mt-1 text-[23px] font-bold text-red-500">{{ $summary['perlu_revisi'] }}</p>
        </a>

    </div>


    {{-- TABEL --}}
    <div class="w-full min-w-0 overflow-hidden rounded-[13px] border border-[#E2E8F0] bg-white">

        {{-- FILTER --}}
        <form
            method="GET"
            action="{{ route('admin.prints.index') }}"
            class="flex flex-col gap-3 border-b border-[#E2E8F0] p-5 md:flex-row md:items-center md:justify-between"
        >

            <div class="min-w-0">
                <h2 class="text-[16px] font-semibold text-[#001840]">Daftar File Cetak</h2>
                <p class="mt-1 text-xs text-[#64748B]">File dari pesanan pelanggan di toko yang layanan cetaknya aktif.</p>
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row md:w-auto">

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama file / no. resi..."
                    class="w-full rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#102A71] focus:ring-2 focus:ring-[#102A71]/10 sm:w-64"
                >

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="rounded-lg border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm outline-none focus:border-[#102A71]"
                >
                    <option value="">Semua Status</option>
                    <option value="menunggu"  @selected($status === 'menunggu')>Menunggu</option>
                    <option value="disetujui" @selected($status === 'disetujui')>Disetujui</option>
                    <option value="ditolak"   @selected($status === 'ditolak')>Ditolak</option>
                </select>

            </div>

        </form>


        <div class="w-full overflow-x-auto">

            <table class="w-full min-w-[900px] text-left">

                <thead class="bg-[#001840]">
                    <tr class="text-[11px] uppercase tracking-wider text-white">
                        <th class="px-6 py-4 font-semibold">File</th>
                        <th class="px-6 py-4 font-semibold">Pesanan</th>
                        <th class="px-6 py-4 font-semibold">Rincian Cetak</th>
                        <th class="px-6 py-4 font-semibold">Total</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E2E8F0]">

                    @forelse($prints as $print)

                        @php
                            $pesanan = $print->detailPesanan?->pesanan;
                            $toko    = $print->detailPesanan?->produk?->toko;
                        @endphp

                        <tr class="transition duration-150 hover:bg-[#F5F7FC]">

                            {{-- FILE --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#102A71] text-[#F5C400]">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="max-w-[220px] truncate text-sm font-semibold text-[#001840]" title="{{ $print->nama_file }}">
                                            {{ $print->nama_file }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-gray-400">
                                            {{ $toko->nama_toko ?? '-' }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- PESANAN --}}
                            <td class="px-6 py-4">
                                @if($pesanan)
                                    <a href="{{ route('admin.orders.show', $pesanan) }}"
                                       class="text-sm font-semibold text-[#102A71] hover:underline">
                                        {{ $pesanan->no_resi ?? '#ORD-' . $pesanan->id_pesanan }}
                                    </a>
                                    <p class="mt-0.5 text-xs text-gray-400">
                                        {{ $pesanan->tanggal_pesanan?->format('d M Y, H:i') }}
                                    </p>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- RINCIAN --}}
                            <td class="px-6 py-4 text-sm text-[#475569]">
                                <p>{{ $print->jumlah_halaman }} hal. · {{ $print->jumlah_cetak }} salinan</p>
                                <p class="mt-0.5 text-xs text-gray-400">
                                    HB {{ $print->halaman_hitam_putih }} · Warna {{ $print->halaman_warna }}
                                </p>
                            </td>

                            {{-- TOTAL --}}
                            <td class="px-6 py-4 text-sm font-semibold text-[#001840]">
                                Rp{{ number_format((float) $print->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge[$print->status_verifikasi] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($print->status_verifikasi) }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.prints.show', $print->id) }}"
                                       class="rounded-lg bg-[#F5C400] px-4 py-2 text-xs font-semibold text-[#001840] transition hover:bg-[#e6b900]">
                                        Periksa
                                    </a>
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EEF2FF] text-[#102A71]">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M6 9V2h12v7"/>
                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                        <rect x="6" y="14" width="12" height="8"/>
                                    </svg>
                                </div>

                                <p class="mt-4 text-sm font-semibold text-[#001840]">Belum ada file cetak</p>
                                <p class="mt-1 text-xs text-[#64748B]">File dari pelanggan akan tampil di sini.</p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($prints->hasPages())
            <div class="border-t border-[#E2E8F0] p-5">
                {{ $prints->links() }}
            </div>
        @endif

    </div>

</div>
</div>

@endsection