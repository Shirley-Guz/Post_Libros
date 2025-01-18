<!---path/resources\views\layouts\app.blade.php--->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="shortcut icon" href="/images/template/sappl.png" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <title>Post de Libros</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        @livewireStyles

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>

        {{-- * Page Content --}}
        <main>
            {{ $slot }}
        </main>

        @livewireScripts

    </body>
    <script src="//unpkg.com/alpinejs" defer></script>
</html>