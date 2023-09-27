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
                    <input type="text" placeholder="Prénom" name="name" id="name" required value="{{old('name')}}">
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('name')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="surname" class="blue-block icon icon-user"></label>
                    <input type="text" placeholder="Nom" name="surname" id="surname" required value="{{old('surname')}}">
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('surname')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="username" class="blue-block icon icon-user"></label>
                    <input type="text" placeholder="Nom d'utilisateur" name="username" id="username" required value="{{old('username')}}">
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('username')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-5 justify-content-center pe-2 text-white">
                <div class="p-2">
                    <label for="phone" class="blue-block icon icon-phone"></label>
                    <input type="text" placeholder="Numéro de téléphone" name="phone" id="phone" required value="{{old('phone')}}">
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('phone')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-5 justify-content-center pe-2    text-white">
                <div class="p-2">
                    <label for="email" class="blue-block icon icon-mail"></label>
                    <input type="email" placeholder="Courriel" name="email" id="email" required value="{{old('email')}}">
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('email')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-15 justify-content-center pe-2 text-white">
                <div class="col-md-6 align-items-center">
                    <label for="password" class="blue-block icon icon-password"></label>
                    <input type="password" placeholder="Mot de passe" name="password" id="password" required>
                    <i class="togglePassword fa fa-fw fa-eye"></i>
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('password')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <div class="d-flex h-15 justify-content-center pe-2    text-white">
                <div class="p-2 ">
                    <label for="password_confirm" class="blue-block icon icon-password"></label>
                    <input type="password" placeholder="Confirmez le mot de passe" name="password_confirmation"
                        id="password_confirm" required>
                </div>
            </div>
            <div class="d-flex h-15 w-15 justify-content-center pe-2 text-white">
                <div class="p-2">                  
                    @error('password_confirm')
                     <div class="erreur">{{$message}}</div>   
                    @enderror
                </div>
            </div>

            <hr>
            <div class="d-flex h-15 justify-content-center text-white">
                <div class="p-2 notification">
                    <input type="checkbox" name="email_notification" id="email_notification" value="{{old('email_notification')}}">
                    <label for="email_notification">Activer le suivi d'annonces par courriel</label>
                </div>
            </div>
            <hr>
            <div class="d-flex h-15 justify-content-center text-white">
                <div class="d-grid gap-2 mw-35 col-6 mx-auto">
                    <input class="btn btn-primary" type="submit" value="Créer">
                </div>
            </div>
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            @endif
        </form>
    </div>

@endsection
