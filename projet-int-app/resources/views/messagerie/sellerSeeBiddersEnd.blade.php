@extends('partials.xlayout')
@php
    use App\Models\User;
@endphp
@section('title', 'Inspecter les enchères reçues')

@include('partials.xhelper');

@section('content')
<h4 style="text-align: center; color:gray;">
    Enchères déposées pour <i>{{ $p->title }}</i> .
</h4>
<br>

    @if (count($bids) > 0)
        <div class="container apagnanContainer">
            @foreach ($bids as $bid)
                @php
                    $user = user::find($bid->user_id);
                @endphp
                <div class="cla" title="{{ dateFr($bid->created_at)  }}">
                    <a class="btnApagnan" href="{{ route('messageUserFromPID', ['id' => $bid->user->id, 'pid' => $bid->publication_id]) }}"><button
                        class="btn btn-primary">Contacter l'usager</button></a>

                    <div class="claProfil">
                        <img src="{{ $user->getImage() }}" alt="">
                        <span>{{ $user->getDisplayName() }}</span>
                    </div>

                    <label class="priceGivenx" for="priceGiven{{ $bid->id }}">$ {{ $bid->priceGiven }}</label>
                    <br>
                    <label for="time{{ $bid->id }}"><i class="fa-solid fa-clock"></i> {{ dateFr($bid->created_at) }}</label>
                    <br>

                </div>
            @endforeach

            <a href="{{ route('notifications') }}"><button class="btn btn-secondary">Retour</button></a>
        </div>
    @else
        <p>Aucune enchères déposées sur votre annonce.</p>
    @endif

    <style>
        @media (min-width: 768px) {
            .apagnanContainer{
            max-width: 60rem !important;
        }
        }

        .btnApagnan{
            float:right;
        }
        .claProfil>img{
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 100%;
        }
        .claProfil{
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .priceGivenx {
            color: green;
            font-size: 1.8rem;
        }

        .cla {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease;
            font-size: 1.2rem;
        }
    </style>
@endsection
