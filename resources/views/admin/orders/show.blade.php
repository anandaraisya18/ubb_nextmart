<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-[250px]">

        @include('admin.components.topbar', [
            'title' => 'Detail Pesanan',
            'subtitle' => 'Informasi lengkap pesanan pelanggan'
        ])

        <section class="p-5 md:p-7 lg:p-8">

            @php
                $pelanggan   = $order->pelanggan;
                $biayaTambah = $order->total - $order->subtotal;

                $badge = [
                    'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-700',
                    'menunggu_verifikasi' => 'bg-orange-100 text-orange-700',
                    'diproses'            => 'bg-blue-100 text-blue-700',
                    'siap_diambil'        => 'bg-indigo-100 text-indigo-700',
                    'selesai'             => 'bg-green-100 text-green-700',
                    'dibatalkan'          => 'bg-red-100 text-red-700',
                ];

                $badgeClass = $badge[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700';
                $statusText = \App\Models\Pesanan::STATUS[$order->status_pesanan] ?? $order->status_pesanan;
            @endphp

            @if(session('success'))
                <div class="mb-5 rounded-xl border border-[#ccebd8] bg-[#e7f7ed] px-4 py-3 text-xs text-[#218448]">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 rounded-xl border border-[#f5d0d0] bg-[#feecec] px-4 py-3 text-xs text-[#c83b3b]">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-5">
                <a href="{{ route('admin.orders.index') }}"
                   class="inline-flex items-center gap-2 text-xs font-semibold text-[#102A71] transition hover:text-[#001840]">
                    ← Kembali ke Pesanan
                </a>
            </div>

            {{-- HEADER --}}
            <div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-br from-[#001840] to-[#102A71] p-6 md:p-7">
                <div class="absolute -right-10 -top-12 h-36 w-36 rounded-full border-[22px] border-[#F5C400]/15"></div>

                <div class="relative z-10 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-[11px] font-medium text-white/70">Detail Pesanan</p>
                        <h2 class="mt-1 text-2xl font-bold text-white">
                            {{ $order->no_resi ?: '#' . $order->id_pesanan }}
                        </h2>
                        <p class="mt-2 text-xs text-white/80">
                            {{ $order->tanggal_pesanan?->translatedFormat('d F Y') }}
                            • {{ $order->tanggal_pesanan?->format('H:i') }} WIB
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full px-3 py-1.5 text-[10px] font-bold {{ $badgeClass }}">
                        {{ $statusText }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- KIRI --}}
                <div class="space-y-6 xl:col-span-2">

                    {{-- PELANGGAN --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-base font-bold text-[#001840]">Informasi Pelanggan</h3>
                        </div>

                        <div class="p-5">
                            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#eef2fb] text-lg font-bold text-[#102A71]">
                                    {{ strtoupper(substr($pelanggan->nama ?? '?', 0, 1)) }}
                                </div>

                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-[#001840]">
                                        {{ $pelanggan->nama ?? 'Pelanggan tidak ditemukan' }}
                                    </h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ $pelanggan->no_hp ?? '-' }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ $pelanggan->email ?? '-' }}</p>
                                </div>

                                <div class="sm:text-right">
                                    <p class="text-[10px] text-gray-400">Jenis Pengambilan</p>
                                    <p class="mt-1 text-xs font-semibold text-gray-700">
                                        {{ \App\Models\Pesanan::PENGAMBILAN[$order->jenis_pengambilan] ?? $order->jenis_pengambilan }}
                                    </p>
                                </div>
                            </div>

                            @if(!empty($pelanggan?->alamat))
                                <div class="mt-5 rounded-xl bg-[#f8f9fc] p-4">
                                    <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Alamat</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-600">{{ $pelanggan->alamat }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PRODUK --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="flex items-center justify-between border-b border-gray-200 p-5">
                            <div>
                                <h3 class="text-base font-bold text-[#001840]">Detail Produk</h3>
                                <p class="mt-1 text-[11px] text-gray-500">Produk yang dipesan pelanggan.</p>
                            </div>

                            <span class="rounded-full bg-[#001840] px-3 py-1.5 text-[10px] font-semibold text-white">
                                <span class="text-[#F5C400]">{{ $items->count() }}</span> Produk
                            </span>
                        </div>

                        @forelse($items as $item)
                            <div class="flex gap-4 border-b border-gray-100 p-5 last:border-b-0">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#eef2fb] font-bold text-[#102A71]">
                                    ▣
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h4 class="text-sm font-bold text-[#001840]">
                                        {{ $item->produk->nama_produk ?? 'Produk dihapus' }}
                                    </h4>
                                    <p class="mt-3 text-[11px] text-gray-500">
                                        {{ $item->jumlah }} × Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                <p class="text-xs font-bold text-[#001840]">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-gray-500">
                                Belum ada rincian produk untuk pesanan ini.
                            </div>
                        @endforelse
                    </div>

                    {{-- BUKTI PEMBAYARAN --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="flex items-center justify-between border-b border-gray-200 p-5">
                            <div>
                                <h3 class="text-base font-bold text-[#001840]">Bukti Pembayaran</h3>
                                <p class="mt-1 text-[11px] text-gray-500">
                                    Periksa bukti transfer yang dikirim pelanggan.
                                </p>
                            </div>

                            @if($order->bukti_pembayaran)
                                <span class="rounded-full bg-green-100 px-3 py-1.5 text-[10px] font-bold text-green-700">
                                    Bukti tersedia
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1.5 text-[10px] font-bold text-gray-600">
                                    Belum diunggah
                                </span>
                            @endif
                        </div>

                        <div class="p-5">
                            @if($order->bukti_pembayaran)
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($order->bukti_pembayaran) }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="mb-4 inline-flex items-center gap-2 rounded-lg border border-[#102A71]/20 px-4 py-2.5 text-xs font-semibold text-[#102A71] transition hover:bg-[#eef2fb]">
                                    ↗ Buka Gambar Penuh
                                </a>

                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($order->bukti_pembayaran) }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="block">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($order->bukti_pembayaran) }}"
                                        alt="Bukti pembayaran pesanan {{ $order->no_resi }}"
                                        class="max-h-[500px] w-full rounded-xl border border-gray-200 bg-gray-50 object-contain"
                                        loading="lazy"
                                    >
                                </a>

                                @if($order->status_pesanan === 'menunggu_verifikasi')
                                    <div class="mt-5 rounded-xl border border-orange-200 bg-orange-50 p-4">
                                        <p class="text-xs leading-5 text-orange-800">
                                            Pastikan bukti pembayaran sesuai dengan total pesanan
                                            sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                            sebelum memverifikasi.
                                        </p>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.orders.update', $order) }}"
                                            class="mt-4"
                                            onsubmit="return confirm('Yakin bukti pembayaran sudah valid dan pembayaran dapat diverifikasi?')"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="status_pesanan" value="diproses">

                                            <button
                                                type="submit"
                                                class="flex w-full items-center justify-center rounded-lg bg-[#102A71] px-4 py-3 text-xs font-bold text-white transition hover:bg-[#001840]"
                                            >
                                                ✓ Verifikasi Pembayaran
                                            </button>
                                        </form>
                                    </div>
                                @elseif(in_array($order->status_pesanan, ['diproses', 'siap_diambil', 'selesai']))
                                    <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-xs leading-5 text-green-700">
                                        Pembayaran telah diverifikasi atau pesanan sudah memasuki tahap pemrosesan.
                                    </div>
                                @endif
                            @else
                                <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-5 py-10 text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-xl">
                                        ▧
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-gray-700">
                                        Belum ada bukti pembayaran
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Bukti akan muncul di sini setelah pelanggan mengunggahnya.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- KANAN --}}
                <div class="space-y-6">

                    {{-- RINGKASAN --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-base font-bold text-[#001840]">Ringkasan Pembayaran</h3>
                        </div>

                        <div class="space-y-4 p-5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Subtotal</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">Biaya Tambahan / Diskon</span>
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $biayaTambah < 0 ? '-' : '' }}Rp {{ number_format(abs($biayaTambah), 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="border-t border-dashed border-gray-200 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-[#001840]">Total</span>
                                    <span class="text-lg font-bold text-[#102A71]">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TRANSAKSI --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-base font-bold text-[#001840]">Transaksi</h3>
                        </div>

                        <div class="space-y-4 p-5">
                            <div>
                                <p class="text-[10px] text-gray-400">Tipe Transaksi</p>
                                <p class="mt-1 text-xs font-semibold text-gray-700">
                                    {{ \App\Models\Pesanan::TIPE[$order->tipe_transaksi] ?? $order->tipe_transaksi }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] text-gray-400">No. Resi</p>
                                <p class="mt-1 text-xs font-semibold text-gray-700">
                                    {{ $order->no_resi ?: '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- STATUS --}}
@php
    $alur = [
        'menunggu_pembayaran' => ['dibatalkan'],
        'menunggu_verifikasi' => ['dibatalkan'],
        'diproses'            => ['siap_diambil', 'selesai', 'dibatalkan'],
        'siap_diambil'        => ['selesai', 'dibatalkan'],
    ];
    $berikutnya = $alur[$order->status_pesanan] ?? [];

    $tombol = [
        'siap_diambil' => ['Tandai Siap Diambil', 'bg-indigo-600 text-white hover:bg-indigo-700',  'Tandai pesanan siap diambil?'],
        'selesai'      => ['Tandai Selesai',      'bg-[#F5C400] text-[#001840] hover:bg-[#ffd21a]', 'Tandai pesanan ini selesai?'],
        'dibatalkan'   => ['Batalkan Pesanan',    'border border-red-200 text-red-600 hover:bg-red-600 hover:text-white', 'Batalkan pesanan? Stok produk akan dikembalikan.'],
    ];
@endphp

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
    <div class="border-b border-gray-200 p-5">
        <h3 class="text-base font-bold text-[#001840]">Status Pesanan</h3>
    </div>

    <div class="p-5">
        <span class="mb-5 inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $badgeClass }}">
            {{ $statusText }}
        </span>

        @if($order->status_pesanan === 'menunggu_verifikasi')
            <p class="mb-4 text-[11px] leading-5 text-gray-500">
                Verifikasi pembayaran lewat bagian Bukti Pembayaran di sebelah kiri.
            </p>
        @endif

        <div class="space-y-2">
            @foreach($berikutnya as $status)
                <form method="POST" action="{{ route('admin.orders.update', $order) }}"
                      onsubmit="return confirm('{{ $tombol[$status][2] }}')">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status_pesanan" value="{{ $status }}">
                    <button type="submit"
                            class="flex w-full items-center justify-center rounded-lg px-4 py-3 text-[11px] font-bold transition {{ $tombol[$status][1] }}">
                        {{ $tombol[$status][0] }}
                    </button>
                </form>
            @endforeach

            @if(empty($berikutnya))
                <p class="rounded-lg bg-gray-50 px-4 py-3 text-center text-[11px] text-gray-500">
                    Pesanan ini sudah final, status tidak dapat diubah lagi.
                </p>
            @endif

            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                  onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="mt-3 flex w-full items-center justify-center rounded-lg border border-red-200 px-4 py-3 text-[11px] font-semibold text-red-600 transition hover:bg-red-600 hover:text-white">
                    Hapus Pesanan
                </button>
            </form>
        </div>
    </div>
</div>