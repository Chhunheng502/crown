<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="/css/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">

        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

        <title>{{ $title }}</title>
    </head>
    <body class="font-serif">

        @include('components._navbar')
        
        {{ $content }}

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
