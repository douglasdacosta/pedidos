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
    <img src='data:image/png;base64,{{base64_encode(file_get_contents(public_path('imagens/Logo_fundo.png')))}}' style='opacity: 0.1; position: fixed; left: 5%; top: 15%; width: 90%; height: 60%; z-index: 0; pointer-events: none;'>
    <div id="app">
        <main class="py-0">
            @yield('content')
        </main>
    </div>
</body>
</html>
