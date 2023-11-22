@extends('partials.xlayout')

@section('title', )
<h1 id="xtitle">À propos</h1>
@endsection

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>À propos</title>
    </head>

    <body>
        <div class="container" style="padding:30px;">
            <div class="row align-items-center">
                <div class="col-sm-4 d-flex justify-content-center">
                    <i class="far fa-question-circle fa-8x"></i>
                </div>
                <div class="col-sm-8 text-start fs-5 mt-4 mb-4">
                    <p>
                        MonAchatRoule a pour mission de connecter les acheteurs d'automobile aux bons vendeurs. On propose un système d'enchères permettant au vendeur de vendre au meilleur offrant. Les utilisateurs pourront trouver la voiture qui répond à leurs critères rapidement grâce à notre système de recherche. Les deux parties profiteront de notre messagerie en temps réel pour que leur expérience de vente et de magasinage soit complète.
                    </p>
                </div>

            </div>
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <i class="fab fa-laravel fa-8x d-flex justify-content-center"></i>
                </div>
                <div class="col-sm-8 text-start fs-5 mt-4 mb-4">
                    <p>
                        La raison est que l’équipe a de bonnes bases avec le langage PHP et le modèle MVC sous le cadriciel
                        de ASP.NET. Nous avons donc conclu que Laravel était un excellent choix de cadriciel, non seulement
                        parce qu'il réunit ces deux aspects, mais aussi en raison de sa grande popularité au sein des
                        entreprises, ce qui nous sera bénéfique à l'avenir.
                    </p>
                </div>
            </div>
            <div class="row align-items-center text-center">
                <div class="fs-1 mt-4 mb-3">Les développeurs</div>
                <div class="col-sm-4 mt-4 mb-4 d-flex justify-content-center ">
                    <div class="   text-center p-3 rounded-5 rounded-top-0">
                        <i class="far fa-user fa-6x d-flex justify-content-center" style="color: #1b5b13;"></i>
                        <div style="height:48px; width:100px;">Chahine Benramoul</div>
                    </div>
                </div>
                <div class="col-sm-4 mt-4 mb-4 d-flex justify-content-center ">
                    <div class=" text-center p-3 rounded-5 rounded-top-0">
                        <i class="far fa-user fa-6x" style="color: #ff8040;"></i>
                        <div style="height:48px;  width:100px;">Jonathan Billette</div>
                    </div>
                </div>
                <div class="col-sm-4 mt-4 mb-4 d-flex justify-content-center ">
                    <div class="  text-center p-3 rounded-5 rounded-top-0">
                        <i class="far fa-user fa-6x" style="color: var(--blueheader);"></i>
                        <div style="height:48px;  width:100px;">Mohammed Ibnou Zahir</div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
