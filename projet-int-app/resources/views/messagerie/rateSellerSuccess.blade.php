@extends('partials.xlayout')

@section('title', "Évaluations")

@section('content')
    {{-- <h1>Bienvenue sur la page d'accueil</h1> --}}
    <div class="div1x">
        <span>Votre évaluation a bien été enregistré</span>
        @auth
        <br>
        <span>Merci d'avoir évalué votre achat, {{ Auth::user()->getDisplayName() }} !</span>
        <br>
        <span>Il consistera un bon indicateur aux prochains visiteurs.</span>
        @endauth
        <br><br>
        <a class="btn btn-primary" href="{{ route("notifications") }}">Retour aux notifications</a>
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
