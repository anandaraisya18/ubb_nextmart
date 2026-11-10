@if(session('success'))

    <div
        class="mb-5
               flex items-start gap-3
               p-4
               rounded-xl
               bg-green-50
               border border-green-200
               text-green-700"
    >

        <svg
            class="w-5 h-5 mt-0.5 shrink-0"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path
                d="M5 12l4 4L19 6"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        <div>
            <p class="text-sm font-semibold">
                Berhasil
            </p>

            <p class="text-xs mt-0.5">
                {{ session('success') }}
            </p>
        </div>

    </div>

@endif


@if(session('error'))

    <div
        class="mb-5
               flex items-start gap-3
               p-4
               rounded-xl
               bg-red-50
               border border-red-200
               text-red-700"
    >

        <svg
            class="w-5 h-5 mt-0.5 shrink-0"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
        >
            <path
                d="M6 6l12 12M18 6L6 18"
                stroke-linecap="round"
            />
        </svg>

        <div>
            <p class="text-sm font-semibold">
                Terjadi Kesalahan
            </p>

            <p class="text-xs mt-0.5">
                {{ session('error') }}
            </p>
        </div>

    </div>

@endif


@if($errors->any())

    <div
        class="mb-5
               p-4
               rounded-xl
               bg-red-50
               border border-red-200
               text-red-700"
    >

        <p class="text-sm font-semibold mb-2">
            Periksa kembali data:
        </p>

        <ul class="text-xs space-y-1 list-disc pl-4">

            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

@endif