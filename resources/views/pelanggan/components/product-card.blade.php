@props([
    'product'
])

<div
    class="
        bg-white
        rounded-2xl
        border border-gray-200
        overflow-hidden
        shadow-sm
        hover:shadow-lg
        hover:-translate-y-1
        transition
        duration-300
    "
>

    {{-- Product Image --}}
    <div class="relative h-48 bg-gray-100 overflow-hidden">

        @if(isset($product->image))

            <img
                src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover"
            >

        @else

            <div
                class="
                    w-full h-full
                    flex items-center justify-center
                    bg-[#102A71]/10
                "
            >

                <svg
                    class="w-12 h-12 text-[#102A71]/30"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <rect
                        x="3"
                        y="3"
                        width="18"
                        height="18"
                        rx="2"
                    />

                    <path d="M3 16l5-5 4 4 3-3 6 6"/>
                </svg>

            </div>

        @endif

    </div>


    {{-- Product Information --}}
    <div class="p-4">

        <p class="text-[11px] text-[#102A71] font-medium mb-1">
            {{ $product->store_name ?? 'UBB Nextmart' }}
        </p>

        <h3 class="font-semibold text-[#001840] line-clamp-2">
            {{ $product->name ?? 'Nama Produk' }}
        </h3>

        <p class="text-lg font-bold text-[#102A71] mt-2">
            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
        </p>


        <a
            href="{{ isset($product->id)
                ? route('pelanggan.produk.show', $product->id)
                : '#' }}"
            class="
                mt-4
                w-full
                inline-flex
                items-center
                justify-center
                py-2.5
                rounded-xl
                bg-[#001840]
                text-white
                text-sm
                font-semibold
                hover:bg-[#102A71]
                hover:text-[#F5C400]
                transition
            "
        >
            Lihat Produk
        </a>

    </div>

</div>