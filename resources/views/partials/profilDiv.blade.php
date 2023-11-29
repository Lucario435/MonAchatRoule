@php
    // la table parametres doit inclure $uid, et $addedCssProfilDiv (au besoin, genre pour place le div à droite ou a gauche)
    // upd 2023-10-06, on a l'objet $user
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use App\Models\User;

@endphp
<div>
<div id="card1" class="cardprofilDiv four col profilDiv"
    @isset($addedCssProfilDiv)
        style="{{ $addedCssProfilDiv }}"
    @endisset>
    <div class="image-wrapper"
    @if($user->getImage() != null)
        style="margin-bottom:.3rem; background-image: url('{{ $user->getImage() }}')"
    @endif

    ></div>
    <h3 class="name" style="color: white;"> {{ $user->getDisplayName()  }}</h3>
        <h5 class="h5phone" style="margin-top:-.5rem; height:1rem; color: gray;">
            @if ($phoneD)
                {{ $user->phone }}
            @endif
        </h5>
    <div class="info cf">
        <style>.goldx{color: #ffc700}</style>
        <div class="four col"><span class="number goldx">{{ $user->getNoteGlobale() }} ★</span>Selon les évaluations</div>
        <div class="four col"><span class="number">{{ ($user->getPublicationsCountForDisplay()) }}</span>Annonces actives</div>
        {{-- <div class="four col"><span class="number">179</span>Likes</div> --}}
    </div>
    <div class="options" style="">
        <ul>
            {{-- <li><span class="icon"><i class="fa fa-plus" aria-hidden="true"></i></span>Add to team</li> --}}
            {{-- <li><span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>Send a message</li> --}}
           @if($user->id != Auth::id())
                {{-- Allo: {{ Auth::id() }} --}}
                <a class="btnBlueSendA" href="/messages/{{ $user->id }}"><button class="btnBlueSend btn btn-primary">Contacter</button></a>
                <br><br>
                <a class="btnGraySendA" href="/report/?usertarget={{ $user->id }}"><button class="btnGraySend btn btn-secondary">Signaler</button></a>
            @endif
            @if (Auth::id() == $user->id)
            <a href="{{ route("user.edit") }}" class="btnBlueSendA"><button class="btnBlueSend btn btn-primary">Modifier votre profil</button></a>
            @endif
        </ul>
    </div>
</div>

</div>
<style>
    form{
        margin: 0;
    }
    .btnEditProfil{
        /* width: 100%;
        background: rgb(0, 88, 211);
        color: white;
        border: none; */
    }
    .btnBlueSendA{
        /* width: 100%; */
    }
    .h5phone{
        margin-bottom: 1rem;
    }
    .btnBlueSend{
         width: 100%;
         /*
        background: rgb(20, 104, 220);
        outline: solid 2px white;
        margin-bottom: 10px;
        padding: .5rem;
        border-radius: .5rem;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 10px 20px;
        border: none;
        color: white;
        transition: .2s ease; */
    }
    .btnBlueSend:hover{
        /* padding: .7rem;
        background: rgb(0, 88, 211);
        font-weight: bold; */
    }
    .btnGraySend{
         width: 100%;
         /*
        background: rgb(105, 105, 105);
        outline: solid 2px white;
        margin-bottom: 10px;
        padding: .5rem;
        border-radius: .5rem;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 10px 20px;
        border: none;
        color: white;
        transition: .2s ease; */
    }
    .btnGraySend:hover{
        /* padding: .7rem;
        background: rgb(69, 69, 69);
        font-weight: bold; */
    }
    .profilDiv {
        width: 10rem;
        height: 10rem;
    }
    .profilDiv .info {
    display: flex;
    justify-content: center;
}

.profilDiv .info .col {
    margin: 0 1.6%; /* Adjust the margin as needed */
}
    .twelve { width: 100%; }
.eleven { width: 91.53%; }
.ten { width: 83.06%; }
.nine { width: 74.6%; }
.eight { width: 66.13%; }
.seven { width: 57.66%; }
.six { width: 49.2%; }
.five { width: 40.73%; }
.four { width: 32.26%;}
.three { width: 23.8%; }
.two { width: 15.33%; }
.one{ width: 6.866%;}

.col {
	display: block;
    color: white;
	/* float:left; */
	/* margin: 1% 0 1% 1.6%; */
}

.col:first-of-type { margin-left: 0; }

 /* CLEARFIX */

 .cf:before, .cf:after {
 	content: " ";
 	display: table;
 }

 .cf:after {
	clear: both;
}

 .cf {
 	*zoom: 1;
 }

/* PROFILES */

.cardprofilDiv{
	max-width: 30rem;
    min-width: 25rem;
    width: 90%;
	height: 400px;
	background-color: #fff;
	font-family: 'Arimo', sans-serif;
	font-size: 14px;
    border-radius: 5px;
}
@media (orientation: portrait){
    .cardprofilDiv{
        min-width: 100%;
    }
}

#card1{
	text-align: center;
	color: #2c3e50;
	padding: 15px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

#card1 .image-wrapper{
	width: 100px;
	height: 100px;
	margin: 20px auto;
	border-radius: 100%;
	background-size: cover;
	background-repeat: no-repeat;
    background-position: center;
}

#card1 .info .four{
	text-align: center;
	border-right: 1px solid #2c3e50;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

#card1 .info .four:last-of-type{
	border-right: none;
}

#card1 .info .four .number{
	display: block;
	font-size: 20px;
	padding: 3px 0;
	font-weight: 700;
}

#card1 .options{
	margin-top: 30px;
	text-align: left;
}

#card1 .options ul{
	list-style-type: none;
	padding: 0;
    width: 100%;
	margin: 0;
}

#card1 .options ul .icon{
	display: inline-block;
	width: 30px;
	height: 30px;
	background-color: #3498db;
	border-radius: 100%;
	margin-right: 8px;
	vertical-align: middle;
	color: #fff;
	line-height: 30px;
	text-align: center;
}

#card1 .options ul li{
	margin: 12px 0;
}

.profilDiv{
background: rgb(41, 41, 41);
color: white;
font-weight: bold;
/* outline: solid 2px black; */
box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.6) !important;
}
</style>
