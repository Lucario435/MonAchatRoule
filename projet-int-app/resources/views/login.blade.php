@extends('partials.xlayout')
@push('css')
    @vite(['resources/css/register.css'])
@endpush
@section('title', 'Accédez à votre compte')

@section('content')
    <form action="{{ url("/login") }}" method="POST">
        @csrf
        <div class="signForm">
            <p class="petitp">Connexion</p>
            <label for="email"><b>Courriel</b></label>
            <input type="text" placeholder="Entrez votre courriel" name="email" id="email" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>
            <br> <br>
            <button type="submit" class="registerbtn">Se connecter</button>
        </div>

        <div class="signForm signin">
            <p>Vous n'avez pas de compte?<a href="{{ url('/register') }}"> Inscrivez vous</a>.</p>
        </div>
    </form>

    @include('partials.css_login&register')
@endsection
