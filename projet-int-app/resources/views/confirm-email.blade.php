@extends('partials.xlayout')

@section('content')
    @if ($email_verified_now == 0)
        <div class="container-md">
            <div class="info" style="background-color:rgb(233, 232, 232);margin:auto;border-radius:.5em;margin-top:1.5em;">
                <div class="text-center" style="padding:2em;">
                    <div class="fas fa-envelope-open-text fa-7x mx-auto d-flex justify-content-center"
                        style="color: var(--blueheader);">
                    </div>
                    <br>
                    <h2>Bonjour {{ $name }} {{ $surname }}</h2>
                    <p>Veuillez confirmer votre inscription en cliquant sur le lien envoyé à cette adresse courriel:
                        {{ $email }}.</p>
                </div>
            </div>
        </div>
    @elseif ($email_verified_now == 2)
        <div class="container-md">
            <div class="info" style="background-color:rgb(233, 232, 232);margin:auto;border-radius:.5em;margin-top:1.5em;">
                <div class="text-center" style="padding:2em;">
                    <div class="fas fa-exclamation-circle fa-7x mx-auto d-flex justify-content-center" style="color: var(--blueheader);">
                    </div>
                    <br>
                    <h2>Oops {{ Auth::user()->name }} {{ Auth::user()->surname }}!</h2>
                    <p>Votre adresse courriel a déjà été confirmé.</p>

                    <a href="/login"><button type="button" class="btn btn-primary">Se connecter</button></a>
                </div>
            </div>
        </div>
    @else
        <div class="container-md">
            <div class="info"
                style="background-color:rgb(233, 232, 232);margin:auto;border-radius:.5em;margin-top:1.5em;">
                <div class="text-center" style="padding:2em;">
                    <div class="fas fa-check fa-7x mx-auto d-flex justify-content-center" style="color: var(--blueheader);">
                    </div>
                    <br>
                    <h2>Bravo {{ Auth::user()->name }} {{ Auth::user()->surname }}!</h2>
                    <p>Vous avez confirmé votre adresse courriel.</p>

                    <a href="/login"><button type="button" class="btn btn-primary">Se connecter</button></a>
                </div>
            </div>
        </div>
    @endif
@endsection
