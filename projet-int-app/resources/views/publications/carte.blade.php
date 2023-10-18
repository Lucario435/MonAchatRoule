<div class="card-container">
    <!--Filters-->
@foreach ($publications as $publication)
 <div class="cardd">
    <a title="Plus d'informations" href="{{ route('publication.detail', ['id' => $publication->id]) }}">
    <div class="card-state-text">
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
    @php
        $found = false;
    @endphp

    @foreach ($images as $image)
        @if ($image->publication_id == $publication->id && !$found)
                <img class="card-image" src="{{ asset($image->url) }}"/>
            @php
                $found = true;
            @endphp
        @endif
    @endforeach
    @if($found == false)
            <img class="card-image" src="{{asset('img/noImage.jpg')}}"/>
    @endif
    <div style="max-width:10em; overflow:hidden" class="card-title">{{$publication->title}}</div>
    <div class="card-price">{{$publication->fixedPrice}}$</div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="card-kilometer">{{$publication->kilometer}} km</div>
    <a title="Google Maps" href="http://google.com/maps?q={{$publication->postalCode}}">
        <img class="card-location-icon" src="{{asset('img/GMLogo.svg')}}"/>
        <div class="card-postal-code">{{$publication->postalCode}}</div>
    </a>
</a>
</div>
@endforeach
</div>