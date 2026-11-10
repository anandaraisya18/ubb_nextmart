{{-- resources/views/admin/components/topbar.blade.php --}}

@php
    // Ambil data admin yang sedang login
    $admin = auth('admin')->user();

    // Ambil nama dari akun admin
    $adminName = $admin?->nama_admin
        ?? $admin?->nama
        ?? $admin?->name
        ?? $admin?->username
        ?? session('admin_nama')
        ?? 'Admin';

    // Ambil huruf pertama nama untuk avatar
    $adminInitial = mb_strtoupper(
        mb_substr($adminName, 0, 1)
    );

    // Ambil notifikasi Laravel jika sistem sudah tersedia
    $adminNotifications = collect();

    if (
        $admin &&
        method_exists($admin, 'notifications') &&
        \Illuminate\Support\Facades\Schema::hasTable('notifications')
    ) {
        $adminNotifications = $admin->notifications()
            ->latest()
            ->limit(20)
            ->get();
    }

    $unreadCount = $adminNotifications
        ->whereNull('read_at')
        ->count();

    // Halaman pesanan yang sudah ada
    $ordersUrl = route('admin.orders.index');
@endphp

<header
    class="
        h-20
        bg-white
        border-b border-gray-200
        flex items-center
        justify-between
        px-5 md:px-8
        sticky top-0
        z-30
        w-full
    "
>

    {{-- LEFT --}}
    <div class="flex items-center gap-4 min-w-0">

        {{-- Mobile Menu --}}
        <button
            type="button"
            onclick="toggleSidebar()"
            class="
                lg:hidden
                w-10 h-10
                rounded-xl
                bg-[#001840]
                text-white
                flex items-center justify-center
                hover:bg-[#102A71]
                transition
                shrink-0
            "
        >
            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path
                    d="M4 6h16M4 12h16M4 18h16"
                    stroke-linecap="round"
                />
            </svg>
        </button>

        {{-- Page Title --}}
        <div class="min-w-0">

            <h2 class="text-lg md:text-xl font-bold text-[#001840] truncate">
                {{ $title ?? 'Dashboard' }}
            </h2>

            <p class="hidden md:block text-xs text-gray-500 mt-0.5">
                {{ $subtitle ?? 'Pusat kendali UBB Nextmart' }}
            </p>

        </div>

    </div>


    {{-- RIGHT --}}
    <div class="flex items-center gap-3 md:gap-5 shrink-0">

        {{-- NOTIFICATION --}}
        <div
            id="adminNotificationWrapper"
            class="relative"
        >

            {{-- Tombol Lonceng --}}
            <button
                type="button"
                id="adminNotificationButton"
                aria-label="Buka notifikasi"
                aria-expanded="false"
                aria-controls="adminNotificationDropdown"
                class="
                    relative
                    w-10 h-10
                    rounded-xl
                    flex items-center justify-center
                    text-gray-500
                    hover:bg-gray-100
                    hover:text-[#102A71]
                    transition
                    cursor-pointer
                "
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                    />

                    <path
                        d="M13.73 21a2 2 0 0 1-3.46 0"
                    />
                </svg>

                {{-- Badge jumlah belum dibaca --}}
                @if($unreadCount > 0)
                    <span
                        class="
                            absolute
                            top-0 right-0
                            min-w-4 h-4
                            px-1
                            rounded-full
                            bg-[#F5C400]
                            text-[#001840]
                            text-[9px]
                            font-bold
                            flex items-center justify-center
                            border border-white
                        "
                    >
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif

            </button>


            {{-- DROPDOWN NOTIFIKASI --}}
            <div
                id="adminNotificationDropdown"
                class="
                    hidden
                    absolute
                    right-0
                    top-full
                    mt-3
                    w-80 sm:w-96
                    max-w-[calc(100vw-2rem)]
                    bg-white
                    rounded-2xl
                    border border-gray-200
                    shadow-xl
                    overflow-hidden
                    z-50
                "
            >

                {{-- Header Dropdown --}}
                <div
                    class="
                        px-5 py-4
                        border-b border-gray-100
                        flex items-center
                        justify-between
                        bg-white
                    "
                >

                    <div>
                        <h3 class="text-sm font-bold text-[#001840]">
                            Notifikasi
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $unreadCount }} belum dibaca
                        </p>
                    </div>

                    <div
                        class="
                            w-9 h-9
                            rounded-xl
                            bg-[#102A71]/10
                            text-[#102A71]
                            flex items-center justify-center
                        "
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                            />
                            <path
                                d="M13.73 21a2 2 0 0 1-3.46 0"
                            />
                        </svg>
                    </div>

                </div>


                {{-- DAFTAR NOTIFIKASI --}}
                <div class="max-h-80 overflow-y-auto">

                    @forelse($adminNotifications as $notification)

                        @php
                            $data = $notification->data ?? [];

                            $notificationTitle = $data['title']
                                ?? $data['judul']
                                ?? 'Notifikasi Baru';

                            $notificationMessage = $data['message']
                                ?? $data['pesan']
                                ?? 'Ada aktivitas baru pada sistem.';

                            $isUnread = is_null($notification->read_at);
                        @endphp

                        <a
                            href="{{ $ordersUrl }}"
                            class="
                                block
                                px-5 py-4
                                border-b border-gray-100
                                hover:bg-gray-50
                                transition
                                {{ $isUnread ? 'bg-blue-50/60' : '' }}
                            "
                        >

                            <div class="flex items-start gap-3">

                                {{-- Ikon Pesanan --}}
                                <div
                                    class="
                                        w-10 h-10
                                        rounded-xl
                                        bg-[#102A71]/10
                                        text-[#102A71]
                                        flex items-center justify-center
                                        shrink-0
                                    "
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M3 7h18v13H3zM7 7V4h10v3M3 12h18"
                                        />
                                    </svg>
                                </div>

                                {{-- Isi Notifikasi --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex items-start gap-2">

                                        <p class="text-sm font-semibold text-[#001840] flex-1">
                                            {{ $notificationTitle }}
                                        </p>

                                        @if($isUnread)
                                            <span
                                                class="
                                                    w-2 h-2
                                                    rounded-full
                                                    bg-[#F5C400]
                                                    shrink-0 mt-1
                                                "
                                            ></span>
                                        @endif

                                    </div>

                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ $notificationMessage }}
                                    </p>

                                    <p class="text-[11px] text-gray-400 mt-2">
                                        {{ $notification->created_at?->diffForHumans() }}
                                    </p>

                                </div>

                            </div>

                        </a>

                    @empty

                        {{-- Tampilan Belum Ada Notifikasi --}}
                        <div class="px-6 py-10 text-center">

                            <div
                                class="
                                    w-14 h-14
                                    mx-auto mb-4
                                    rounded-full
                                    bg-gray-100
                                    flex items-center justify-center
                                "
                            >
                                <svg
                                    class="w-7 h-7 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                                    />

                                    <path
                                        d="M13.73 21a2 2 0 0 1-3.46 0"
                                    />
                                </svg>
                            </div>

                            <h4 class="text-sm font-semibold text-[#001840]">
                                Belum Ada Notifikasi
                            </h4>

                            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                                Belum ada notifikasi yang tercatat
                                untuk akun Admin ini.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- Footer --}}
                <div class="border-t border-gray-100 p-3">

                    <a
                        href="{{ $ordersUrl }}"
                        class="
                            block
                            w-full
                            text-center
                            text-xs
                            font-semibold
                            text-[#102A71]
                            hover:bg-gray-50
                            rounded-lg
                            py-2.5
                            transition
                        "
                    >
                        Lihat Semua Pesanan
                    </a>

                </div>

            </div>

        </div>


        {{-- Divider --}}
        <div class="hidden md:block w-px h-8 bg-gray-200"></div>


        {{-- PROFILE --}}
        <div class="flex items-center gap-3">

            {{-- Avatar Admin --}}
            <div
                class="
                    w-9 h-9
                    rounded-full
                    bg-[#102A71]
                    text-[#F5C400]
                    flex items-center justify-center
                    font-bold
                    text-xs
                    shrink-0
                "
            >
                {{ $adminInitial }}
            </div>

            {{-- Nama Admin --}}
            <div class="hidden md:block min-w-0">

                <p
                    class="
                        text-sm
                        font-semibold
                        text-[#001840]
                        truncate
                    "
                    title="{{ $adminName }}"
                >
                    {{ $adminName }}
                </p>

                {{-- Role Admin --}}
                <p class="text-[10px] text-gray-400">
                    Administrator
                </p>

            </div>

        </div>

    </div>

</header>


{{-- JAVASCRIPT NOTIFIKASI --}}
<script>
(function () {

    const wrapper = document.getElementById(
        'adminNotificationWrapper'
    );

    const button = document.getElementById(
        'adminNotificationButton'
    );

    const dropdown = document.getElementById(
        'adminNotificationDropdown'
    );

    if (!wrapper || !button || !dropdown) {
        return;
    }

    // Buka atau tutup dropdown
    button.addEventListener('click', function (event) {

        event.stopPropagation();

        const isHidden = dropdown.classList.contains('hidden');

        dropdown.classList.toggle('hidden', !isHidden);

        button.setAttribute(
            'aria-expanded',
            isHidden ? 'true' : 'false'
        );

    });

    // Klik di luar untuk menutup dropdown
    document.addEventListener('click', function (event) {

        if (!wrapper.contains(event.target)) {

            dropdown.classList.add('hidden');

            button.setAttribute('aria-expanded', 'false');

        }

    });

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            dropdown.classList.add('hidden');

            button.setAttribute('aria-expanded', 'false');

            button.focus();

        }

    });

})();
</script>
