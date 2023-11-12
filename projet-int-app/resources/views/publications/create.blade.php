@extends('partials.xlayout')

@section('title', 'Page de publication')

@section('content')
    @push('css')
        @vite(['resources/css/publication.css'])
    @endpush
    <style momo="PERMET DE BAISSER LE WIDTH">
        @media (min-width: 768px) {
            .xreducteur {
                width: 60%;
            }
        }

        @media (max-width: 767px) {
            .xreducteur {
                width: 90%;
            }
        }
    </style>

    <body>
        <div class="align-center">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (isset($isEdit))
                <form class="form-style xreducteur" method="post" action="{{ route('publication.update', ['id' => $pid]) }}">
                @else
                    <form class="form-style xreducteur" method="post" action="{{ route('publication.store') }}">
            @endif
            <br>
            <div>
                <h1>Informations de l'annonce</h1>
            </div>
            <br>
            <hr>
            <!--<a style="width:10rem;" href="{{ route('publication.index') }}" class="buttonEffect">RETOUR</a>-->
            <br>
            <!--For Security-->
            @csrf
            @method('post')
            <!--////////////-->
            <div>
                <input class="inputForm" type="text" maxlength="32" name="title" required
                    placeholder="Titre (Suggestion : Marque Modèle Année)"
                    value="{{ isset($publication) ? $publication->title : old('title') }}" />
            </div>
            <div>
                <textarea type="textarea" rows="9" maxlength="500" required name="description" placeholder="Description">{{ isset($publication) ? $publication->description : old('description') }}</textarea>
            </div>
            <div id="hintActivator">
                <div>
                    <div id="hint"
                        style="width:80%;border-radius:5px;margin:auto;background-color: #004aad; color: white;">
                        Lorsque vous optez pour le type d'annonce (Enchère), le prix correspondra au montant minimal requis
                        pour la première enchère
                    </div>
                </div>
                <input class="inputForm" type="number" max="9999999" min="0" step=".01" required
                    name="fixedPrice" placeholder="Prix"
                    value="{{ isset($publication) ? $publication->fixedPrice : old('fixedPrice') }}" />
            </div>
            <div>
                <input class="inputForm" oninput="convertToUpperCase(this)" type="text" required name="postalCode"
                    placeholder="Code postal ex: A1B" pattern="^[A-Z]\d[A-Z]"
                    value="{{ isset($publication) ? $publication->postalCode : old('postalCode') }}" />
            </div>
            @if (isset($isEdit))
                <div style="margin: auto; width: 90%;">
                    <a style="width:10rem;" href="{{ route('image.edit', ['id' => $publication->id]) }}"
                        class="buttonEffect">Gérer les images</a>
                </div>
            @endif
            <br>
            <hr>
            <br>
            <div>
                <h1>Informations du véhicule</h1>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <input class="inputForm" type="number" max="999999" min="0" step="1" name="kilometer"
                    required placeholder="Kilomètrage"
                    value="{{ isset($publication) ? $publication->kilometer : old('kilometer') }}" />
            </div>
            <div>
                <input class="inputForm" type="number" max="2040" min="1700" step="1" name="year" required
                    placeholder="Année" value="{{ isset($publication) ? $publication->year : old('year') }}" />
            </div>
            <div>
                <!--Vérifier que ça n'est pas null-->


                <select class="selectors" id="brand" name="brand" required>
                    {{-- <option disabled selected value="">*Marque*</option>
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
                    <option value="Lamborghini">Lamborghini</option>
                    <option value="Lexus">Lexus</option>
                    <option value="Lincoln">Lincoln</option>
                    <option value="Mazda">Mazda</option>
                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                    <option value="Nissan">Nissan</option>
                    <option value="Porsche">Porsche</option>
                    <option value="Ram">Ram</option>
                    <option value="Subaru">Subaru</option>
                    <option value="Tesla">Tesla</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Volkswagen">Volkswagen</option>
                    <option value="Volvo">Volvo</option>
                    <option value="Autre">Autre</option> --}}
                </select>

                <script defer>
                    $(() => {
                        const brand = [
                            "*Marque*",
                            "Acura",
                            "Alfa Romeo",
                            "Audi",
                            "BMW",
                            "Buick",
                            "Cadillac",
                            "Chevrolet",
                            "Chrysler",
                            "Dodge",
                            "Ford",
                            "GMC",
                            "Honda",
                            "Hyundai",
                            "Infiniti",
                            "Jeep",
                            "Kia",
                            "Lamborghini",
                            "Lexus",
                            "Lincoln",
                            "Mazda",
                            "Mercedes-Benz",
                            "Nissan",
                            "Porsche",
                            "Ram",
                            "Subaru",
                            "Tesla",
                            "Toyota",
                            "Volkswagen",
                            "Volvo",
                            "Autre"
                        ];
                        const bodyType = [
                            "*Carrosserie",
                            "Berline",
                            "VUS",
                            "Camionnette",
                            "Cabriolet",
                            "Hatchback",
                            "Fourgonnette",
                            "Autre"
                        ];
                        const transmission = [
                            "*Transmission*",
                            "Manuelle",
                            "Automatique",
                            "Autre"
                        ];
                        const color = [
                            "*Couleur*",
                            "Blanche",
                            "Noir",
                            "Gris",
                            "Rouge",
                            "Bleu",
                            "Vert",
                            "Jaune",
                            "Orange",
                            "Autre"
                        ];
                        const fuelType = [
                            "*Type d'essence",
                            "Essence",
                            "Diesel",
                            "Électrique",
                            "Autre",
                        ];


                        // @ devant $publication vient accepter le mot undefined pour utiliser et evite erreur
                        let options = $.map(brand, function(n, i) {

                            if (`{{ @$publication->brand }}` == n)
                                return (`<option value=${n} selected>${n}</option>`);
                            return (`<option value=${n}>${n}</option>`);
                        });
                        $("#brand").append(options);
                        options = [];
                        options = $.map(bodyType, function(n, i) {

                            if (`{{ @$publication->bodyType }}` == n)
                                return (`<option value=${n} selected>${n}</option>`);
                            return (`<option value=${n}>${n}</option>`);
                        });
                        $("#bodyType").append(options);
                        options = [];
                        options = $.map(transmission, function(n, i) {
                            if (`{{ @$publication->transmission }}` == n)
                                return (`<option value=${n} selected>${n}</option>`);
                            return (`<option value=${n}>${n}</option>`);
                        });
                        $("#transmission").append(options);
                        options = [];
                        options = $.map(color, function(n, i) {
                            if (`{{ @$publication->color }}` == n)
                                return (`<option value=${n} selected>${n}</option>`);
                            return (`<option value=${n}>${n}</option>`);
                        });
                        $("#color").append(options);
                        options = [];
                        options = $.map(fuelType, function(n, i) {
                            if (`{{ @$publication->fuelType }}` == n)
                                return (`<option value=${n} selected>${n}</option>`);
                            return (`<option value=${n}>${n}</option>`);
                        });
                        $("#fuelType").append(options);



                    });
                </script>
            </div>
            <div>
                <select class="selectors" id="bodyType" name="bodyType" required>

                </select>
            </div>
            <div>
                <select class="selectors" id="transmission" name="transmission" required>

                </select>
            </div>
            <div>
                <select class="selectors" id="color" name="color" required>

                </select>
            </div>
            <div>
                <select class="selectors" id="fuelType" name="fuelType" required>

                </select>
            </div>
            <div style="display:block; align-items:center;">
                <br>
                <label class="form-text-styling">Type d'annonce</label>
                <!--0=No Bid 1= With Bid-->
                <br>
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                    <input class="custom-radio" type="radio" name="type" value="0"
                        {{ isset($publication) && $publication->type == 0 ? 'checked' : '' }}
                        onchange="toggleExpirationInput(false)" />
                    <label class="width10">Prix fixe</label>
                </div>
                <br>
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                    <input class="custom-radio" type="radio" name="type" value="1"
                        {{ isset($publication) && $publication->type == 1 ? 'checked' : '' }}
                        onchange="toggleExpirationInput(true)" />
                    <label class="width10">Enchère</label>
                </div>
            </div>
            <br>
            <div style="display: {{ isset($publication) && $publication->type == 1 ? 'block' : 'none' }}"
                id="expirationOfBidInput">
                <label>Date de fin de l'enchère</label>
                <br>
                <input class="inputForm" type="date" min="{{ date('Y-m-d') }}"
                    value="{{ isset($publication) ? $publication->expirationOfBid : date('Y-m-d', strtotime('+7 days')) }}"
                    name="expirationOfBid" placeholder="date" />
            </div>
            <div style="display:block; align-items:center;">
                <br>
                <label class="form-text-styling">Visibilité</label>
                <br>
                <!--0=Not visible 1= visible-->
                <div style="display: flex;
                align-items: center;
                justify-content: center;">
                    <input class="customRadio" type="radio" name="hidden" value="1"
                        {{ isset($publication) && $publication->hidden == 1 ? 'checked' : '' }} />
                    <label class="width10">Publique</label>
                </div>
                <br>
                <div
                    style="display: flex;
                    align-items: center;
                    justify-content: center;">
                    <input class="customRadio" type="radio" name="hidden" value="0"
                        {{ isset($publication) && $publication->hidden == 0 ? 'checked' : '' }} />
                    <label class="width10">Privée</label>
                </div>
            </div>
            <br>
            <!--ul for spacing-->
            <ul>
                <input class="buttonEffect" type="submit"
                    value="{{ isset($isEdit) ? 'Mettre à jour' : 'Créer' }} l'annonce" />
                <br>
                @if (isset($isEdit) && $publication->type == 0)
                    <label>Votre annonce s'est vendu?</label>
                    <a title="Afficher cette annonce comme 'vendu'"
                        href="{{ route('publication.sold', ['id' => "$publication->id"]) }}"
                        class="buttonEffect">Afficher
                        cette annonce comme 'vendu' !</a>
                    <br>
                @endif
                @if (isset($isEdit))
                    <a title="Supprimer l'annonce" href="{{ route('publication.delete', ['id' => "$publication->id"]) }}"
                        class="buttonEffect">Supprimer</a>
                @endif
            </ul>
            <br>
            </form>
        </div>
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
        </script>
        <script>
            document.querySelector('#hintActivator').addEventListener('mouseenter', function() {
                document.querySelector('#hint').classList.add('active');
            });
            document.querySelector('#hintActivator').addEventListener('mouseleave', function() {
                document.querySelector('#hint').classList.remove('active');
            });
        </script>
    </body>
@endsection
