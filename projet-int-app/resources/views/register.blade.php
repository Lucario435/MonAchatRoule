@extends('partials.xlayout')

@section('title', 'Création de compte')

@section('content')

@include("partials.css_login&register")

    <form action="{{ url("/register") }}" method="POST">
        @csrf
        <div class="container text-center">
            <div class="row">
              <div class="col">
                <label for="username"><b>Nom d'utilisateur</b></label>
              </div>
            </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col align-self-center">             
                  <div class="label-row-data ">
                    <i class="bi bi-envelope fill-blue"></i>
                    <input type="text" placeholder="Courriel" name="email" id="email" required>
                  </div>
                </div>
                <div class="col">
                    
                </div>
            </div>
            <div class="row">
                <div class="col">
                  <label for="phone"><b>Numéro de téléphone</b></label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                  <label for="password"><b>Mot de passe</b></label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                  <label for="password_confirm"><b>Mot de passe</b></label>
                </div>
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
