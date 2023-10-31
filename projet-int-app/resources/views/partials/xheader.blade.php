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
                alertc.style.display = "none";
                let tempsEnSec = 3;
                setTimeout(() => {
                    alertc.style.fontSize = "0px";
                }, tempsEnSec * 1000);
            });
        </script>
    @endif
    <header>
        <div class="header-container">
            <a href="/" style="text-decoration: none; color:white;">
                <h1>@yield('appname')</h1>
            </a>
            <nav class="nav">
                <ul>
                    <li><a href="/publication">Recherche</a></li>
                    @auth
                        <li><a href="/users/{{ Auth::id() }}">Mes annonces</a></li>
                        <li><a href="/publication/create">Publier une annonce</a></li>
                    @endauth
                </ul>
            </nav>

            <div style="display: grid; grid-template-columns: auto auto;">
                @auth
                    <form action="/logout" method="GET">
                        <button class="login-button redlogout-button">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                    <a href="/users/{{ Auth::id() }}">
                        <div class="imgProfile" style="background-image: url('{{ Auth::user()->getImage() }}')"></div>
                    </a>
                @else
                    <a href="/login">
                        <button class="login-button">
                            <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </a>
                @endauth
            </div>

            <div class="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
    </header>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
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
        // Added scroll listener
        // https://www.w3schools.com/howto/howto_js_sticky_header.asp
        // When the user scrolls the page, execute myFunction
        window.onscroll = function() {
            myFunction();
            //myFunction2();
            console.log('scroll');
        };

        // Get the header
        var header = document.querySelector("#xheader");
        var sideFilters = document.getElementById("page_filtre");

        // Get the offset position of the navbar
        var sticky = header.offsetTop;
        var sticky2 = sideFilters.offsetTop;

        //Init
        myFunction();

        // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function myFunction() {
            console.log(window.pageYOffset, ' > ', sticky)
            if (window.pageYOffset > sticky) {
                // header.classList.add("sticky");
                // sideFilters.classList.add("sticky-sidebar");
                toggleFixed();
            } else {
                toggleFixed();
            }
        }

        function toggleFixed() {
            $(header).addClass("sticky");
            $(sideFilters).addClass("sticky-sidebar");
            adjustWidth();
            
        }
        function RemoveFixed(){
            $(header).removeClass("sticky");
            $(sideFilters).removeClass("sticky-sidebar");
            adjustWidth();
        }

        function adjustWidth() {
            var parentwidth = $("body").width();
            $(header).width(parentwidth);
            $(sideFilters).width('350px');
        }


        const menuIcon = document.querySelector(".menu-icon");
        const navLinks = document.querySelector(".nav ul");

        menuIcon.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });
    });
</script>
