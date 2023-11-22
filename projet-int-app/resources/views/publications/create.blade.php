@extends('partials.xlayout')

@section('title')
    <h1 id="xtitle">Page de publication</h1>
@endsection

@section('content')
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
                <input id="postalReg" oninput="validatePostalCode(this)" class="inputForm" oninput="convertToUpperCase(this)" type="text" required name="postalCode"
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

                </select>

                <script defer>
                    $(() => {
                        const data = {
                            brand: [
                                "*Marque*",
                                "Acura", "Alfa Romeo", "Audi", "BMW", "Buick", "Cadillac", "Chevrolet", "Chrysler",
                                "Dodge",
                                "Ford", "GMC", "Honda", "Hyundai", "Infiniti", "Jeep", "Kia", "Lamborghini", "Lexus",
                                "Lincoln",
                                "Mazda", "Mercedes-Benz", "Nissan", "Porsche", "Ram", "Subaru", "Tesla", "Toyota",
                                "Volkswagen", "Volvo", "Autre"
                            ],
                            bodyType: [
                                "*Carrosserie*",
                                "Berline", "VUS", "Camionnette", "Cabriolet", "Hatchback", "Fourgonnette", "Autre"
                            ],
                            transmission: [
                                "*Transmission*",
                                "Manuelle", "Automatique", "Autre"
                            ],
                            color: [
                                "*Couleur*",
                                "Blanche", "Noir", "Gris", "Rouge", "Bleu", "Vert", "Jaune", "Orange", "Autre"
                            ],
                            fuelType: [
                                "*Type d'essence*",
                                "Essence", "Diesel", "Électrique", "Autre"
                            ]
                        };

                        function generateOptions(dataArray, selectedValue) {
                            return $.map(dataArray, function(value) {
                                const isSelected = (selectedValue === value) ? 'selected' : '';
                                return `<option value='${value}' ${isSelected}>${value}</option>`;
                            });
                        }

                        $("#brand").append(generateOptions(data.brand, "{{ @$publication->brand }}"));
                        $("#bodyType").append(generateOptions(data.bodyType, "{{ @$publication->bodyType }}"));
                        $("#transmission").append(generateOptions(data.transmission, "{{ @$publication->transmission }}"));
                        $("#color").append(generateOptions(data.color, "{{ @$publication->color }}"));
                        $("#fuelType").append(generateOptions(data.fuelType, "{{ @$publication->fuelType }}"));




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
                <style>
                    .switch {
                    position: relative;
                    display: inline-block;
                    width: 60px;
                    height: 34px;
                    }

                    .switch input { 
                    opacity: 0;
                    width: 0;
                    height: 0;
                    }

                    .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    -webkit-transition: .4s;
                    transition: .4s;
                    }

                    .slider:before {
                    position: absolute;
                    content: "";
                    height: 26px;
                    width: 26px;
                    left: 4px;
                    bottom: 4px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                    }

                    input:checked + .slider {
                    background-color: #004aad;
                    }

                    input:focus + .slider {
                    box-shadow: 0 0 1px #004aad;
                    }

                    input:checked + .slider:before {
                    -webkit-transform: translateX(26px);
                    -ms-transform: translateX(26px);
                    transform: translateX(26px);
                    }

                    /* Rounded sliders */
                    .slider.round {
                    border-radius: 34px;
                    }

                    .slider.round:before {
                    border-radius: 50%;
                    }
                </style>
                <input type="hidden" name="type" value="0"/>
                <div class="switches_styling">
                    <span style="white-space: nowrap;" class="detail-text-emphasis">Prix fixe</span>
                    <label for="checkbox_1" class="switch" style="display: flex;
                    align-items: center;
                    justify-content: center;margin:auto;">
                            <input id="checkbox_1" class="custom-radio" type="checkbox" name="type"
                            @if(isset($publication))
                                {{ $publication->type == 1 ? 'checked value=1' : 'value=0' }}
                            @else
                                value="0"
                            @endif
                            onchange="toggleExpirationInput()" />
                            <span class="slider round"></span>
                    </label>
                    <span class="detail-text-emphasis">Enchère</span>
                </div>
            </div>

            <div style="display: {{ isset($publication) && $publication->type == 1 ? 'block' : 'none' }}"
                id="expirationOfBidInput">
                <label>Date de fin de l'enchère</label>
                <br>
                <input class="inputForm" type="date" min="{{ date('Y-m-d') }}"
                    value="{{ isset($publication) ? $publication->expirationOfBid : date('Y-m-d', strtotime('+7 days')) }}"
                    name="expirationOfBid" placeholder="date" />
            </div>
            <input type="hidden" name="hidden" value="0"/>
            <div class="switches_styling">
                <span class="detail-text-emphasis">Privé</span>
                <label for="checkbox_2" class="switch" style="display: flex;
                align-items: center;
                justify-content: center;margin:auto;">
                        <input id="checkbox_2" class="custom-radio" type="checkbox" name="hidden"
                        @if(isset($publication))
                            {{ $publication->hidden == 1 ? 'checked value=1' : 'value=0' }}
                        @else
                            value="0"
                        @endif
                            onchange="togglePublicInput()" />
                        <span class="slider round"></span>
                </label>
                <span class="detail-text-emphasis">Publique</span>
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
    let isPublic = false;
    if(document.getElementById("checkbox_2").value == 1)
    {
        let isPublic = true;
    }
    function togglePublicInput() {
        var expirationInput = document.getElementById("expirationOfBidInput");
        //Makes the style change if the param (show) is true or false
        if (isPublic) {
            document.getElementById("checkbox_2").value = 0
            isPublic = false;
        } else {
            document.getElementById("checkbox_2").value = 1
            isPublic = true;
        }
    }

    let showExpiration = false;
    if(document.getElementById("checkbox_1").value == 1)
    {
        showExpiration = true;
    }
    function toggleExpirationInput() {
        var expirationInput = document.getElementById("expirationOfBidInput");
        //Makes the style change if the param (show) is true or false
        if (showExpiration) {
            document.getElementById("checkbox_1").value = 0
            expirationInput.style.display = "none";
            showExpiration = false;
        } else {
            document.getElementById("checkbox_1").value = 1
            expirationInput.style.display = "";
            showExpiration = true;
        }
    }

    function validatePostalCode(input) {
        // Remove any non-alphanumeric characters except the first letter
        let sanitizedInput = input.value.replace(/[^A-Za-z0-9]/g, '');
        
        // Ensure the first character is a letter
        if (/^[A-Z]\d[A-Z]$/.test(sanitizedInput) && sanitizedInput.length <= 3) 
        {
            // Update the input value
            input.value = sanitizedInput.toUpperCase();
        } else {
            // Clear the input if the pattern is not met
            input.value = sanitizedInput.slice(0, -1).toUpperCase();
            input.value = sanitizedInput.slice(0, 3).toUpperCase();
        }
    }

    document.querySelector('#hintActivator').addEventListener('mouseenter', function() {
        document.querySelector('#hint').classList.add('active');
    });
    document.querySelector('#hintActivator').addEventListener('mouseleave', function() {
        document.querySelector('#hint').classList.remove('active');
    });
</script>
</body>
@endsection
