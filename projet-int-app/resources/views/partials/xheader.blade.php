<div id="xheader">
    <!--Usefull link : https://www.fundaofwebit.com/laravel-8/how-to-show-success-message-in-laravel-8-->
    @if (session()->has('message'))
        <div class="alert alert-success" id="success">
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
            </script>
    @endif
    <header>
        <div class="header-container">
            <div class="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="app-name">
                <a href="/" style="text-decoration: none; color:white;">
                    <h1>@yield('appname')</h1>
                </a>
            </div>
            <nav class="nav">
                <ul class="ul-menu">
                    <li><a href="/publication">Trouver un véhicule</a></li>
                    @auth
                        <li><a href="/users/{{ Auth::id() }}">Mes annonces</a></li>
                        <li><a href="/publication/create">Publier une annonce</a></li>
                        {{-- <li><a href="/publications/saved">Annonces suivies</a></li> --}}
                        <li id="btn-deco-mobile">
                            <form action="/logout" method="GET" class="d-flex align-items-top">
                                @csrf
                                <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco" style="gap: 20px;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <div>Se deconnecter</div>

                                </button>
                            </form>
                        </li>
                        <li>

                        </li>
                    @endauth
                </ul>
            </nav>

            <div style="width:15rem; display: grid; grid-template-rows: auto; grid-template-columns: auto auto auto;gap:auto;">
                @auth
                    {{-- <form action="/logout" method="GET">
                        <button class="login-button redlogout-button">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form> --}}

                    <div style="display: flex;
                    justify-content: center;
                    align-items: center; gap:4px;">
                        <a class="" href="/notifications"><i style="color: white; font-size: 2rem" class="fa fa-bell"></i></a>
                        <a class="" href="/messages"><i style="color: white; font-size: 2rem;" class="fa fa-message"></i></a>

                    </div>
                    <a href="/users/{{ Auth::id() }}">
                        <div class="imgProfile" style="background-image: url('{{ Auth::user()->getImage() }}')"></div>
                    </a>

                    <form action="/logout" method="GET" class="d-flex align-items-top" style="align-items:center; height: 100%; display:flex;">
                        @csrf
                        <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco-desktop"
                            style="gap: 0px; font-size:2rem;">
                            <i class="fas fa-sign-out-alt xihover"></i>
                            {{-- <div>Se deconnecter</div> --}}

                        </button>
                    </form>
                @else
                    <a href="/login">
                        <button class="login-button">
                            <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </a>
                @endauth
            </div>

        </div>
    </header>
</div>


<style>
    .header-container{

    }
    .xihover:hover{
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
    }

    /* Ajoutez le style pour l'image de profil ici */
    .imgProfile {
        width: 3rem;
        height: 3rem;
        margin-left: 1rem;
        border-radius: 100%;
        outline: 3px solid var(--blueForms);
        background-size: cover;
        background-repeat: no-repeat;
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
