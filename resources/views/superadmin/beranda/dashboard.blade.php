<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Superadmin - UBB Nextmart</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7FC] text-gray-800">

    {{-- SIDEBAR --}}
    @include('superadmin.components.sidebar')

    {{-- MAIN WRAPPER --}}
    <div class="lg:ml-64 min-h-screen">

        {{-- TOPBAR --}}
        @include('superadmin.components.topbar', [
            'title' => 'Dashboard',
            'subtitle' => 'Kelola sistem UBB Nextmart secara terpusat',
        ])

        {{-- CONTENT --}}
        <main class="w-full">

            <div class="w-full p-5 md:p-8">

                {{-- ALERT --}}
                @include('superadmin.components.alert')

                {{-- WELCOME --}}
                <section
                    class="
                        relative
                        overflow-hidden
                        rounded-2xl
                        bg-gradient-to-r
                        from-[#001840]
                        to-[#102A71]
                        p-6 md:p-8
                        mb-6
                        shadow-sm
                    "
                >

                    {{-- Decorative circle --}}
                    <div
                        class="
                            absolute
                            -right-16
                            -top-16
                            w-48
                            h-48
                            rounded-full
                            bg-[#F5C400]/10
                        "
                    ></div>

                    <div
                        class="
                            absolute
                            -right-24
                            -bottom-24
                            w-56
                            h-56
                            rounded-full
                            border
                            border-[#F5C400]/10
                        "
                    ></div>

                    <div class="relative z-10">

                        <span
                            class="
                                inline-flex
                                items-center
                                px-3 py-1
                                rounded-full
                                bg-[#F5C400]
                                text-[#001840]
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-wider
                                mb-4
                            "
                        >
                            Akses Superadmin
                        </span>

                        <h1
                            class="
                                text-xl
                                md:text-2xl
                                font-bold
                                text-white
                            "
                        >
                            Selamat Datang, Superadmin!
                        </h1>

                        <p
                            class="
                                mt-2
                                text-sm
                                text-white/70
                                max-w-2xl
                            "
                        >
                            Pantau dan kelola akun admin, group operasional,
                            serta toko UBB Nextmart dalam satu dashboard.
                        </p>

                    </div>

                </section>

                {{-- STATISTICS --}}
                <section
                    class="
                        grid
                        grid-cols-1
                        sm:grid-cols-2
                        xl:grid-cols-4
                        gap-5
                        mb-6
                    "
                >

                    {{-- ADMIN --}}
                    @include('superadmin.components.stat-card', [
                        'label' => 'Total Admin',
                        'value' => $totalAdmin,
                        'description' => 'Admin terdaftar',
                        'icon' => '
                            <svg
                                class="w-5 h-5 text-[#F5C400]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        ',
                    ])

                    {{-- GROUP --}}
                    @include('superadmin.components.stat-card', [
                        'label' => 'Total Group',
                        'value' => $totalGroups,
                        'description' => 'Group operasional',
                        'icon' => '
                            <svg
                                class="w-5 h-5 text-[#F5C400]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <rect x="3" y="3" width="7" height="7" rx="1"/>
                                <rect x="14" y="3" width="7" height="7" rx="1"/>
                                <rect x="3" y="14" width="7" height="7" rx="1"/>
                                <rect x="14" y="14" width="7" height="7" rx="1"/>
                            </svg>
                        ',
                    ])

                    {{-- TOKO --}}
                    @include('superadmin.components.stat-card', [
                        'label' => 'Total Toko',
                        'value' => $totalStores,
                        'description' => 'Toko terdaftar',
                        'icon' => '
                            <svg
                                class="w-5 h-5 text-[#F5C400]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path d="M3 9l2-5h14l2 5"/>
                                <path d="M5 9v11h14V9"/>
                                <path d="M9 20v-6h6v6"/>
                                <path d="M3 9h18"/>
                            </svg>
                        ',
                    ])

                    {{-- AKTIVITAS --}}
                    @include('superadmin.components.stat-card', [
                        'label' => 'Aktivitas Hari Ini',
                        'value' => $totalActivities,
                        'description' => 'Aktivitas tercatat',
                        'icon' => '
                            <svg
                                class="w-5 h-5 text-[#F5C400]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        ',
                    ])

                </section>

                {{-- LOWER CONTENT --}}
                <section
                    class="
                        grid
                        grid-cols-1
                        xl:grid-cols-12
                        gap-5
                    "
                >

                    {{-- GROUP OPERASIONAL --}}
                    <div
                        class="
                            xl:col-span-7
                            min-w-0
                            bg-white
                            rounded-2xl
                            border border-gray-200
                            p-5 md:p-6
                        "
                    >

                        {{-- HEADER --}}
                        <div
                            class="
                                flex
                                items-start
                                justify-between
                                gap-4
                                mb-5
                            "
                        >

                            <div class="min-w-0">

                                <h2
                                    class="
                                        text-base
                                        font-bold
                                        text-[#001840]
                                    "
                                >
                                    Group Operasional
                                </h2>

                                <p class="mt-1 text-xs text-gray-400">
                                    Ringkasan group dan toko yang dikelola
                                </p>

                            </div>

                            <a
                                href="{{ route('superadmin.group.index') }}"
                                class="
                                    shrink-0
                                    whitespace-nowrap
                                    text-xs
                                    font-semibold
                                    text-[#102A71]
                                    hover:text-[#F5C400]
                                    transition
                                "
                            >
                                Lihat Semua →
                            </a>

                        </div>

                        {{-- DAFTAR GROUP DARI DATABASE --}}
                        @forelse ($groups as $group)

                            <div class="py-4 border-b border-gray-100 last:border-b-0">

                                <div class="flex items-center justify-between gap-3">

                                    <h3 class="text-sm font-semibold text-[#001840]">
                                        {{ $group->nama_group }}
                                    </h3>

                                    <span class="shrink-0 text-[10px] text-gray-400">
                                        {{ $group->tokos->count() }}
                                        Toko
                                    </span>

                                </div>

                                <div class="flex flex-wrap gap-2 mt-3">

                                    @forelse ($group->tokos as $toko)

                                        <span
                                            class="
                                                px-2.5
                                                py-1.5
                                                rounded-lg
                                                bg-[#F1F4FA]
                                                text-[#102A71]
                                                text-[10px]
                                            "
                                        >
                                            {{ $toko->nama_toko }}
                                        </span>

                                    @empty

                                        <span class="text-xs text-gray-400">
                                            Belum ada toko dalam group ini.
                                        </span>

                                    @endforelse

                                </div>

                            </div>

                        @empty

                            <div class="py-6 text-center text-sm text-gray-400">
                                Belum ada group operasional.
                            </div>

                        @endforelse

                    </div>

                    {{-- AKTIVITAS TERBARU --}}
                    <div
                        class="
                            xl:col-span-5
                            min-w-0
                            bg-white
                            rounded-2xl
                            border border-gray-200
                            p-5 md:p-6
                        "
                    >

                        {{-- HEADER --}}
                        <div
                            class="
                                flex
                                items-start
                                justify-between
                                gap-4
                                mb-5
                            "
                        >

                            <div class="min-w-0">

                                <h2
                                    class="
                                        text-base
                                        font-bold
                                        text-[#001840]
                                    "
                                >
                                    Aktivitas Terbaru
                                </h2>

                                <p class="mt-1 text-xs text-gray-400">
                                    Aktivitas sistem terbaru
                                </p>

                            </div>

                            <a
                                href="{{ route('superadmin.audit.index') }}"
                                class="
                                    shrink-0
                                    whitespace-nowrap
                                    text-xs
                                    font-semibold
                                    text-[#102A71]
                                    hover:text-[#F5C400]
                                    transition
                                "
                            >
                                Audit Log →
                            </a>

                        </div>

                        {{-- AKTIVITAS DARI DATABASE --}}
                        @forelse ($activities as $activity)

                            <div class="flex gap-3 py-3 border-b border-gray-100 last:border-b-0">

                                <div
                                    class="
                                        w-2
                                        h-2
                                        mt-1.5
                                        rounded-full
                                        bg-[#F5C400]
                                        shrink-0
                                    "
                                ></div>

                                <div class="min-w-0">

                                    <p class="text-xs leading-relaxed text-gray-600">

                                        <strong class="text-[#001840]">
                                            {{ $activity->actor_name ?: 'Sistem' }}
                                        </strong>

                                        {{ $activity->description ?: $activity->action }}

                                    </p>

                                    <p class="mt-1 text-[10px] text-gray-400">
                                        {{ $activity->created_at
                                            ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans()
                                            : '-' }}
                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="py-6 text-center text-sm text-gray-400">
                                Belum ada aktivitas tercatat.
                            </div>

                        @endforelse

                    </div>

                </section>

            </div>

        </main>

    </div>

</body>

</html>
