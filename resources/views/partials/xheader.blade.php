<div id="xheader">
    <!--Usefull link : https://www.fundaofwebit.com/laravel-8/how-to-show-success-message-in-laravel-8-->
    <!-- Include jQuery Toast CSS and JS files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @if (session()->has('message'))
        {{-- <div class="alert alert-success" id="success">
            {{ session()->get('message') }}
        </div>
        <script>
            window.addEventListener("DOMContentLoaded", (event) => {

                ///////////////////////////
                //Usefull link : https://www.geeksforgeeks.org/how-to-hide-div-element-after-few-seconds-in-jquery/
                //const urlParams = new URLSearchParams(queryString);


                alertc = document.getElementById("success");

                // Add the 'hidden' class after a delay
                let delayInSeconds = 3; // Set your desired delay time in seconds
                setTimeout(() => {
                    alertc.classList.add("hiddenalert");
                }, delayInSeconds * 1000);
            });

        </script> --}}
        <script>
            $(() => {
                Toastify({
                    text: '{{ session()->get('message') }}',
                    duration: 5000,
                    position: "center",
                    gravity: "bottom",
                    close: true,
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "#008000",
                        borderRadius: "15px",
                        fontSize: '20px',
                    },
                }).showToast();

            })
        </script>
    @endif
    <header>
        <div class="header-container">
            <div class="menu-icon">
                <i class="fa fa-bars" style="font-size: 1.5em;color:white;"></i>
            </div>
            <div class="app-name">
                <a href="/" style="text-decoration: none; color:white;font-family: Trajan Pro;
                font-style: italic;
                font-weight: bold;font-size:25px;text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.3);">
                    <h1>@yield('appname')</h1>
                </a>
            </div>
            <nav class="nav">
                <ul class="ul-menu">
                    <li class="div-with-slash"><a href="/publication">Trouver un véhicule</a></li>
                    @auth
                        <li class="div-with-slash"><a href="/users/{{ Auth::id() }}">Mes annonces</a></li>
                        <li class="div-with-slash"><a href="/publication/create">Publier une annonce</a></li>
                        <li class="div-with-slash" id="messagerie-li"><a href="/messages">Messagerie</a></li>
                        @if (Auth()->user()->isAdmin())
                            <li class="div-with-slash"><a href="/admin">Centre des demandes</a></li>
                        @endif
                        {{-- <li><a href="/publications/saved">Annonces suivies</a></li> --}}
                        <li class="div-with-slash" id="btn-deco-mobile">
                            <form action="/logout" method="GET" class="d-flex align-items-top">
                                @csrf
                                <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco"
                                    style="gap: 20px;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <div>Se deconnecter</div>

                                </button>
                            </form>
                        </li>
                        <br>
                    @endauth
                </ul>
            </nav>

            <div class="grid-for-header">
                @auth

                    <div
                        style="
                        display: flex;
                        justify-content: center;
                        align-items: center; 
                        gap:15px;
                        ">
                        <a class="d-flex align-items-center noDec" href="/notifications"><i
                                style="color: white;font-size:1.5em;" class="fa fa-bell"></i></a>
                        <a class="d-flex align-items-center noDec no-mobile" href="/messages"><i
                                style="color: white;font-size:1.5em; " class="fa fa-message"></i></a>

                    </div>

                    <a href="/users/{{ Auth::id() }}">
                        <div class="imgProfile" style="background-image: url('{{ Auth::user()->getImage() }}')"></div>
                    </a>

                    <form action="/logout" method="GET" style="align-items:center; height: 100%; display:flex;">
                        @csrf
                        <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco-desktop"
                            style="gap: 0px; font-size:20px;">
                            <i class="fas fa-sign-out-alt xihover"></i>
                            {{-- <div>Se deconnecter</div> --}}

                        </button>
                    </form>
                @else
                    <a class="fas fa-sign-in-alt" href="/login" style="color:inherit; text-decoration:none;margin-left:auto;">
                    </a>
                @endauth
            </div>

        </div>
    </header>
</div>


<style>
    .header-container {
        height: 50px;
    }

    .xihover:hover {
        /* color:black;
        transition:.2s; */
    }

    /* Ajoutez du CSS pour rendre le bouton carré sur les appareils mobiles */
    @media (orientation: portrait) {
        .login-button {
            width: .1rem;
            /* Définissez la largeur et la hauteur du bouton carré */
            height: 3rem;
            font-size: 1rem;
            /* Réglez la taille de l'icône */
            display: flex;
            align-items: center;
            justify-content: center;
            /* Centre l'icône horizontalement */
        }

        .no-mobile {
            display: none !important;
        }

        .grid-for-header {
            grid-template-columns: auto auto !important;
            column-gap: 5px !important;
        }
        .header-container{
            padding: 0 5px 0 5px !important;
        }

        .imgProfile{
            margin: 0 .5rem 0 .5rem !important;
        }

        #messagerie-li{
            display: block !important;
        }

    }

    /* Ajoutez le style pour l'image de profil ici */
    .imgProfile {
        width: 2.5rem;
        height: 2.5rem;
        margin: 0 1rem 0 1rem;
        border-radius: 100%;
        outline: 3px solid var(--blueForms);
        background-size: cover;
        background-repeat: no-repeat;
    }

    .grid-for-header {
        width: 20%;
        display: grid;
        grid-template-rows: auto;
        /* grid-template-columns: auto auto auto; */
        grid-template-columns: repeat(auto-fit,minmax(40px,1fr));
        gap: auto;
    }
    #messagerie-li{
        display: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const menuIcon = document.querySelector(".menu-icon");
        const navLinks = document.querySelector(".nav ul");

        menuIcon.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });


    });
</script>
