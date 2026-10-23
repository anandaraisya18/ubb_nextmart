<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pesanan - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7FA] min-h-screen">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-lg w-full">

            <div class="text-center">

                <div class="w-16 h-16 mx-auto mb-5 rounded-full
                            bg-[#102A71] flex items-center justify-center">
                    <span class="text-white text-2xl">✓</span>
                </div>

                <h1 class="text-2xl font-bold text-[#001840]">
                    Detail Pesanan
                </h1>

                <p class="mt-2 text-gray-500">
                    Nomor Pesanan #{{ $pesanan->id_pesanan }}
                </p>

                @if ($pesanan->no_resi)
                    <p class="mt-1 text-sm text-gray-500">
                        Nomor Resi:
                        <span class="font-semibold text-[#102A71]">
                            {{ $pesanan->no_resi }}
                        </span>
                    </p>
                @endif

            </div>

            <div class="mt-8 space-y-4">

                <div class="p-4 rounded-xl bg-gray-50">
                    <p class="text-sm text-gray-500">
                        Status Pesanan
                    </p>

                    <p class="mt-1 font-semibold text-[#102A71]">
                        {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan ?? 'Menunggu Pembayaran')) }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50">
                    <p class="text-sm text-gray-500">
                        Total Pesanan
                    </p>

                    <p class="mt-1 font-bold text-[#001840]">
                        Rp{{ number_format($pesanan->total ?? 0, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            <a
                href="{{ route('pelanggan.pesanan.index') }}"
                class="block mt-6 text-center py-3 rounded-xl
                       bg-[#001840] text-white font-semibold
                       hover:bg-[#102A71] transition"
            >
                Kembali ke Lacak Pesanan
            </a>

        </div>

    </div>

</body>
</html>
