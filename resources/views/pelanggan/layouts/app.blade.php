<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'UBB Nextmart')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50 text-[#001840]">

    {{-- Navbar --}}
    @include('pelanggan.components.navbar')

    {{-- Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('pelanggan.components.footer')

    {{-- Alert --}}
    @include('pelanggan.components.alert')

    @stack('scripts')

</body>

</html>