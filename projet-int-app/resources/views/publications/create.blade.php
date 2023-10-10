@extends('partials.xlayout')

@section('title', "Page de publication")

@section('content')
<head>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="align-center">
    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
        <form class="form-style" method="post" action="{{route('publication.store')}}">
            <div>
                <h1>Informations de l'annonce</h1>
            </div>
            <hr>
            <a style="margin:0px;width:5em;" href="../publication" class="buttonEffect">RETOUR</a>
            <!--For Security-->
            @csrf
            @method('post')
            <!--////////////-->
            <div>
                <input class="inputForm" type="text" maxlength="32" name="title" required placeholder="Titre"/><label class="important"> * </label>
            </div>
            <br>
            <div>
                <textarea type="textarea" rows="10" name="description" placeholder="Description" ></textarea>
            </div>
            <div style="display:block; align-items:center;">
                <br>
                <label>Type d'annonce</label><label class="important"> * </label>
                <!--0=No Bid 1= With Bid-->
                <br>
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                <input class="custom-radio" type="radio" name="type" value="0" checked="checked" onchange="toggleExpirationInput(false)"/>
                <label class="width10">Prix fixe</label>
                </div>
                <br>
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                <input class="custom-radio" type="radio" name="type" value="1" onchange="toggleExpirationInput(true)"/>
                <label class="width10">Enchère</label>
                </div>
            </div>
            <br>
            <div style="display: none" id="expirationOfBidInput">
                <label>Date de fin de l'enchère</label>
                <br>
                <?php
                    //Takes 7 day as a default value for the end of bid starting by today's date
                    $datetime = new DateTime();
                    $datetime->modify('+7 day');
                    $datetime = $datetime->format('Y-m-d');
                    echo "<input class=\"inputForm\" type=\"date\" value=\"$datetime\" name=\"expirationOfBid\" placeholder=\"date\"/><label class=\"important\"> * </label>"
                ?>
            </div>
            <div style="display:block; align-items:center;">
                <br>
                <label>Visibilité</label><label class="important"> * </label>
                <br>
                <!--0=Not visible 1= visible-->
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                    <input class="customRadio" type="radio" name="hidden" value="1" checked="checked" />
                    <label class="width10">Publique</label>
                </div>
                <br>
                <div style="display: flex;
                    align-items: center;
                    justify-content: center;">
                    <input class="customRadio" type="radio" name="hidden" value="0" />
                    <label class="width10">Privée</label>
                </div>
            </div>
            <br>
            <div>
                <input class="inputForm" type="number" max="9999999" min="0" step=".01" required name="fixedPrice" placeholder="Prix"/><label class="important"> * </label>
            </div>
            <div>
                <input class="inputForm" oninput="convertToUpperCase(this)" type="text" required name="postalCode" placeholder="Code postal ex: A1B 2C3" pattern="^[A-Z]\d[A-Z] \d[A-Z]\d$"/><label class="important"> * </label>
            </div>
            <hr>
            <div>
                <h1>Informations du véhicule</h1>
            </div>
            <hr>
            <div>
                <input class="inputForm" type="number" max="999999" min="0" step="1" name="kilometer" required placeholder="Kilomètrage"/><label class="important"> * </label>
            </div>
            <div>
                <!--Vérifier que ça n'est pas null-->
                <select id="brand" name="brand" required>
                    <option disabled selected value="">*Marque*</option>
                    <option value="Acura">Acura</option>
                    <option value="Alfa Romeo">Alfa Romeo</option>
                    <option value="Audi">Audi</option>
                    <option value="BMW">BMW</option>
                    <option value="Buick">Buick</option>
                    <option value="Cadillac">Cadillac</option>
                    <option value="Chevrolet">Chevrolet</option>
                    <option value="Chrysler">Chrysler</option>
                    <option value="Dodge">Dodge</option>
                    <option value="Ford">Ford</option>
                    <option value="GMC">GMC</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyundai">Hyundai</option>
                    <option value="Infiniti">Infiniti</option>
                    <option value="Jeep">Jeep</option>
                    <option value="Kia">Kia</option>
                    <option value="Lexus">Lexus</option>
                    <option value="Lincoln">Lincoln</option>
                    <option value="Mazda">Mazda</option>
                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                    <option value="Nissan">Nissan</option>
                    <option value="Ram">Ram</option>
                    <option value="Subaru">Subaru</option>
                    <option value="Tesla">Tesla</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Volkswagen">Volkswagen</option>
                    <option value="Volvo">Volvo</option>
                    <option value="Autre">Autre</option>
                </select><label class="important"> * </label>
            </div>
            <div>
                <select id="bodyType" name="bodyType" required>
                    <option disabled selected value="">*Carosserie*</option>
                    <option value="Berline">Berline</option>
                    <option value="VUS">VUS</option>
                    <option value="Camionnette">Camionnette</option>
                    <option value="Coupé">Coupé</option>
                    <option value="Cabriolet">Cabriolet</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Fourgonnette">Fourgonnette</option>
                    <option value="Autre">Autre</option>
                </select><label class="important"> * </label>
            </div>
            <div>
                <select id="transmission" name="transmission" required>
                    <option disabled selected value="">*Transmission*</option>
                    <option value="Automatique">Automatique</option>
                    <option value="Manuelle">Manuelle</option>
                    <option value="Autre">Autre</option>
                </select><label class="important"> * </label>
            </div>
            <div>
                <select id="color" name="color" required>
                    <option disabled selected value="">*Couleur*</option>
                    <option value="orange">Blanc</option>
                    <option value="Noir">Noir</option>
                    <option value="Gris">Gris</option>
                    <option value="Rouge">Rouge</option>
                    <option value="Bleu">Bleu</option>
                    <option value="Vert">Vert</option>
                    <option value="Jaune">Jaune</option>
                    <option value="Orange">Orange</option>
                    <option value="Autre">Autre</option>
                </select><label class="important"> * </label>
            </div>
            <br>
            <!--ul for spacing-->
            <ul>
                <input class="buttonEffect" type="submit" value="Créer l'annonce"/>
            </ul>

            <br>
        </form>
    <div>
        <script>
            function toggleExpirationInput(show) {
                var expirationInput = document.getElementById("expirationOfBidInput");
                //Makes the style change if the param (show) is true or false
                if (show) {
                    expirationInput.style.display = "";
                } else {
                    expirationInput.style.display = "none";
                }
            }

            function convertToUpperCase(input) {
                input.value = input.value.toUpperCase();
            }
            
            //This function gets the date of today and return the date of the week after
            function getTomorrowDate(){
                const today = new Date();
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                return tomorrow;
            }
            //------------------------------
        </script>
@endsection