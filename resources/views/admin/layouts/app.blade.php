<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | UBB Nexmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fc] text-gray-800">

    @include('admin.components.sidebar')

    <main class="min-h-screen lg:ml-64">

        @include('admin.components.topbar', [
            'title'    => trim($__env->yieldContent('title', 'Admin')),
            'subtitle' => trim($__env->yieldContent('subtitle', '')),
        ])

        <section class="p-4 sm:p-5 md:p-7 lg:p-8">
            @yield('content')
        </section>

    </main>

</body>
</html>