@extends('pelanggan.layouts.app')

@section('title', 'UBB Nextmart - Beranda')

@section('content')

@php
    $jumlahToko = $tokoList->count();
    $ikonToko = ['bg-[#001840] text-white', 'bg-[#102A71] text-white', 'bg-[#F5C400] text-[#001840]'];
@endphp

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden bg-[#001840] min-h-[680px]">

    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="hero-grid"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="moving-line moving-line-1"></div>
            <div class="moving-line moving-line-2"></div>
            <div class="moving-line moving-line-3"></div>
        </div>
        <div class="absolute -top-32 -left-32 w-[450px] h-[450px] bg-[#102A71]/40 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-40 right-0 w-[500px] h-[500px] bg-[#102A71]/30 rounded-full blur-[130px]"></div>
    </div>

    <div class="absolute top-20 left-[8%] w-3 h-3 bg-[#F5C400] rounded-full opacity-70 animate-pulse"></div>
    <div class="absolute top-[45%] left-[4%] w-2 h-2 bg-white rounded-full opacity-30"></div>
    <div class="absolute bottom-20 left-[45%] w-2 h-2 bg-[#F5C400] rounded-full opacity-50 animate-pulse"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center min-h-[680px] py-20">

            {{-- KIRI --}}
            <div class="max-w-2xl">

                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-7">
                    <span class="w-2 h-2 bg-[#F5C400] rounded-full animate-pulse"></span>
                    <span class="text-white/80 text-sm font-medium">Belanja Mudah di UBB</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.08] tracking-tight text-white">
                    Semua Kebutuhan
                    <span class="block text-[#F5C400] mt-2">Dalam Satu Tempat.</span>
                </h1>

                <p class="mt-7 text-lg leading-relaxed text-white/65 max-w-xl">
                    Temukan berbagai kebutuhan mahasiswa, layanan printing, hingga pilihan makanan
                    dalam satu platform UBB Nextmart.
                </p>

                <div class="flex flex-wrap items-center gap-4 mt-9">
                    <a href="{{ route('pelanggan.produk.index') }}"
                       class="group inline-flex items-center gap-3 bg-[#F5C400] hover:bg-[#ffd51a] text-[#001840] font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-[#F5C400]/20">
                        <span>Lihat Produk</span>
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>

                    <a href="{{ route('pelanggan.pesanan.lacak') }}"
                       class="inline-flex items-center gap-2 border border-white/20 hover:border-white/40 hover:bg-white/5 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-300">
                        Lacak Pesanan
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-5 mt-12 max-w-lg">
                    <div>
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-sm text-white/45 mt-1">Akses Online</div>
                    </div>
                    <div class="border-l border-white/10 pl-5">
                        <div class="text-2xl font-bold text-white">{{ $jumlahToko }}</div>
                        <div class="text-sm text-white/45 mt-1">Toko Pilihan</div>
                    </div>
                    <div class="border-l border-white/10 pl-5">
                        <div class="text-2xl font-bold text-white">QRIS</div>
                        <div class="text-sm text-white/45 mt-1">Bayar Praktis</div>
                    </div>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="relative hidden lg:flex items-center justify-center min-h-[500px]">
                <div class="absolute w-[430px] h-[430px] rounded-full bg-[#102A71]/50 blur-[80px]"></div>
                <div class="absolute w-[420px] h-[420px] rounded-full border border-white/10 animate-[spin_25s_linear_infinite]"></div>
                <div class="absolute w-[350px] h-[350px] rounded-full border border-[#F5C400]/10 animate-[spin_18s_linear_infinite_reverse]"></div>

                <div class="hero-circle hero-circle-one">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-white/20 to-transparent z-10 pointer-events-none"></div>
                    <img src="{{ asset('images/ubbmart-dalam.png') }}" alt="UBB Mart Dalam" class="w-full h-full object-cover">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-t from-[#001840]/60 via-transparent to-transparent"></div>
                </div>

                <div class="hero-circle hero-circle-two">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-white/20 to-transparent z-10 pointer-events-none"></div>
                    <img src="{{ asset('images/ubbmart-depan.png') }}" alt="UBB Mart Depan" class="w-full h-full object-cover">
                    <div class="absolute inset-0 rounded-full bg-gradient-to-t from-[#001840]/60 via-transparent to-transparent"></div>
                </div>
            </div>

        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-[#f8fafc] via-[#f8fafc]/40 to-transparent pointer-events-none"></div>

    <style>
        .hero-grid {
            position: absolute; inset: -100px; opacity: 0.16;
            background-image:
                linear-gradient(rgba(255,255,255,0.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 70px 70px;
            transform: perspective(500px) rotateX(55deg) scale(1.5);
            transform-origin: center center;
            animation: gridMove 12s linear infinite;
        }
        @keyframes gridMove {
            0% { background-position: 0 0, 0 0; }
            100% { background-position: 0 70px, 70px 0; }
        }
        .moving-line { position: absolute; background: linear-gradient(90deg, transparent, rgba(245,196,0,0.35), transparent); }
        .moving-line-1 { width: 40%; height: 1px; top: 25%; left: -40%; animation: lineMove 7s linear infinite; }
        .moving-line-2 { width: 35%; height: 1px; top: 60%; left: -35%; animation: lineMove 9s linear infinite 2s; }
        .moving-line-3 { width: 25%; height: 1px; top: 80%; left: -25%; animation: lineMove 11s linear infinite 4s; }
        @keyframes lineMove { 0% { transform: translateX(0); } 100% { transform: translateX(500%); } }

        .hero-circle {
            position: absolute; overflow: hidden; border-radius: 9999px;
            border: 7px solid rgba(255,255,255,0.10);
            box-shadow: 0 25px 60px rgba(0,0,0,0.35), 0 0 60px rgba(16,42,113,0.45);
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            animation: floatCircle 5s ease-in-out infinite;
        }
        .hero-circle:hover { transform: scale(1.04) translateY(-8px); box-shadow: 0 30px 80px rgba(0,0,0,0.45), 0 0 80px rgba(245,196,0,0.18); }
        .hero-circle-one { width: 310px; height: 310px; left: 5px; top: 95px; z-index: 1; animation-delay: -1s; }
        .hero-circle-two { width: 360px; height: 360px; right: 10px; top: 45px; z-index: 2; border-color: rgba(245,196,0,0.22); animation-delay: -3s; }
        @keyframes floatCircle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }

        @media (max-width: 1024px) {
            .hero-circle-one { width: 260px; height: 260px; }
            .hero-circle-two { width: 300px; height: 300px; }
        }
        @media (max-width: 768px) { .hero-grid { background-size: 50px 50px; } }
    </style>
</section>


{{-- =========================================================
     TOKO (DARI DATABASE)
========================================================= --}}
<section class="bg-white py-8 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        @if($tokoList->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tokoList as $i => $toko)
                    @php
                        $namaToko = $toko->nama_toko ?? $toko->nama ?? 'Toko #' . $toko->id_toko;
                        $url = !empty($toko->id_group)
                            ? route('pelanggan.produk.index', ['group' => $toko->id_group])
                            : route('pelanggan.produk.index');
                    @endphp

                    <a href="{{ $url }}"
                       class="group rounded-2xl border border-gray-100 bg-white p-5 hover:border-[#102A71]/20 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $ikonToko[$i % 3] }} flex items-center justify-center text-lg font-bold">
                                {{ strtoupper(substr($namaToko, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-[#001840] truncate">{{ $namaToko }}</h3>
                                <p class="text-sm text-gray-500">{{ $toko->produk_count }} produk tersedia</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-center text-sm text-gray-500">Belum ada toko yang terdaftar.</p>
        @endif

    </div>
</section>


{{-- =========================================================
     PILIH GRUP OPERASIONAL
========================================================= --}}
@if($groups->isNotEmpty())
<section class="bg-white py-14 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="mb-8">
            <span class="text-sm font-bold text-[#102A71] uppercase tracking-wider">Mulai Belanja</span>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-[#001840] mt-2">Pilih Grup Operasional</h2>
            <p class="text-gray-500 mt-2 text-sm">Setiap grup memiliki proses checkout yang berbeda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($groups as $i => $g)
                @php
                    $namaGrup = $g->nama_group ?? $g->nama ?? 'Grup ' . $g->id_group;
                    $tokoGrup = $tokoList->where('id_group', $g->id_group);
                @endphp

                <a href="{{ route('pelanggan.produk.index', ['group' => $g->id_group]) }}"
                   class="group rounded-2xl border border-gray-200 bg-white p-6 hover:border-[#F5C400] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl {{ $i % 2 ? 'bg-[#F5C400] text-[#001840]' : 'bg-[#001840] text-white' }} flex items-center justify-center text-xl font-bold">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#F5C400]">Grup Operasional {{ $i + 1 }}</p>
                                <h3 class="text-lg font-bold text-[#001840] mt-0.5">{{ $namaGrup }}</h3>
                            </div>
                        </div>
                        <span class="text-[#102A71] text-xl group-hover:translate-x-1 transition">→</span>
                    </div>

                    @if($tokoGrup->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-5">
                            @foreach($tokoGrup as $t)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-[#001840]">
                                    {{ $t->nama_toko ?? $t->nama ?? 'Toko' }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- =========================================================
     PRODUK TERBARU (DARI DATABASE)
========================================================= --}}
<section id="produk" class="bg-[#f8fafc] py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex items-end justify-between gap-5 mb-8">
            <div>
                <span class="text-sm font-bold text-[#102A71] uppercase tracking-wider">Pilihan Produk</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-[#001840] mt-2">Produk Terbaru</h2>
                <p class="text-gray-500 mt-3">Temukan kebutuhan yang kamu perlukan di UBB Nextmart.</p>
            </div>

            <a href="{{ route('pelanggan.produk.index') }}"
               class="hidden sm:inline-flex items-center gap-2 font-semibold text-[#102A71] hover:text-[#001840] transition">
                Lihat Semua <span>→</span>
            </a>
        </div>

        {{-- Kategori --}}
        @if($kategoriList->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($kategoriList as $k)
                    <a href="{{ route('pelanggan.produk.index', ['kategori' => $k->id_kategori]) }}"
                       class="rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-[#001840] hover:border-[#102A71] hover:bg-[#102A71] hover:text-white transition">
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($produkTerbaru->isNotEmpty())

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($produkTerbaru as $p)
                    @php
                        $namaToko = $p->toko->nama_toko ?? $p->toko->nama ?? '-';
                        $stok = (int) $p->stok;
                    @endphp

                    <div class="group flex flex-col bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                        <a href="{{ route('pelanggan.produk.show', $p) }}" class="relative block aspect-square bg-gray-100 overflow-hidden">
                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_produk }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-4xl text-gray-300">▣</div>
                            @endif

                            @if($p->kategori)
                                <span class="absolute top-3 left-3 rounded-full bg-[#F5C400] px-2.5 py-1 text-[10px] font-bold text-[#001840]">
                                    {{ $p->kategori->nama_kategori }}
                                </span>
                            @endif

                            @if($stok > 0 && $stok <= 5)
                                <span class="absolute top-3 right-3 rounded-full bg-red-500 px-2.5 py-1 text-[10px] font-bold text-white">
                                    Sisa {{ $stok }}
                                </span>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-4">
                            <p class="text-[11px] text-gray-400">{{ $namaToko }}</p>

                            <a href="{{ route('pelanggan.produk.show', $p) }}">
                                <h3 class="mt-1 font-bold text-[#001840] line-clamp-2 hover:text-[#102A71] transition">{{ $p->nama_produk }}</h3>
                            </a>

                            <p class="text-[#102A71] font-extrabold mt-2">
                                Rp{{ number_format($p->harga, 0, ',', '.') }}
                            </p>

                            <div class="mt-auto pt-4">
                            @if($stok > 0)
                                <form method="POST" action="{{ route('pelanggan.keranjang.store') }}">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit"
                                            class="w-full rounded-xl bg-[#F5C400] py-2.5 text-xs font-bold text-[#001840] hover:bg-[#102A71] hover:text-[#F5C400] transition active:scale-[0.98]">
                                        + Keranjang
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled
                                        class="w-full cursor-not-allowed rounded-xl bg-gray-100 py-2.5 text-xs font-bold text-gray-400">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('pelanggan.produk.index') }}" class="inline-flex items-center gap-2 font-semibold text-[#102A71]">Lihat Semua →</a>
            </div>

        @else

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center">
                <p class="font-bold text-[#001840]">Belum ada produk</p>
                <p class="mt-1 text-sm text-gray-500">Produk yang ditambahkan admin akan tampil di sini.</p>
            </div>

        @endif

    </div>
</section>


{{-- =========================================================
     MEDIA SOSIAL
========================================================= --}}
<section id="media-sosial" class="bg-white py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-10 text-center">
            <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-[#001840]">
                Kenali Kami Lebih Dekat
            </span>
            <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-[#001840] sm:text-4xl">Ikuti Media Sosial Kami</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-gray-500 sm:text-base">
                Dapatkan informasi produk terbaru, promo menarik, dan aktivitas
                UBB Mart &amp; Gubuk Printing melalui media sosial kami.
            </p>
        </div>

        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-2">

            {{-- INSTAGRAM --}}
            <div class="overflow-hidden rounded-[15px] border border-gray-200 bg-white p-4 sm:p-5">
                <div class="mb-[18px] flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-[15px] font-bold text-[#001840]">Instagram</h3>
                        <p class="mt-0.5 text-[11px] text-gray-500">@@ubbmart_gubukprinting</p>
                    </div>
                    <a href="https://www.instagram.com/ubbmart_gubukprinting/" target="_blank" rel="noopener noreferrer"
                       class="shrink-0 text-[11px] font-semibold text-[#102A71]">Buka Profil →</a>
                </div>

                <blockquote class="instagram-media"
                            data-instgrm-permalink="https://www.instagram.com/ubbmart_gubukprinting/?utm_source=ig_embed&amp;utm_campaign=loading"
                            data-instgrm-version="14"
                            style="background:#FFF; border:0; border-radius:12px; margin:0; max-width:100%; min-width:0; padding:0; width:100%;">
                    <a href="https://www.instagram.com/ubbmart_gubukprinting/" target="_blank" rel="noopener noreferrer"
                       class="block rounded-xl bg-[#001840] px-5 py-3 text-center text-sm font-bold text-white">
                        Lihat Profil Instagram @@ubbmart_gubukprinting
                    </a>
                </blockquote>
            </div>

            {{-- TIKTOK --}}
            <div class="overflow-hidden rounded-[15px] border border-gray-200 bg-white p-4 sm:p-5">
                <div class="mb-[18px] flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-[15px] font-bold text-[#001840]">TikTok</h3>
                        <p class="mt-0.5 text-[11px] text-gray-500">@@ubbmart_gubukprinting</p>
                    </div>
                    <a href="https://www.tiktok.com/@@ubbmart_gubukprinting" target="_blank" rel="noopener noreferrer"
                       class="shrink-0 text-[11px] font-semibold text-[#102A71]">Buka Profil →</a>
                </div>

                <blockquote class="tiktok-embed"
                            cite="https://www.tiktok.com/@@ubbmart_gubukprinting"
                            data-unique-id="ubbmart_gubukprinting"
                            data-embed-type="creator"
                            style="max-width: 100%; min-width: 0; margin: 0;">
                    <section>
                        <a target="_blank" rel="noopener noreferrer"
                           href="https://www.tiktok.com/@@ubbmart_gubukprinting?refer=creator_embed">
                            @@ubbmart_gubukprinting
                        </a>
                    </section>
                </blockquote>
            </div>

        </div>
    </div>
</section>

<script async src="https://www.tiktok.com/embed.js"></script>
<script async src="https://www.instagram.com/embed.js"></script>

@endsection