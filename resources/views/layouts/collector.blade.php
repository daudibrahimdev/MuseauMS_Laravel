<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Museau MS - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,900&display=swap" rel="stylesheet" />

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    @stack('styles') </head>
<body>

    @include('collector.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('collector.partials.footer')

    <script>
        feather.replace();
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts') </body>
</html>