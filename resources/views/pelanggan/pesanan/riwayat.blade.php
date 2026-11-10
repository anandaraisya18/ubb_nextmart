@extends('pelanggan.layouts.app')

@section('title', 'Riwayat Pesanan - UBB Nextmart')

@section('content')

@php
    $warnaStatus = [
        'menunggu_pembayaran' => 'bg-gray-100 text-gray-600',
        'menunggu_verifikasi' => 'bg-amber-50 text-amber-600',
        'diproses'            => 'bg-blue-50 text-blue-600',
        'siap_diambil'        => 'bg-indigo-50 text-indigo-600',
        'selesai'             => 'bg-green-50 text-green-600',
        'dibatalkan'          => 'bg-red-50 text-red-500',
    ];
@endphp

<div class="min-h-screen bg-slate-50">

    <section class="relative overflow-hidden bg-[#001840] text-white">

        <div class="absolute -top-32 -right-32 w-80 h-80 rounded-full bg-[#102A71] blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-32 w-96 h-96 rounded-full bg-[#F5C400]/10 blur-3xl"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16">

            <div class="flex justify-center mb-8">
                <div class="inline-flex p-1 rounded-xl bg-white/5 border border-white/10 text-sm font-medium">
                    <a href="{{ route('pelanggan.pesanan.lacak') }}"
                       class="px-5 py-2 rounded-lg text-white/70 hover:text-white transition">Lacak Pesanan</a>
                    <a href="{{ route('pelanggan.pesanan.riwayat') }}"
                       class="px-5 py-2 rounded-lg bg-[#F5C400] text-[#001840] font-semibold">Riwayat</a>
                </div>
            </div>

            <div class="text-center">
                <p class="text-[11px] text-[#F5C400] font-semibold uppercase tracking-[0.18em]">UBB Nextmart</p>
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mt-2">Riwayat Pesanan</h1>
                <p class="max-w-xl mx-auto text-sm sm:text-base text-white/55 mt-3 leading-relaxed">
                    Semua pesanan yang pernah kamu buat ada di sini.
                </p>
            </div>

        </div>
    </section>


    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @guest('pelanggan')

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-14 text-center">
                <p class="font-bold text-[#001840]">Login dulu untuk melihat riwayat</p>
                <p class="mt-1 text-sm text-gray-500">Riwayat pesanan tersimpan di akun pelangganmu.</p>
                <a href="{{ route('pelanggan.login') }}"
                   class="mt-5 inline-flex items-center rounded-xl bg-[#F5C400] px-5 py-2.5 text-xs font-bold text-[#001840] hover:bg-[#e5b900] transition">
                    Login
                </a>
            </div>

        @else

            @if($riwayat->count())

                <div class="space-y-4">
                    @foreach($riwayat as $p)

                        @php
                            $detailCetak = $p->detail
                                ->flatMap(fn ($detail) => $detail->detailPrints ?? collect())
                                ->where('status_verifikasi', 'perlu_revisi');

                            $adaPotongan = (float) $p->potongan_cetak > 0;
                        @endphp

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 hover:shadow-md transition">

                            {{-- Header --}}
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-[#001840]">{{ $p->no_resi }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">
                                        {{ optional($p->tanggal_pesanan)->translatedFormat('d F Y, H:i') }}
                                    </p>
                                </div>

                                <span class="rounded-full px-3 py-1 text-[11px] font-semibold {{ $warnaStatus[$p->status_pesanan] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ \App\Models\Pesanan::STATUS[$p->status_pesanan] ?? $p->status_pesanan }}
                                </span>
                            </div>

                            {{-- File cetak ditolak --}}
                            @if($detailCetak->isNotEmpty())
                                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4">

                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 shrink-0 text-amber-600 mt-0.5"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M12 9v4m0 4h.01M10.3 3.9 2.8 17.5A2 2 0 0 0 4.5 20.5h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                                        </svg>

                                        <div>
                                            <p class="text-sm font-bold text-amber-800">
                                                File cetak ditolak
                                            </p>
                                            <p class="mt-1 text-xs leading-relaxed text-amber-700">
                                                @if($p->selesai_otomatis)
                                                    Semua file cetak di pesanan ini ditolak, sehingga pesanan ditutup dan tidak ada tagihan cetak.
                                                @else
                                                    File berikut tidak dapat dicetak. Biayanya sudah dikurangkan dari total pesanan.
                                                @endif
                                                Jika tetap ingin mencetak, silakan buat pesanan baru dengan file yang sudah diperbaiki.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-3 space-y-3">
                                        @foreach($detailCetak as $cetak)
                                            <div class="rounded-lg border border-amber-200/70 bg-white p-3">
                                                <div class="flex items-start justify-between gap-2">
                                                    <p class="text-xs font-semibold text-gray-800 break-all">
                                                        {{ $cetak->nama_file }}
                                                    </p>
                                                    <p class="shrink-0 text-xs font-semibold text-green-600">
                                                        -Rp{{ number_format($cetak->total_harga, 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                <p class="mt-2 text-[11px] font-semibold uppercase tracking-wide text-amber-700">
                                                    Catatan Admin
                                                </p>

                                                <p class="mt-1 text-xs leading-relaxed text-gray-600">
                                                    {{ $cetak->catatan_admin ?: 'Admin belum memberikan keterangan.' }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <a href="{{ route('pelanggan.produk.index') }}"
                                       class="mt-3 inline-flex items-center text-xs font-semibold text-amber-800 hover:underline">
                                        Pesan ulang →
                                    </a>

                                </div>
                            @endif

                            {{-- Footer: harga + tombol --}}
                            <div class="mt-4 flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
                                <div>
                                    @if($adaPotongan)
                                        <p class="text-xs text-gray-400 line-through">
                                            Rp{{ number_format($p->total_awal, 0, ',', '.') }}
                                        </p>
                                    @endif

                                    <p class="text-base font-extrabold text-[#102A71]">
                                        Rp{{ number_format($p->total, 0, ',', '.') }}
                                    </p>

                                    @if($adaPotongan)
                                        <p class="mt-0.5 text-[11px] font-semibold text-green-600">
                                            Potongan cetak -Rp{{ number_format($p->potongan_cetak, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>

                                <a href="{{ route('pelanggan.pesanan.show', ['id' => $p->id_pesanan]) }}"
                                   class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-[#001840] hover:bg-slate-50 hover:border-[#102A71]/30 transition">
                                    Lacak →
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $riwayat->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-14 text-center">
                    <p class="font-bold text-[#001840]">Belum ada pesanan</p>
                    <p class="mt-1 text-sm text-gray-500">Pesanan yang kamu buat akan muncul di sini.</p>
                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="mt-5 inline-flex items-center rounded-xl bg-[#F5C400] px-5 py-2.5 text-xs font-bold text-[#001840] hover:bg-[#e5b900] transition">
                        Mulai Belanja
                    </a>
                </div>

            @endif

        @endguest

    </section>

</div>

@endsection