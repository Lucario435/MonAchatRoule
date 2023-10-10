@extends('partials.xlayout')

@push('css')
    @vite(['resources/css/publication.css'])
@endpush
@push('js')
    @vite(['resources/js/filterUI.js'])
@endpush
@section('content')
    {{-- prix marque kilometre couleur tranmission corps  --}}
    <div class="page-on-top container w-100 h-100" id="page_filtre" style="display: block">
        <div class="grid text-start row-gap-5 ">
            <div class="row pt-4 px-2">
                <label id="close_page_filters" class="p-0">
                    <span>
                        <span class="fas fa-filter fa-lg w-20 p-0"></span>
                        <span class="w-75 p-0" style="font-size: 22px">Filtres</span>
                        <span class="fas fa-times h-15 float-end py-2 pe-2"></span>
                    </span>
                </label>
            </div>
            <div class="row" style="min-height: 60px;"></div>
            <div class="row pb-3">
                <label id="label-marque">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Marques</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
                
            </div>
            <div class="row pb-3">
                <label>
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Carroserie</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label>
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Transmission</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label>
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Prix</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label>
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Kilométrage</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            {{-- <div class="row" style="min-height: 460px;"></div> --}}
            <div class="row text-center fixed-bottom mb-2">
                <span style="background-color: green">
                    <span style="font-size: 30px">Rechercher</span>
                    <span class="fas fa-search fa-2x px-3"></span>
                </span>
            </div>
        </div>
    </div>
    
    {{-- Fin filtres --}}
    <span id="content">
        <div class="container-fluid w-100 text-center" style="height: 100px">
            <div class="row">
                <div class="col">
                    <div class="row border">
                        <label for="filters" class="p-3 filter" id="filters">
                            <span id="filters">
                                <span class="fas fa-filter fa-lg w-20 p-0"></span>
                                <span class="w-75 p-0" style="font-size: 22px">Filtrer</span>
                                <span class="fas fa-caret-down w-5"></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col ">
                    <div class="row border">
                        <label for="order" class="p-3 filter">
                            <span id="order">
                                <span class="fas fa-sort-amount-up-alt fa-lg w-20 px-0"></span>
                                <span class="w-75 p-1" style="font-size: 22px">Trier</span>
                                <span class="fas fa-caret-down fa-1x"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <!--Filters-->
            @foreach ($publications as $publication)
                <div class="cardd">
                    <div class="card-state-text">
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
                    @php
                        $found = false;
                    @endphp
                    @foreach ($images as $image)
                        @if ($image->publication_id == $publication->id && !$found)
                            <img class="card-image" src="{{ asset($image->url) }}" />
                            @php
                                $found = true;
                            @endphp
                        @endif
                    @endforeach
                    @if ($found == false)
                        <img class="card-image" src="{{ asset('img/noImage.jpg') }}" />
                    @endif
                    <div style="max-width:10em; overflow:hidden" class="card-title">{{ $publication->title }}</div>
                    <div class="card-price">{{ $publication->fixedPrice }}$</div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="card-kilometer">{{ $publication->kilometer }} km</div>
                    <br>
                    <div class="card-kilometer">{{ $publication->bodyType }} </div>
                    <br>
                    <div class="card-kilometer">{{ $publication->transmission }} </div>
                    <br>
                    <div class="card-kilometer">{{ $publication->brand }}</div>
                    <br>
                    <div class="card-kilometer">{{ $publication->color }}</div>
                    <a title="Google Maps" href="http://google.com/maps?q={{ $publication->postalCode }}">
                        <img class="card-location-icon" src="{{ asset('img/GMLogo.svg') }}" />
                        <div class="card-postal-code">{{ $publication->postalCode }}</div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="end-of-inventory">
            <--Les annonces se terminent ici-->
        </div>
    </span>
@endsection
