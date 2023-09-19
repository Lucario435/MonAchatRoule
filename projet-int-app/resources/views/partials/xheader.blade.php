<div id="xheader">
    <header>
        <div class="header-container">
            <h1>@yield("appname")</h1>
            <nav class="nav">
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
            </nav>
            <button class="login-button">Connexion</button>
            <div class="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>
    </header>
    <script>
            document.addEventListener("DOMContentLoaded", function () {
                const menuIcon = document.querySelector(".menu-icon");
                const navLinks = document.querySelector(".nav ul");

                menuIcon.addEventListener("click", function () {
                    navLinks.classList.toggle("active");
                });
            });
    </script>
</div>

