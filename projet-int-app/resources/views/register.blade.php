@extends('partials.xlayout')

@section('title', 'Création de compte')

@section('content')

    {{-- @include("partials.css_login&register") --}}
    @push('js')
      @vite(['resources/js/notification_checkbox_to_bool.js']);
    @endpush
    @push('css')
        @vite(['resources/css/register.css'])
    @endpush
    <div class="container-xxl" style="width:600px;">
        <form class="" action="/register" method="POST" style="height:300px">
            @csrf

            <div class="signForm signin">
                <p>Vous avez déjà un compte?<a href="{{ url('/login') }}"><br> Connectez vous</a>.</p>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="name" class="blue-block icon icon-user"></label>
                    <input type="text" placeholder="Prénom" name="name" id="name" required>
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="surname" class="blue-block icon icon-user"></label>
                    <input type="text" placeholder="Nom" name="surname" id="surname" required>
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="username" class="blue-block icon icon-user"></label>
                    <input type="text" placeholder="Nom d'utilisateur" name="username" id="username" required>
                </div>
            </div>
            <div class="d-flex h-5 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="phone" class="blue-block icon icon-phone"></label>
                    <input type="text" placeholder="Numéro de téléphone" name="phone" id="phone" required>
                </div>
            </div>
            <div class="d-flex h-5 justify-content-center pe-2    text-white">
                <div class="p-2">
                    <label for="email" class="blue-block icon icon-mail"></label>
                    <input type="email" placeholder="Courriel" name="email" id="email" required>
                </div>
            </div>
            <div class="d-flex h-15 justify-content-center pe-2    text-white">
                <div class="p-2 ">
                    <label for="password" class="blue-block icon icon-password"></label>
                    <input type="password" placeholder="Mot de passe" name="password" id="password" required>
                </div>
            </div>
            <div class="d-flex h-15 justify-content-center pe-2    text-white">
                <div class="p-2 ">
                    <label for="password_confirm" class="blue-block icon icon-password"></label>
                    <input type="password" placeholder="Confirmez le mot de passe" name="password_confirm"
                        id="password_confirm" required>
                </div>
            </div>
            <hr>
            <div class="d-flex h-15 justify-content-center text-white">
                <div class="p-2 notification">
                    <input type="checkbox" name="notification" id="notification" value="false">
                    <label for="notification">Activer le suivi d'annonces par courriel</label>
                </div>
            </div>
            <hr>
            <div class="d-flex h-15 justify-content-center text-white">
                <div class="d-grid gap-2 mw-35 col-6 mx-auto">
                    <input class="btn btn-primary" type="submit" value="Créer">
                </div>
            </div>

        </form>
    </div>

@endsection
