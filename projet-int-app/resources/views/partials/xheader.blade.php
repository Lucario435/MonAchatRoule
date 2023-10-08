<div id="xheader">
    <!--Usefull link : https://www.fundaofwebit.com/laravel-8/how-to-show-success-message-in-laravel-8-->
    @if(session()->has('message'))
        <div class="alert alert-success" id="success">
            {{ session()->get('message') }}
        </div>
    @endif
    <script>
        //Usefull link : https://www.geeksforgeeks.org/how-to-hide-div-element-after-few-seconds-in-jquery/
        window.addEventListener("DOMContentLoaded", (event) => {
            //const urlParams = new URLSearchParams(queryString);


            alertc = document.getElementById("success");
            let tempsEnSec = 3;
            setTimeout(() =>{
                alertc.style["font-size"] = 0;
            },tempsEnSec*1000);
        });
    </script>

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

