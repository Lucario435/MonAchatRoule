@php
    // la table parametres doit inclure $uid, et $addedCssProfilDiv (au besoin, genre pour place le div à droite ou a gauche)
    // upd 2023-10-06, on a l'objet $user
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use App\Models\User;
    use App\Models\rating;
@endphp
@include("partials.xhelper")
<div class="rating-container">
@foreach ($ratings as $rat)
<div class="rating-block" title="{{ dateFr($rat->created_at) }}">
    <a href="{{ route("userProfile",["id"=>$rat->targetUser->id ]) }}"><span class="user-name">{{ $rat->targetUser->getDisplayName() }}</span></a>
    <span style="margin-left: 1rem;">
        @for ($i = 0; $i < $rat->etoiles; $i++)
            <span class="star-icon">&#9733;</span>
        @endfor
        <!-- Add or remove stars as needed -->
    </span>
    @if ($rat->user_target == Auth::id() || $isAdmin)
    <a href="{{ route("messages.rateSellerEdit",["rid"=>$rat->id]) }}" style="float:right"><button class="btn btn-primary">Modifier</button></a>
    @endif

    <div class="comment-section">
        <p>{{ $rat->commentaire }}</p>
    </div>
</div>
<br>
@endforeach
</div>
<style>
    .rating-container {
       display: flex;
    flex-wrap: wrap;
    justify-content: center;
    }
    .rating-block {
            background-color: #fff;
            border-radius: 8px;
            padding: .5rem;
            margin-bottom: 20px;

            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            width: 60rem;
            max-width: 70% !important;
            margin:auto;
            transition: .2s;
            margin-top: 20px;
            flex: 0 0 calc(50% - 20px); /* Two columns, accounting for margin */
        }
        .rating-block:hover{
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: .2s;
        }
        @media (orientation:portrait){
            .rating-block{
                width: 200%;
                max-width: 100%!important;

                flex: 0 0 100%; /* One column for mobile */
            }
        }
        .user-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .star-icon {
            color: #fdd835; /* Star color */
            margin-right: 5px;
            font-size: 1.2rem;
        }

        .comment-section {
            margin-top: 10px;
        }
</style>
