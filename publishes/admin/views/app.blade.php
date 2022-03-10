<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link href="{{ asset('/css/{{ name }}/app.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/{{ name }}/app.js') }}" defer></script>
    </head>
    <body>
        @inertia
    </body>
</html>