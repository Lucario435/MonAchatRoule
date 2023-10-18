@extends('partials.xlayout')
@section('title', "$publication->title")
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@push('css')
    @vite(['resources/css/publication.css'])
@endpush
<!--BODY-->
@php
    use Illuminate\Support\Facades\Auth;
@endphp
<div class="main-container-style xreducteur" >
    <div class="car-images ">

        @php
           $found = false;
        @endphp

        @foreach ($images as $image)
            @if ($image->publication_id == $publication->id && !$found)
                <div class="image-container">
                    <img id="shown image" class="detail-image" src="{{ asset($image->url) }}" alt="Image description"/>
                    <div class="image-buttons">
                        <button id="arrowLeft" class="buttonArrow-left" title="Image précédente" id="prev-image"><</button>
                        <button id="arrowRight" class="buttonArrow-right" title="Prohaine image" id="next-image">></button>
                    </div>
                </div>
                @php
                    $found = true;
                @endphp
            @endif
        @endforeach
        @if($found == false)
                <img class="detail-no-image" title="Image du vendeur" src="{{asset('img/noImage.jpg')}}" alt="Image de la {{$publication->title}}">
        @endif
    </div>
    <div class="detail-state-text">
        <!--Usefull link : https://www.educative.io/answers/how-to-create-a-countdown-timer-using-javascript-->
        @if ($publication->type == "1")
            <div class="card-bid">
                <span>Enchère :</span>
                <span id="days{{$publication->id}}"></span>
                <span id="hours{{$publication->id}}"></span>
                <span id="mins{{$publication->id}}"></span>
                <span id="secs{{$publication->id}}"></span>
                <span id="end{{$publication->id}}"></span>
            </div>
            <script>
                function startCountdown(publicationId, expirationDate)
                {

                    //Timer script
                    let countDownDate = new Date(expirationDate).getTime();

                    // Initialize HTML elements
                    let daysElement = document.getElementById("days" + publicationId);
                    let hoursElement = document.getElementById("hours" + publicationId);
                    let minutesElement = document.getElementById("mins" + publicationId);
                    let secondsElement = document.getElementById("secs" + publicationId);
                    let endElement = document.getElementById("end" + publicationId);

                var myfunc = setInterval(function() {

                    var now = new Date().getTime();
                    var timeleft = countDownDate - now;

                    // Calculating the days, hours, minutes and seconds left
                    var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

                    // Result is output to the specific element
                    daysElement.innerHTML = days + "j ";
                    hoursElement.innerHTML = hours + "h ";
                    minutesElement.innerHTML = minutes + "m ";
                    secondsElement.innerHTML = seconds + "s ";

                    // Display the message when countdown is over
                    if (timeleft < 0) {
                        clearInterval(myfunc);
                        daysElement.innerHTML = "";
                        hoursElement.innerHTML = "";
                        minutesElement.innerHTML = "";
                        secondsElement.innerHTML = "";
                        endElement.innerHTML = "Enchère terminé";
                    }
                }, 1000);
            }

                startCountdown({{$publication->id}}, "{{$publication->expirationOfBid}}");

            </script>
        @endif
    </div>
</div>
<br>
<div class="main-container-style xreducteur">
    <br>
    <div class="button-container">
        <div class="action-buttons" style="grid-gap:1em;">
            <a title="Contacter le vendeur" class="noDec xreducteur div-button-actions" style="margin:auto;width:100%" href="">
                <div class="button-div  detail-contact-div-test">
                    <div class="contact-icon">
                        <img class="detail-profil-vendeur div-button-actions" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png"/>
                    </div>
                        <label class="detail-labels div-button-actions" style="font-size: 80%; width: 100%;">Contacter</label>
                </div>
            </a>
            <!--Vérifier si déjà follow-->
            <div title="Ajouter l'annonce au favoris" class="div-button-actions" style="width:100%;">
                <a class="noDec button-div-icon"   href="{{ route('publicationfollow.store', ['id' => $publication->id]) }}">
                <!--Ramener vers le controlleur pour ajouter un contact-->
                    <img class="fav-icon div-button-actions" src="{{asset('img/starwhite.png')}}"/>
                    <label class="detail-labels div-button-actions">Favori</label>
                </a>
            </div>
            @auth
            @if(Auth::id() == $publication->user_id)    
                <div title="Modifier l'annonce" class="div-button-actions" style="width:100%;">
                    <a class="noDec button-div-icon"  href="">
                    <!--Ramener vers le controlleur pour ajouter un contact-->
                        <img class="fav-icon div-button-actions" src="{{asset('img/pencil.png')}}"/>
                        <label class="detail-labels div-button-actions">Modifier</label>
                    </a>
                </div>
            @endif
            @endauth
        </div>
    </div>
    <br>
</div>
    <br>
    <style momo="PERMET DE BAISSER LE WIDTH">
        @media (min-width: 768px){
            .xreducteur{width: 40%;}
        }
    </style>
<div class="main-container-style xreducteur" >
    <br>
    <h4 class="detail-info-text">Informations du véhicule</h4>
    <hr>
    <br>
    <div class="car-info-item" style="display: flex; width: 50%; margin: auto;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/dollar.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Prix</label><p>{{$publication->fixedPrice}}$</p></div></div>
    <br>
    <hr> <span style="float: center;">Description:</span> <br>
    {{ $publication->description }}
    <hr>
    <br>
    <div class="car-info ">
        <div class="car-info-item" style="display: flex;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/industrie.png')}}"/></div><div class="detail-labels"><label class="detail-info-text">Fabricant</label><p>{{$publication->brand}}</p></div></div>
        <div class="car-info-item" style="display: flex;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/compteur-de-vitesse.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Kilométrage</label><p>{{$publication->kilometer}} km</p></div></div>
        <!--<label>Année :</label><p>À rajouter</p>-->
        <div class="car-info-item" style="display: flex;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/transmission-manuelle.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Transmission</label><p>{{$publication->transmission}}</p></div></div>
        <div class="car-info-item" style="display: flex;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/body-type.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Carosserie</label><p>{{$publication->bodyType}}</p></div></div>
        <div class="car-info-item" style="display: flex;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/cercle-de-couleur.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Couleur</label><p>{{$publication->color}}</p></div></div>
    </div>
    <div class="Area-info-container">
        <label class="detail-info-text">Emplacement</label>
        <a title="Google Maps" href="http://google.com/maps?q={{$publication->postalCode}}">
            <img class="card-location-icon" style="width:50px; height:50px;" src="{{asset('img/GMLogo.svg')}}"/>
            <div class="detail-postal-code">{{$publication->postalCode}}</div>
        </a>
    </div>
    <br> 
<div title="Signaler l'annonce" class="div-button-actions" style="width: 85%; margin:auto">
    <a class="noDec button-div-icon"  href="">
    <!--Ramener vers le controlleur pour ajouter un contact-->
        <img class="fav-icon div-button-actions" src="{{asset('img/avertissement.png')}}"/>
        <label class="detail-labels div-button-actions">Signaler l'annonce</label>
    </a>
</div>
<br>
</div>
<script>
    //With the help of chat gpt
    // JavaScript to handle image cycling
    document.addEventListener('DOMContentLoaded', function () {
        let images = @json($images);
        let currentIndex = 0;
        const imageElement = document.getElementById('shown image');
        const arrowLeft = document.getElementById('arrowLeft');
        const arrowRight = document.getElementById('arrowRight');
        function showImage(index) {
            if(index < 0)
            {
                index = images.length - 1
            }
            else
            {
                if(index >= images.length) {
                    index = 0;
                }
            }
            url = images[index].url;
            currentIndex = index;
            imageElement.style.opacity = 0;

                // Use a small delay to change the source after the fade-out effect
            setTimeout(function () {
                imageElement.style.opacity = 1;
                }, 400);
                // Fade in the new image
                imageElement.src = "{{ asset('') }}" + url;
            }

        arrowLeft.addEventListener('click', function () {
            showImage(currentIndex - 1);
        });

        arrowRight.addEventListener('click', function () {
            showImage(currentIndex + 1);
        });
    });
</script>
<!--Utile pour follow une annonce-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "process.php", // The PHP script to handle the POST request
                    data: {
                        data: $("#data").val()
                    },
                    success: function (response) {
                        $("#result").html(response);
                    }
                });
            });
        });
    </script>
@endsection
