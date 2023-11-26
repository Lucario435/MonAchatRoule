@extends('partials.xlayout')

@section('title', "Ventes")

@section('content')
    {{-- <h1>Bienvenue sur la page d'accueil</h1> --}}
    <div class="div1x">
        <span>L'acheteur a bel et bien été enregistré.</span>
        @auth
        <br>
        <span>Félicitation pour votre vente, {{ Auth::user()->getDisplayName() }} !</span>
        @endauth
        <br><br>
        <a class="btn btn-primary" href="{{ route("index") }}">Retour</a>
    </div>

@endsection

<style>
    .div1x{
        text-align: center;
        /* background: rgb(220, 239, 255); */
        padding-top: 20px;
        padding-bottom: 20px;
    }
</style>
