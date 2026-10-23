@php
    $productName = $product->nama_produk
        ?? $product->nama
        ?? 'Produk';

    $productPrice = $product->harga
        ?? $product->price
        ?? 0;

    $productImage = $product->gambar
        ?? $product->image
        ?? null;
@endphp

<div class="bg-white rounded-2xl border border-gray-100
            overflow-hidden
            shadow-sm hover:shadow-xl
            transition duration-300
            group">

    {{-- Image --}}
    <div class="relative h-48 bg-gray-100 overflow-hidden">

        @if($productImage)

            <img
                src="{{ asset('storage/' . $productImage) }}"
                alt="{{ $productName }}"
                class="w-full h-full object-cover
                       group-hover:scale-105
                       transition duration-500"
            >

        @else

            <div class="w-full h-full flex items-center justify-center
                        text-gray-400">

                <svg class="w-12 h-12"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     viewBox="0 0 24 24">

                    <rect x="3" y="3"
                          width="18"
                          height="18"
                          rx="2"/>

                    <circle cx="8.5" cy="8.5" r="1.5"/>

                    <path d="M21 15l-5-5L5 21"/>

                </svg>

            </div>

        @endif

    </div>


    {{-- Content --}}
    <div class="p-5">

        <h3 class="font-semibold text-[#001840] truncate">
            {{ $productName }}
        </h3>

        <p class="text-lg font-bold text-[#102A71] mt-2">
            Rp {{ number_format($productPrice, 0, ',', '.') }}
        </p>


        <a
            href="{{ route('pelanggan.produk.show', $product->id) }}"
            class="mt-4 w-full
                   inline-flex items-center
                   justify-center
                   py-2.5
                   rounded-xl
                   bg-[#001840]
                   text-[#F5C400]
                   text-sm font-semibold
                   hover:bg-[#102A71]
                   transition"
        >
            Lihat Detail
        </a>

    </div>

</div>