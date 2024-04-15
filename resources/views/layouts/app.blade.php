<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mondarc') }}</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.4.6.2.css')}}" />
    <script src="{{asset('js/jquery_v3.5.1.js')}}"></script>

</head>
<body>
    <div id="app">
        <main class="py-0">
            @yield('content')
        </main>
    </div>
</body>
</html>
