<!DOCTYPE html>
<html>
@section("appname","MonAchatRoule")
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("appname")</title>
    <link rel="icon" type="image/x-icon"
    href="https://media.discordapp.net/attachments/1149051976550731906/1149052038769016862/Logo-Slogan.png?width=585&height=585">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> il faut compiler des trucs avec des commandes yarn et utiliser laravel mix --}}
    @include("partials.css_site")
</head>
<body>
    @include('partials.xheader')
    <h1 id="xtitle">
        @yield("title"){{--ici on mettra le nom de la page, doit etre défini dans le yield  --}}
    </h1>

    <div class="container">
        @yield('content')
    </div>

    {{-- @include('xfooter') --}}
</body>
</html>
