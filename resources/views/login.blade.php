@extends('partials.xlayout')
@push('css')
    <link rel="stylesheet" href="{{ URL::asset('css/register.css') }}">
@endpush

@section('title')
    <div id="xtitle">Se connecter</div>
@endsection
@section('content')
    <form class="center-childrens" action="/login" method="POST" style="padding:5px;">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Courriel</label>
            <div class="grid-icon-input">
                <span class="fas fa-envelope fa-lg icon-in-grid"></span>
                <input type="email" class="form-control padding-input" name="email" id="email" value="{{ old('email') }}"
                    required>
            </div>
            <div class="info">
                @error('email')
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="grid-icon-input" style="grid-template-columns:0px auto 0px; ">
                <i class="fas fa-lock fa-lg icon-in-grid"></i>
                <input  type="password" class="form-control padding-input" name="password" id="password" required>
                <span class="icon fa fa-eye-slash" id="toggleShowPassword"></span>
            </div>
            <div class="info">
                @error('password')
                    <div class="erreur">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-lg btn-primary d-flex justify-content-center"
            style="width:200px;margin:auto;">Se connecter</button>

    </form>
    <div class="mb-3 signForm signin mt-5">
        <p>Pas encore de compte?<a href="{{ url('/register') }}"><br> Inscrivez-vous</a>.</p>
    </div>
    @error('error')
        <div class="erreur text-center pt-5">{{ @$message }}</div>
    @enderror
@endsection
