<!DOCTYPE html>
<html>
@section("appname","MonAchatRoule")
<head>
    @vite('resources/js/app.js')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("appname")</title>
    <link rel="icon" type="image/x-icon"
    href="https://media.discordapp.net/attachments/1149051976550731906/1149052038769016862/Logo-Slogan.png?width=585&height=585">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css'])
    @stack('css')
</head>
<body>
    @include('partials.xheader')
    <h1 id="xtitle">
        @yield("title"){{--ici on mettra le nom de la page, doit etre défini dans le yield  --}}
    </h1>


    @yield('content')


    {{-- @include('xfooter') --}}
</body>
</html>