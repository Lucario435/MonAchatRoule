@extends('partials.xlayout')

@push('js')
    <script type="text/javascript" src="{{ URL::asset ('js/validation.js') }}"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ URL::asset ('css/register.css') }}">
@endpush

@section('title')
    <h1 id="xtitle" class="text-center m-3" style="font-size: 28px;">Création de compte</h1>
@endsection

@section('content')

    <form class="center-childrens" action="/register" method="POST" >
        @csrf

        <fieldset id="identifiants-fieldset">
            <legend style="float:none;width:auto;">Identifiants</legend>
            <div class="mb-3">
                <label for="name" class="form-label">Prénom</label>
                <div class="grid-icon-input">
                    <i class="fas fa-user fa-lg icon-in-grid"></i>
                    <input
                        type="text"
                        class="form-control Alpha padding-input"
                        name="name"
                        id="name"
                        placeholder="Prénom"
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
                        placeholder="Nom"
                        class="form-control Alpha padding-input"
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
                <label for="username" class="form-label">Pseudonyme</label>
                <div class="grid-icon-input">
                    <i class="fas fa-user fa-lg icon-in-grid "></i>
                    <input
                        type="text"
                        class="form-control AlphaNumeric padding-input"
                        name="username"
                        id="username"
                        value="{{ old('username') }}"
                        placeholder="Pseudonyme"
                        RequireMessage="Veuillez entrer un pseudonyme"
                        required>
                </div>
                <div class="info">
                    @error('username')
                        <div class="erreur">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </fieldset>
        
        <div class="info"></div>
        
        <fieldset id="coordonnees-fieldset">
            <legend style="float:none;width:auto;">Coordonnées</legend>
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <div class="grid-icon-input">
                    <i class="fas fa-mobile fa-lg icon-in-grid" style="margin-left:.45em"></i>
                    <input
                        type="tel"
                        class="form-control Phone padding-input"
                        name="phone"
                        id="phone"
                        value="{{ old('phone') }}"
                        RequireMessage="Veuillez entrer un numéro de téléphone"
                        placeholder="(123) 424-1212"
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
                     class="form-control Email  padding-input"
                     name="email"
                     id="email"
                     value="{{ old('email') }}"
                     RequireMessage="Veuillez entrer votre adresse de courriel"
                     InvalidMessage="Veuillez entrer un courriel valide"
                     placeholder="Courriel"
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
                <div class="grid-icon-input " style="grid-template-columns:0px auto 0px; ">
                    <i class="fas fa-lock fa-lg icon-in-grid"></i>
                    <input
                        type="password"
                        class="form-control padding-input"
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
                        class="form-control MatchedInput padding-input"
                        name="password_confirmation"
                        id="password_confirm"
                        matchedInputId="password"
                        CustomErrorMessage="Le mot de passe ne correspond pas à sa confirmation"
                        required>
                </div>
            </div>
        </fieldset>

        <div class="info"></div>

        <fieldset id="alertes-fieldset">
            <legend style="float:none;width:auto;">Alertes</legend>
            <div class="mb-3 form-check ">
                <input class=" d-flex align-items-baseline" type="checkbox" id="email_notification" name="email_notification">
                <label class="form-check-label px-2" for="email_notification">Notifications par courriel</label>
            </div>
        </fieldset>
        
        <button type="submit" class="btn btn-lg btn-primary d-flex justify-content-center"
            style="width:200px;margin-top:50px;margin-bottom:50px;">Créer</button>
    
            <div class="mb-3 signForm signin">
                <p>Vous avez déjà un compte?<a href="{{ url('/login') }}"><br> Connectez vous</a>.</p>
            </div>
    </form>
    @include('partials.xfooter')
@endsection
