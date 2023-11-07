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

            @php
                $found = false;
            @endphp

            @foreach ($images as $image)
                @if ($image->publication_id == $publication->id && !$found)
                    <div class="image-container">
                        <img id="shown image" class="detail-image" src="{{ asset($image->url) }}" alt="Image description" />
                        <div class="image-buttons">
                            <button id="arrowLeft" class="buttonArrow-left" title="Image précédente" id="prev-image">
                                << /button>
                                    <button id="arrowRight" class="buttonArrow-right" title="Prohaine image"
                                        id="next-image">></button>
                        </div>
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
        </div>
        <div class="detail-state-text">
            <!--Usefull link : https://www.educative.io/answers/how-to-create-a-countdown-timer-using-javascript-->
            @if ($publication->type == '1')
                <div class="card-bid">
                    <span>Enchère :</span>
                    <span id="days{{ $publication->id }}"></span>
                    <span id="hours{{ $publication->id }}"></span>
                    <span id="mins{{ $publication->id }}"></span>
                    <span id="secs{{ $publication->id }}"></span>
                    <span id="end{{ $publication->id }}"></span>
                </div>
                <script>
                    function startCountdown(publicationId, expirationDate) {

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

                    startCountdown({{ $publication->id }}, "{{ $publication->expirationOfBid }}");
                </script>
            @endif
        </div>
    </div>
    <br>
    <div class="main-container-style xreducteur">
        <br>
        <div class="button-container">
            <div class="action-buttons" style="grid-gap:1em;">
                <a title="Contacter le vendeur" class="noDec xreducteur div-button-actions" style="margin:auto;width:100%"
                    href="">
                    <div class="button-div">
                        <div class="contact-icon">
                            <i class="fav-icon div-button-actions fa-solid fa-envelope"></i>
                        </div>
                        <label class="detail-labels div-button-actions">Contacter</label>
                    </div>
                </a>
                <!--Vérifier si déjà follow-->
                <div title="Suivre l'état de l'annonce" class="div-button-actions" style="width:100%;">
                    <a class="noDec button-div"
                        href="{{ route('publicationfollow.store', ['publication_id' => $publication->id]) }}">
                        <!--Ramener vers le controlleur pour ajouter un contact-->
                        @if ($followed)
                            <i class="fav-icon div-button-actions fas fa-star" style="color: orange"></i>
                        @else
                            <i class="fav-icon div-button-actions fa-regular fa-star"></i>
                        @endif
                        <label class="detail-labels div-button-actions">Suivre</label>
                    </a>
                </div>
                @auth
                    @if (Auth::id() == $publication->user_id)
                        <div title="Modifier l'annonce" class="div-button-actions" style="width:100%;">
                            <a class="noDec button-div" href="{{ route('publication.update', ['id' => $publication->id]) }}">
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
    @if ($publication->type == '1')
        <div class="main-container-style xreducteur">
            <br>
            <h4 class="detail-info-text">Détails de l'enchère</h4>
            <hr>
            <div class="bid-detail-grid" style="grid-gap:1em; margin: 1em">
                <div class="car-info-item d-flex align-items-center justify-content-center" style="width:100%;">
                    <div class="">
                        <br>
                        <span class="detail-info-text">Prix demandé</span>
                        <br>
                        <br>
                        <span class="detail-text-emphasis">12 000$</span>
                        <br>
                        <br>
                        <span class="detail-info-text">État de l'annonce</span>
                        <br>
                        <br>
                        <span class="detail-text-emphasis">En cours</span>
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
                    <div class="scroller" style="overflow-y: scroll;">
                        @foreach ($images as $image)
                        @endforeach
                        <div class="historic-bids-container">
                            <i class="fav-icon fas fa-crown" style="color:goldenrod"></i><span
                                class="text-emphasis text-adapt">Rollingasaurus Rex</span><span
                                style="padding: 5px">|</span><span class="text-emphasis text-adapt">25000$</span>
                        </div>
                        <div class="historic-bids-container">
                            <i class="fav-icon fas fa-crown" style="color:gray"></i><span
                                class="text-emphasis text-adapt">IamWheel</span><span style="padding: 5px">|</span><span
                                class="text-emphasis text-adapt">14000$</span>
                        </div>
                        <div class="historic-bids-container">
                            <i class="fav-icon fas fa-crown" style="color:brown"></i><span
                                class="text-emphasis text-adapt">JaguarMilk</span><span style="padding: 5px">|</span><span
                                class="text-emphasis text-adapt">12500$</span>
                        </div>
                        <div class="historic-bids-container">
                            <i class="fav-icon fas fa-crown" style="color:lightblue"></i><span
                                class="text-emphasis text-adapt">JaguarMilk</span><span style="padding: 5px">|</span><span
                                class="text-emphasis text-adapt">12500$</span>
                        </div>
                        <div class="historic-bids-container">
                            <i class="fav-icon fas fa-crown" style="color:lightblue"></i><span
                                class="text-emphasis text-adapt">JaguarMilk</span><span style="padding: 5px">|</span><span
                                class="text-emphasis text-adapt">12500$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div title="Suivre l'état de l'annonce" class="div-button-actions" style=" margin:1em;">
                <a class="noDec button-div" href="">
                    <i class="fav-icon div-button-actions fas fa-hand-holding-usd"></i>
                    <label class="detail-labels div-button-actions">Déposer une enchère</label>
                </a>
            </div>
            <br>
        </div>
        </div>
    @endif
    <br>
    <style momo="PERMET DE BAISSER LE WIDTH">
        @media (max-width: 920px) {
            .xreducteur {
                width: 90%;
            }
        }
    </style>
    <div class="main-container-style xreducteur">
        <br>
        <h4 class="detail-info-text">Informations du véhicule</h4>
        <hr>
        <div class="car-info-item" style="margin: 1em;"><br>
            <h4 class="detail-info-text">Prix demandé</h4>
            <p class="detail-text-emphasis">{{ $publication->fixedPrice }}$</p>
        </div>
        <div class="car-info-item" style="margin: 1em;">
            <br>
            <h4 class="detail-info-text">Description</h4>
            <br>
            {{ $publication->description }}
            <br>
            <br>
        </div>
        <div class="car-info ">
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/industrie.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Fabricant</label>
                    <p class="detail-text-emphasis">{{ $publication->brand }}</p>
                </div>
            </div>
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/compteur-de-vitesse.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Kilométrage</label>
                    <p class="detail-text-emphasis">{{ $publication->kilometer }} km</p>
                </div>
            </div>
            <!--<label>Année :</label><p>À rajouter</p>-->
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/transmission-manuelle.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Transmission</label>
                    <p class="detail-text-emphasis">{{ $publication->transmission }}</p>
                </div>
            </div>
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/body-type.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Carosserie</label>
                    <p class="detail-text-emphasis">{{ $publication->bodyType }}</p>
                </div>
            </div>
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/couleurs.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Couleur</label>
                    <p class="detail-text-emphasis">{{ $publication->color }}</p>
                </div>
            </div>

            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/year.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Année</label>
                    <p class="detail-text-emphasis">{{ $publication->year }}</p>
                </div>
            </div>
            <div class="car-info-item">
                <div class="info-logo" style="width: 100%;"><img class="detail-icon"
                        src="{{ asset('img/essence.png') }}" /></div>
                <div class="detail-labels"><label class="detail-info-text">Type d'essence</label>
                    <p class="detail-text-emphasis">{{ $publication->fuelType }}</p>
                </div>
            </div>

            <div><a style="color: black;" class="noDec" href="http://google.com/maps?q={{ $publication->postalCode }}">
                    <div title="Google Maps vers {{ $publication->postalCode }}"
                        style="background-image: url({{ asset('img/Google-Maps-Logo.png') }}); background-size: cover;"class="car-info-item location-hover">
                        <div class="info-logo opacity" style="width: 100%;"><img class="detail-icon"
                                src="{{ asset('img/epingle.png') }}" />
                            <div class="detail-labels"><label class="detail-info-text">Emplacement</label>
                                <p class="detail-text-emphasis">{{ $publication->postalCode }}</p>
                            </div>
                        </div>
                </a></div>
        </div>
    </div>
    <br>
    <div style="width: 100%; height: 4em;">
        <div title="Signaler l'annonce" class="div-button-actions" style="float: right; width:fit-content;margin:20px;">
            <a class="noDec alert-button-div" title="Signaler l'annonce" href="">
                <!--Ramener vers le controlleur pour ajouter un contact-->
                <i class="fav-icon alert-hover div-button-actions fa-solid fa-triangle-exclamation"></i>
            </a>
        </div>
    </div>
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
        document.querySelector('.location-hover').addEventListener('mouseenter', function() {
            document.querySelector('.opacity').classList.add('active');
        });
        document.querySelector('.location-hover').addEventListener('mouseleave', function() {
            document.querySelector('.opacity').classList.remove('active');
        });
    </script>
    @include('partials.xfooter')
@endsection
