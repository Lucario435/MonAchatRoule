@extends('partials.xlayout')

@section('title', "Signalements")

@section('content')
    {{-- <h1>Bienvenue sur la page d'accueil</h1> --}}
    <div class="div1x">
        <span>Votre signalement a été reçu avec succès.</span>
        <br>
        <span>Notre équipe se prépare à la résoudre.</span>
        <br><br>
        <a class="btn btn-primary" href="{{ route("index") }}">Retour</a>
    </div>

@endsection

<style>
    .div1x{
        text-align: center;
        background: rgb(220, 239, 255);
        padding-top: 20px;
        padding-bottom: 20px;
    }
</style>
