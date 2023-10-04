@extends('partials.xlayout')

@section('title', 'Confirmer votre courriel')

@section('content')
    @if($email_verified == 0)
        <div class="container-md">
            <div class="info" style="background-color:rgb(233, 232, 232);margin:auto;border-radius:.5em;margin-top:1.5em;">
                <div class="text-center" style="padding:2em;">
                    <div class="fas fa-envelope-open-text fa-7x mx-auto d-flex justify-content-center" 
                        style="color: var(--blueheader);">
                    </div>
                    <br>
                    <h2>Bonjour {{$name}} {{$surname}}</h2>
                    <p>Veuillez confirmer votre inscription en cliquant sur le lien envoyé à cette adresse courriel: {{$email}}.</p>
                </div>
            </div>
        </div>
    @else
        <div class="container-md">
            <div class="info" style="background-color:rgb(233, 232, 232);margin:auto;border-radius:.5em;margin-top:1.5em;">
                <div class="text-center" style="padding:2em;">
                    <div class="fas fa-check fa-7x mx-auto d-flex justify-content-center" 
                        style="color: var(--blueheader);">
                    </div>
                    <br>
                    <h2>Bonjour</h2>
                    <p>Vous avez déjà confirmé votre adresse courriel.</p>
                    <a href="/">Retour</a>
                </div>
            </div>
        </div>
    @endif
    
@endsection