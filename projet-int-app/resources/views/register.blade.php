@extends('partials.xlayout')

@section('title', 'Création de compte')

@section('content')

{{-- @include("partials.css_login&register") --}}

@push('css')
  @vite(['resources/css/register.css'])
@endpush

    <form action="{{ url("/register") }}" method="POST" style="height:300px">
        @csrf
        <div class="d-flex h-5 justify-content-center p-1 bg-secondary text-white">
            <div class="p-2 bg-info">
              <span class="blue-block"></span>
              <input type="text" placeholder="Courriel" name="email" id="email" required>
            </div>
        </div>
        <div class="d-flex h-10 justify-content-center p-1 bg-secondary text-white">
            <div class="p-2 bg-info">
              <span class="blue-block"></span>
              <input type="text" placeholder="Confirmez votre courriel" name="email_confirm" id="email_confirm" required>
            </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1 bg-secondary text-white">
          <div class="p-2 bg-info">
            <span class="blue-block"></span>
            <input type="text" placeholder="Nom d'utilisateur" name="email" id="email" required>
          </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1 bg-secondary text-white">
          <div class="p-2 bg-info">
            <span class="blue-block"></span>
            <input type="text" placeholder="Mot de passe" name="password" id="password" required>
          </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1 bg-secondary text-white">
          <div class="p-2 bg-info">
            <span class="blue-block"></span>
            <input type="text" placeholder="Confirmez le mot de passe" name="password_confirm" id="password_confirm" required>
          </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1 bg-secondary text-white">
          <div class="p-2 bg-info">
            <label for="notication">Activer les alertes courriel sur les annonces suivies</label>
            <input type="checkbox" name="notification">
          </div>
        </div>
        <div class="d-flex h-15 justify-content-center p-1 bg-secondary text-white">
          <div class="p-2 bg-info">
            <input type="submit" value="Créer">
          </div>
        </div>

        {{-- <div class="container signForm">
            <p class="petitp">Veuillez remplir vos renseignements</p>
            <br>
            <label for="email"><b>Courriel</b></label>
            <input type="text" placeholder="Entrez votre courriel" name="email" id="email" required>
            <label for="rusername"><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrez votre nom d'utilisateur" name="rusername" id="rusername" required>

            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>
            <label  for="pswc"><b>Confirmation de mot de passe</b></label>
            <input type="password" placeholder="Confirmez votre mot de passe" name="pswc" id="pswc" required>
            <br> <br>
            <label for="emailnotifs"><b>Notifications Par Courriel?</b></label>
            <select name="emailnotifs" id="emailnotifs">
                <option value="yes" selected>Oui</option>
                <option value="no">Non</option>
            </select>
            <br> <br>
            <button type="submit" class="registerbtn">Confirmer</button>
        </div> --}}

        <div class="signForm signin">
            <p>Vous avez déjà un compte?<a href="{{ url("/login") }}"> Connectez vous</a>.</p>
        </div>
    </form>
    

@endsection
