@extends('partials.xlayout')

@section('title', 'Création de compte')

@section('content')

{{-- @include("partials.css_login&register") --}}

@push('css')
  @vite(['resources/css/register.css'])
@endpush
<div class="container-xxl ">
    <form action="{{ url("/register") }}" method="POST" style="height:300px">
        @csrf
        <div class="d-flex h-15 w-15 justify-content-center p-1  text-white">
            <div class="p-2">
              <span class="blue-block icon icon-user"></span>
              <input type="text" placeholder="Nom d'utilisateur" name="email" id="email" required>
            </div>
          </div>
          <div class="d-flex h-5 justify-content-center p-1  text-white">
            <div class="p-2">
                <span class="blue-block icon icon-phone"></span>
                <input type="text" placeholder="Numéro de téléphone" name="phone" id="phone" required>
            </div>
        </div>
        <div class="d-flex h-5 justify-content-center p-1  text-white">
            <div class="p-2">
                <span class="blue-block icon icon-mail"></span>
                <input type="text" placeholder="Courriel" name="email" id="email" required>
            </div>
        </div>
        {{-- <div class="d-flex h-10 justify-content-center p-1  text-white">
            <div class="p-2 bg-info">
              <span class="blue-block icon icon-mail"></span>
              <input type="text" placeholder="Confirmez votre courriel" name="email_confirm" id="email_confirm" required>
            </div>
        </div> --}}

        <div class="d-flex h-15 justify-content-center p-1  text-white">
          <div class="p-2 ">
            <span class="blue-block icon icon-password"></span>
            <input type="password" placeholder="Mot de passe" name="password" id="password" required>
          </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1  text-white">
          <div class="p-2 ">
            <span class="blue-block icon icon-password"></span>
            <input type="password" placeholder="Confirmez le mot de passe" name="password_confirm" id="password_confirm" required>
          </div>
        </div>
        <hr >
        <div class="d-flex h-15 justify-content-center p-1 text-white">
            <div class="p-2 notification">
                <input type="checkbox" name="notification" id="notification">                
                <label for="notification">Activer le suivi d'annonces par courriel</label>
            </div>
        </div>
        <hr >
        <div class="d-flex h-15 justify-content-center p-1  text-white">
            <div class="p-2 ">
                <input type="submit" value="Créer">
          </div>
        </div>
        <div class="signForm signin">
            <p>Vous avez déjà un compte?<a href="{{ url("/login") }}"> Connectez vous</a>.</p>
        </div>
    </form>
</div>    

@endsection
