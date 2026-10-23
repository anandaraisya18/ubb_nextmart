{{-- resources/views/superadmin/components/stat-card.blade.php --}}

<div
    class="
        bg-white
        rounded-2xl
        border border-gray-200
        p-5
        hover:shadow-md
        transition
    "
>

    <div class="flex items-start justify-between">

        {{-- Icon --}}
        <div
            class="
                w-11 h-11
                rounded-xl
                flex items-center justify-center
                {{ $iconBg ?? 'bg-[#102A71]' }}
            "
        >

            {!! $icon ?? '
                <svg
                    class="w-5 h-5 text-[#F5C400]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <circle cx="12" cy="12" r="9"/>
                </svg>
            ' !!}

        </div>


        {{-- Trend --}}
        @if(isset($trend))

            <span
                class="
                    text-[11px]
                    font-semibold
                    px-2 py-1
                    rounded-full
                    {{ ($trendType ?? 'up') === 'up'
                        ? 'bg-green-50 text-green-600'
                        : 'bg-red-50 text-red-500' }}
                "
            >
                {{ $trend }}
            </span>

        @endif

    </div>


    {{-- Content --}}
    <div class="mt-5">

        <p class="text-xs text-gray-500">
            {{ $label ?? 'Total' }}
        </p>

        <h3 class="
            mt-1
            text-2xl
            font-bold
            text-[#001840]
        ">
            {{ $value ?? '0' }}
        </h3>

        @if(isset($description))

            <p class="mt-1 text-[11px] text-gray-400">
                {{ $description }}
            </p>

        @endif

    </div>

</div>
