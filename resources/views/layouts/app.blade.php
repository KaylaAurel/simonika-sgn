<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SIMONIKA SGN')
    </title>

    <meta
        name="description"
        content="@yield(
            'meta_description',
            'SIMONIKA SGN - Sistem Monitoring Karyawan SGN'
        )"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="@yield('body_class')">

    @yield('content')

    @stack('scripts')

</body>
</html>