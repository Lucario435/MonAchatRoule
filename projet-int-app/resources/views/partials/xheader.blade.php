<div id="xheader">
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
                        <li><a href="/messages">Messagerie</a></li>
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
    @media (max-width: 768px) {
        .login-button {
            width: .1rem; /* Définissez la largeur et la hauteur du bouton carré */
            height: 3rem;
            font-size: 1rem; /* Réglez la taille de l'icône */
            display: flex;
            align-items: center;
            justify-content: center; /* Centre l'icône horizontalement */
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
