@extends('partials.xlayout')
@section('title', "$publication->title")
@section('content')
<head>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
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
    @auth
        @if(Auth::id() == $publication->user_id)

            <a style="font-weight: bold;" href="{{ route("publication.getupdateview",["id"=>$publication->id]) }}">
                <div class="button-div detail-contact-div xer" style="width: 30%; color:black;">Modifier annonce</div></a>
        <style>.xer:hover{ color:white !important;}</style>
        @endif
    @endauth
    <br>
    <div class="button-container xreducteur" style="display:none;">
        <a class="noDec" href="">
            <div class="button-div detail-contact-div" style="display: flex">
                <div class="contact-icon">

                </div>
                <!--Ramener vers le controlleur pour ajouter un contact-->
                    <label class="detail-labels">Contacter le vendeur *NonFonctionnel*</label>
            </div>
        </a>

        <a class="noDec" href="">
            <div class="button-div detail-contact-div">
                <!--Ramener vers le controlleur pour ajouter un contact-->
                    <img class="fav-icon" style="width:50px; height:50px;" src="{{asset('img/starwhite.png')}}"/>
            </div>
        </a>
    </div>
    <br>
    <style momo="PERMET DE BAISSER LE WIDTH">
        @media (min-width: 768px){
            .xreducteur{width: 40%;}
        }
    </style>
<div class="main-container-style xreducteur" >
    <h4 class="detail-info-text">Informations du véhicule</h4>
    <hr>
    <br>
    <div class="car-info-item" style="display: flex; width: 50%; margin: auto;"><div class="info-logo" style="width: 100%;"><img class="detail-icon" src="{{asset('img/dollar.png')}}"/></div><div  class="detail-labels"><label class="detail-info-text">Prix</label><p>{{$publication->fixedPrice}}$</p></div></div>
    <br>
    <hr> <span style="float: center;">Description:</span> <br>
    {{ $publication->description }}asdaweij aijweiu awjueua h eawiueh a iuajweiuahwuehawug eyagwyegyawgeyagwye ayweg yuagweu
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
@endsection
