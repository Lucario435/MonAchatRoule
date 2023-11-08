@php
use App\Models\User;
use App\Models\Bid;
    //Next thing to add is if there is a bid, the asked price will change
    $price = null;
    if(Bid::where('publication_id', $publication->id)->count() >= 1)
    {
        $price = Bid::where('publication_id', $publication->id)
        ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
        ->first()->priceGiven;
    }
    else {
        $price = $publication->fixedPrice;
    }
@endphp
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
    <div class="main-container-style xreducteur">
        <div class="car-images ">

@endpush
<!--BODY-->
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div id="popup-bid" style="display:none" class="popup-container">
    <div onclick="hide()" style="margin:1em;" class="popup-exit">
        <p class="popup-exit-text">X</p>
    </div>
    <br>
    <div style="width: 100%">
        <div style="position: relative; margin:auto; width:fit-content;">
        <p style="overflow:auto;color:white; font-size:2rem;text-align:center; width:100%;margin:0;">Dépose d'enchère</p>
        <br>
        <div style="color: white; font-size:4rem;margin:auto;position:relative" class="fav-icon div-button-actions fas fa-hand-holding-usd"></div>
        <span style="color:white; font-size:4rem">- - -</span>
        <div style="color: white; font-size:4rem;margin:auto;position:relative" class="fav-icon div-button-actions fas fa-user"></div>
        </div>
    </div>
    <br>
    <p style="color:white; font-size:1rem; text-align:center;margin:0;">Avant de déposer une enchère, <br>veuillez lire les <a style="color: white;" href="">politiques des enchères</a> de MonAchatRoule®
    </p>
    <br>
    <br>
    <form id="bid-form" method="post" action="{{ route('bid.store') }}">
        <!--For Security-->
        @csrf
        @method('post')
        <!--////////////-->
        <div style="background-color:white;width:fit-content;margin:auto;border-radius:25px;text-align:center;">
            <p class="price-refresher-50-text" style="font-weight: bolder;margin:0;">Dépot minimum : {{$price + 50}} $</p>
        </div>
        <br>
        <div style="background-color:white;width:fit-content;margin:auto;border-radius:25px;">
            <input class="price-refresher-50 refresher-input" name="priceGiven" required min="{{$price + 50}}" style="color:black; background-color: transparent;border:none;width:100%;font-weight: bolder;text-align:center;" placeholder="{{$price + 50}}" type="number" />
            <span style="font-weight: bolder;margin:0;color:white;position:absolute;">$</span>
            <input type="hidden" name="publication_id" value="{{$publication->id}}"/>
            <input type="hidden" name="bidStatus" value="Ok"/>
        </div>
        <br>
        <div style="background-color:black;width:fit-content;margin:auto;border-radius:25px;text-align:center;">
            <input style="background-color: transparent;border:none;width:100%;font-weight: bolder;color:white;" type="submit" value="Déposer"/>
        </div>
    </form>
    <br>
</div>
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
                    @php
                        $found = true;
                    @endphp
                @endif
            @endforeach
            @if ($found == false)
                <img class="detail-no-image" title="Image du vendeur" src="{{ asset('img/noImage.jpg') }}"
                    alt="Image de la {{ $publication->title }}">
            @endif
        @endforeach
        @if($found == false)
                <img class="detail-no-image" title="Image du vendeur" src="{{asset('img/noImage.jpg')}}" alt="Image de la {{$publication->title}}">
        @endif
    </div>
</div>
<br>
<div class="main-container-style xreducteur">
    <br>
    <div class="button-container">
        <a title="Voir le profil" class="noDec xreducteur div-button-actions" style="margin:auto;width:100%" href="{{ route('userProfile', ['id' => $publication->user_id]) }}">
            <div class="button-div">
                <div class="contact-icon">
                    <i class="fav-icon div-button-actions fas fa-user" ></i>
                </div>
                    <label class="detail-labels div-button-actions">Voir le profil du vendeur</label>
            </div>
        </a>
        <br>
        <div class="action-buttons" style="grid-gap:1em;">
            <a title="Contacter le vendeur" class="noDec xreducteur div-button-actions" style="margin:auto;width:100%" href="{{ route('messageUser', ['id' => $publication->user_id]) }}">
                <div class="button-div">
                    <div class="contact-icon">
                        <i class="fav-icon div-button-actions fa-solid fa-envelope" ></i>
                    </div>
                        <label class="detail-labels div-button-actions">Contacter</label>
                </div>
            </a>
            <!--Vérifier si déjà follow-->
            <div title="Suivre l'état de l'annonce" class="div-button-actions" style="width:100%;">
                <a class="noDec button-div"   href="{{ route('publicationfollow.store', ['publication_id' => $publication->id]) }}">
                <!--Ramener vers le controlleur pour ajouter un contact-->
                    @if($followed)  
                        <i class="fav-icon div-button-actions fas fa-star" style="color: orange"></i>
                    @else
                        <i class="fav-icon div-button-actions fa-regular fa-star"></i>
                    @endif
                    <label class="detail-labels div-button-actions">Suivre</label>
                </a>
            </div>
            @auth
            @if(Auth::id() == $publication->user_id)    
                <div title="Modifier l'annonce" class="div-button-actions" style="width:100%;">
                    <a class="noDec button-div"  href="{{ route('publication.update', ['id' => $publication->id]) }}">
                    <!--Ramener vers le controlleur pour ajouter un contact-->
                        <i class="fav-icon div-button-actions fa-solid fa-pencil"></i>
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
<!--Section enchère-->
@if ($publication->type == "1")
<div class="main-container-style xreducteur">
    <br>
    <h4 class="detail-info-text">Détails de l'enchère</h4>
    <hr>
    <div class="detail-state-text" style="border-radius: 5px; margin:1em;">
        <!--Usefull link : https://www.educative.io/answers/how-to-create-a-countdown-timer-using-javascript-->
        @if ($publication->type == "1")
            <div class="card-bid">
                <span>État de l'enchère : </span>
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
                        endElement.innerHTML = " Terminé";
                    }
                }, 1000);
            }

                startCountdown({{$publication->id}}, "{{$publication->expirationOfBid}}");

            </script>
        @endif
    </div>
    <div class="bid-detail-grid" style="grid-gap:1em; margin: 1em">
        <div class="car-info-item d-flex align-items-center justify-content-center" style="width:100%;">
            <div class="">
                <br>
                <span class="detail-info-text">Enchère la plus haute</span>
                <br>
                <br>
                @php
                    $highestBid = Bid::where('publication_id', $publication->id)
                    ->orderBy('priceGiven', 'desc') // Order bids in descending order by amount
                    ->first();
                @endphp
                <span class="price-refresher detail-text-emphasis">{{$price}} $</span>
                <br>
                <br>
                <span class="detail-info-text">État de l'annonce</span>
                <br>
                <br>
                <span class="detail-text-emphasis">{{$publication->publicationStatus}}</span>
                <br>
                <br>
                
            </div>
        </div>
        <div class="car-info-item div-white-shadow" style="width:100%;">
            <br>
            <span class="detail-info-text" style=" background-color:white;">Enchères</span>
            <br>
            <br>
            <!--Container of the historic of bids-->
            <div id="refreshed-div" class="scroller" style="overflow-y: scroll;">
                <!--Content will show here after partial refresh-->
            </div>
        </div>
        </div>
        @php
            $dateNow = date('Y-m-d H:i:s')
        @endphp
        @if($publication->expirationOfBid >= $dateNow)
            <div onclick="show()" title="Suivre l'état de l'annonce" class="div-button-actions" style="margin-left:1em;margin-right:1em;">
                <div class="noDec button-div" >
                        <i class="fav-icon div-button-actions fas fa-hand-holding-usd"></i>
                    <label class="detail-labels div-button-actions">Déposer une enchère</label>
                </div>
            </div>
        @else
            <div title="Enchère" style="margin-left:1em;margin-right:1em;cursor:not-allowed;">
                <div class="noDec button-div-inactiv">
                        <i class="fav-icon fas fa-hand-holding-usd"></i>
                    <label style="cursor:not-allowed;" class="detail-labels">Déposer une enchère</label>
                </div>
            </div>
        @endif
        <br>
    </div>
    <br>
    <h4 class="detail-info-text">Informations du véhicule</h4>
    <hr>
    <div class="car-info-item" style="margin: 1em;"><br><h4 class="detail-info-text">Prix demandé</h4><p class=" price-refresher detail-text-emphasis">{{$price}} $</p></div>
    <div class="car-info-item" style="margin: 1em;">
        <br>
        <h4 class="detail-info-text">Description</h4> 
        <br>
            {{ $publication->description }}
        <br>
        <br>
    </div>
    <script>
        //With the help of chat gpt
        // JavaScript to handle image cycling
        document.addEventListener('DOMContentLoaded', function() {
            let images = @json($images);
            let currentIndex = 0;
            const imageElement = document.getElementById('shown image');
            const arrowLeft = document.getElementById('arrowLeft');
            const arrowRight = document.getElementById('arrowRight');

            function showImage(index) {
                if (index < 0) {
                    index = images.length - 1
                } else {
                    if (index >= images.length) {
                        index = 0;
                    }
                }
                url = images[index].url;
                currentIndex = index;
                imageElement.style.opacity = 0;

                // Use a small delay to change the source after the fade-out effect
                setTimeout(function() {
                    imageElement.style.opacity = 1;
                }, 400);
                // Fade in the new image
                imageElement.src = "{{ asset('') }}" + url;
            }

            arrowLeft.addEventListener('click', function() {
                showImage(currentIndex - 1);
            });

            arrowRight.addEventListener('click', function() {
                showImage(currentIndex + 1);
            });
        });
    </script>
    <!--Utile pour follow une annonce-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "process.php", // The PHP script to handle the POST request
                    data: {
                        data: $("#data").val()
                    },
                    success: function(response) {
                        $("#result").html(response);
                    }
                });
            });
        });
    </script>
    <script>
    document.querySelector('.location-hover').addEventListener('mouseenter', function () {
        document.querySelector('.opacity').classList.add('active');
    });
    document.querySelector('.location-hover').addEventListener('mouseleave', function () {
        document.querySelector('.opacity').classList.remove('active');
    });
    function hide() {
         document.getElementById('popup-bid').style.display = 'none';
    }
    function show() {
         document.getElementById('popup-bid').style.display = 'block';
    }
    document.getElementById("bid-form").addEventListener("submit", function (event) {
        // Prevent the form from automatically submitting
        event.preventDefault();

        // Display a confirmation dialog
        const isConfirmed = confirm("Etes-vous sur de vouloir déposer votre enchère sur {{$publication->title}}?");

        // If the user confirms, submit the form
        if (isConfirmed) {
            this.submit(); // "this" refers to the form
        }
    });
    </script>
    <script>
        function refreshDiv() {
            let $id = '{{$publication->id}}';
            $.ajax({
                url: "{{ route('bid.refresh-div', ['id' => ':id']) }}".replace(':id', $id),
                type: 'GET',
                success: function (data) {
                    $('#refreshed-div').html(data);
                }
            });

            //Adds a refresh on the prices
            $.ajax({
                url: "{{ route('bid.refresh-price', ['id' => ':id']) }}".replace(':id', $id),
                type: 'GET',
                success: function (data) {
                    //Faire un foreach de chaque classe "price-refresher"
                    var slides = document.getElementsByClassName("price-refresher");
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].innerHTML = (data) + " $";
                    }
                    var slides = document.getElementsByClassName("price-refresher-50");
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].innerHTML = (Number(data) + 50) + " $";
                    }
                    //with text
                    var slides = document.getElementsByClassName("price-refresher-50-text");
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].innerHTML = "Dépot minimum : " + (Number(data) + 50) + " $";
                    }
                    //For input and hol input.setAttribute("min", this.value);
                    var slides = document.getElementsByClassName("refresher-input");
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].setAttribute("min", Number(data) + 50);
                        slides[i].setAttribute("placeholder",Number(data) + 50)
                    }
                }
            });
        }
        
        // Call refreshDiv initially and then every 5 seconds
        refreshDiv(); // Call it initially to load the div content
    
        setInterval(refreshDiv, 5000); // Call it every 5 seconds (5000 milliseconds)
    </script>
    @include('partials.xfooter')
@endsection
