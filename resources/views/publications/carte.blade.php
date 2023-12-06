@php
use Illuminate\Support\Facades\Auth;
use App\Models\User;
@endphp
<div class="card-container">
    <!--Filters-->
@if (count($publications) == 0)
<style>
.card-container{
    grid-template-columns: repeat(auto-fit, minmax(0px, 1fr));
}
.not-available{
    text-align: center;
}
</style>
<div style="margin: auto; text-align:center;">
<i class="fa-regular fa-circle-xmark" style="font-size: 3em;color:gray"></i>
<br>
<span class="not-available">Aucune annonce à afficher</span>
</div>
@endif

@foreach ($publications as $publication)
@if($publication->hidden == 0 || $publication->user_id == Auth::id() || (Auth()->user() && Auth()->user()->isAdmin()))
    @php
        $isblocked = false;
        $u = User::find($publication->user_id);
        try {
            $isblocked = $u->is_blocked;
        } catch (\Throwable $th) {
            $isblocked = false;
        }
       @endphp
       @if ($isblocked)
           @continue
       @endif
<div class="cardd">
    <a class="noDec" title="Plus d'informations" href="{{ route('publication.detail', ['id' => $publication->id]) }}">
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
    <div>
        @if($publication->publicationStatus == "vendu")
            <div>
                <div class="card-kilometer" style="background-color:rgba(255,255,255,0.8);transform:translateY(170px);position:absolute;color:red;border-top-right-radius:10px;border-top-left-radius:10px;font-weight:bolder;font-size:larger;">Vendu</div>
            </div>
        @endif
        @if($publication->publicationStatus == "En attente")
            <div>
                <div class="card-kilometer" style="background-color:rgba(255,255,255,0.8);transform:translateY(170px);position:absolute;color:rgb(87, 87, 87);border-top-right-radius:10px;border-top-left-radius:10px;font-weight:bolder;font-size:larger;">En attente</div>
            </div>
        @endif
        @foreach ($images as $image)
            @if ($image->publication_id == $publication->id && !$found)
                    <img class="card-image" src="{{ asset($image->url) }}"/>
                @php
                    $found = true;
                @endphp
            @endif
        @endforeach
        @if($found == false)
                <img class="card-image" src="{{asset('img/ghost.png')}}"/>
        @endif
    </div>
    <div style="max-width:10em; overflow:hidden" class="card-title">{{$publication->title}}</div style="width:300px;">
    <div class="card-price">{{$publication->fixedPrice}} $</div>
    <br>
    <br>
    <br>
    @if(@$publication->distance)<div class="card-kilometer" style="display: block">proximité: {{$publication->distance}} km</div>@endif

    @if( ( (Auth()->user() && Auth()->user()->isAdmin()) || $publication->user_id == Auth::id() ) && $publication->hidden == 1 )
        <div class="d-flex align-items-center" style="float: right;"><div class="card-kilometer fas fa-eye-slash "></div><p class="card-kilometer" style="color: red;float:left; font-weight:bolder;">Privée</p></div>
    @elseif($publication->user_id == Auth::id() && $publication->hidden == 0)
        <div class="d-flex align-items-center" style="float: right;"><p class="card-kilometer fas fa-eye"></p><p class="card-kilometer" style="color: green;float:left;font-weight:bolder;">Publique</p></div>
    @else
        <div style="height: 24px;margin:5px;"></div>
    @endif

    <hr style="color: black">
    <div class="card-kilometer">{{$publication->kilometer}} km</div>
    <a title="Google Maps" href="http://google.com/maps?q={{$publication->postalCode}}">
        <img class="card-location-icon" src="{{asset('img/epingle.png')}}"/>
        <div class="card-postal-code">{{$publication->postalCode}}</div>
    </a>
</a>
</div>
@endif
@endforeach
</div>
