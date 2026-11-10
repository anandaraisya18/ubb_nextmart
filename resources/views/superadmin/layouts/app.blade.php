<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name', 'UBB Nextmart'))
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>


<body class="min-h-screen bg-[#F5F7FC] text-gray-800">

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    @include('superadmin.components.sidebar')


    {{-- =====================================================
         MAIN AREA
    ====================================================== --}}

    <div class="min-h-screen lg:pl-64">

        {{-- =================================================
             TOPBAR
        ================================================== --}}

        @include('superadmin.components.topbar', [
            'title' => View::hasSection('page-title')
                ? View::getSection('page-title')
                : 'Superadmin',

            'subtitle' => View::hasSection('page-subtitle')
                ? View::getSection('page-subtitle')
                : 'Kelola sistem UBB Nextmart secara terpusat',
        ])


        {{-- =================================================
             PAGE CONTENT
        ================================================== --}}

        <main class="w-full min-w-0">

            <div class="w-full min-w-0 px-5 py-6 md:px-8 md:py-8">

                <div class="mx-auto w-full max-w-[1600px] min-w-0">

                    @yield('content')

                </div>

            </div>

        </main>

    </div>


    {{-- =====================================================
         SCRIPTS
    ====================================================== --}}

    @stack('scripts')

</body>

</html>