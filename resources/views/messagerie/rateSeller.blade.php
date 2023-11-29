@extends('partials.xlayout')

@section('title', 'Évaluez votre achat')

@section('content')
    <div class="container">
        {{-- <h2>Create Rating</h2> --}}
        <form method="post" action="{{ route('messages.rateSellerPost') }}">
            @csrf
            {{-- <div class="form-group"> --}}
            {{-- <label for="ventes_id">Vente:</label> --}}
            {{-- <select name="ventes_id" class="form-control">
                    @foreach ($ventes as $vente)
                        <option value="{{ $vente->id }}">{{ $vente->id }}</option>
                    @endforeach
                {{-- </select> --}}
            {{-- </div> --}}

            <div class="form-group">
                <label for="etoiles" id="etoilesLabel">Comment avez vous trouvé votre achat ? <span style="color:red;">*</span> </label>
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" required/>
                    <label for="star5" title="5 étoiles">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="4 étoiles">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="3 étoiles">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="2 étoiles">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="1 étoile">1 star</label>
                </div>

            </div>

            <div class="form-group">
                <label for="commentaire">Entrez un commentaire <span style="color:Red;">*</span> </label>
                <textarea required name="commentaire" maxlength="300" class="form-control" rows="4"></textarea>
            </div>

            <!-- Hidden inputs for the rest of the attributes -->
            <input type="hidden" name="uid" value="{{ $uid }}">
            {{-- <input type="hidden" name="user_target" value="{{ $targetUserId }}"> <!-- Replace $targetUserId with the actual target user ID --> --}}
            {{-- <input type="hidden" name="publication_id" value="{{ $publicationId }}"> <!-- Replace $publicationId with the actual publication ID --> --}}
            <input type="hidden" name="vid" value="{{ $vid }}">
            <br>
            <span style="color:black;">À noter que les champs comportant l'étoile (<span style="color:red;">*</span>) sont obligatoires.</span>
            <br><br>
            <button type="submit" class="btn btn-primary">Soumettre</button>
            <a href="{{ route("notifications") }}"><button type="button" class="btn btn-secondary">Retour</button></a>
        </form>
    </div>


    <style>
        #etoilesLabel{
            text-align: center !important;
            display: block;
            margin: auto !important;
        }
        .rate {
            /* float: left; */
            margin:auto;
            height: 6rem;
            padding: 0 10px;
            width: fit-content;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 3rem;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 3rem;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
            /* border-bottom: 1px solid #ffc700; */
            transition:.1s;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #daab04;
            transition:.1s;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #daab04;
        }
        .rate>input:active~label{
            /* outline: solid 2px black; */
            font-size: 4rem;
            transition:.01s !important;
            /* background-color: #daab04; */
        }
    </style>
@endsection
