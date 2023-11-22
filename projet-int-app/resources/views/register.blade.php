@extends('partials.xlayout')


@section('title')
    <h1 id="xtitle">Création de compte</h1>
@endsection
<script type="module">
    $(()=>{
        initFormValidation();
    })
</script>
@section('content')

    <form action="/register" method="POST" style="width:350px; margin:auto;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Prénom</label>
            <div class="grid-icon-input">
                <i class="fas fa-user fa-lg icon-in-grid"></i>
                <input 
                    type="text" 
                    class="form-control Alpha" 
                    name="name" 
                    id="name"
                    placeholder="Nom" 
                    RequireMessage="Veuillez entrer votre prénom"
                    InvalidMessage="Caractère illégal"
                    value="{{ old('name') }}"
                    required>
            </div>
            <div class="info">
                @error('name')
                    <div class="erreur" style="float: left;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Nom</label>
            <div class="grid-icon-input">
                <i class="fas fa-user fa-lg icon-in-grid"></i>
                <input 
                    type="text" 
                    class="form-control Alpha" 
                    name="surname" 
                    id="surname" 
                    RequireMessage="Veuillez entrer votre nom"
                    InvalidMessage="Caractère illégal"
                    value="{{ old('surname') }}"
                    required>
            </div>
            <div class="info">
                @error('surname')
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <div class="grid-icon-input">
                <i class="fas fa-user fa-lg icon-in-grid "></i>
                <input 
                    type="text" 
                    class="form-control AlphaNumeric" 
                    name="username" 
                    id="username"
                    value="{{ old('username') }}" 
                    required>
            </div>
            <div class="info">

                @error('username')
                    <div class="erreur">{{ $message }}</div>
                @enderror

            </div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <div class="grid-icon-input">
                <i class="fas fa-mobile fa-lg icon-in-grid" style="margin-left:.45em"></i>
                <input 
                    type="tel" 
                    class="form-control Phone" 
                    name="phone" 
                    id="phone" 
                    value="{{ old('phone') }}"
                    required>
            </div>
            <div class="info">
                @error('phone')
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Courriel</label>
            <div class="grid-icon-input">
                <i class="fas fa-envelope fa-lg icon-in-grid"></i>
                <input
                 class="form-control Email" 
                 name="email" 
                 id="email" 
                 value="{{ old('email') }}"
                 RequireMessage="Veuillez entrer votre adresse de courriel"
                 InvalidMessage="Veuillez entrer un courriel valide" 
                 required
                />
            </div>
            <div class="info">
                @error('email')     
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="grid-icon-input" style="grid-template-columns:35px auto 0px; ">
                <i class="fas fa-lock fa-lg icon-in-grid"></i>
                <input 
                    type="password" 
                    class="form-control " 
                    name="password" 
                    id="password" 
                    CustomErrorMessage="Le mot de passe ne correspond pas à sa confirmation"
                    required>
                <span class="icon fa fa-eye-slash" id="toggleShowPassword"></span>
            </div>
            <div class="info">
                @error('password')
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirmez votre mot de passe</label>
            <div class="grid-icon-input">
                <i class="fas fa-lock fa-lg icon-in-grid"></i>
                <input 
                    type="password" 
                    class="form-control MatchedInput" 
                    name="password_confirmation" 
                    id="password_confirm"
                    matchedInputId="password"
                    CustomErrorMessage="Le mot de passe ne correspond pas à sa confirmation"
                    required>
            </div>
        </div>
        <div class="info"></div>
        <div class="mb-3 form-check">
            <input type="checkbox" id="email_notification" name="email_notification">
            <label class="form-check-label" for="email_notification">Activer le suivi d'annonces par courriel</label>
        </div>
        <button type="submit" class="btn btn-lg btn-primary d-flex justify-content-center"
            style="width:200px;margin:auto;">Créer</button>
    </form>
    <script type="module">
        $(
            function() {
                //$.toast("tes3");

            }
        );
    </script>
    <div class="mb-3 signForm signin mt-5">
        <p>Vous avez déjà un compte?<a href="{{ url('/login') }}"><br> Connectez vous</a>.</p>
    </div>

@endsection
