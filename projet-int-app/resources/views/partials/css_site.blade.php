<style>
    :root{
        --blueheader: #004aad; /* Bleu */
        --blueForms: #004aad;;
        --greenbutton: #27ae60;
        --greenbuttonhover: rgb(0, 159, 0);
    }
/* Reset some default styles for better consistency */
body, h1, ul, li {
    margin: 0;
    padding: 0;
}
/* Styles pour l'en-tête */
header {
    background-color: var(--blueheader);
    color: white;
    padding: 20px 0;
}

.header-container {
    display: grid;
    grid-template-columns: repeat( auto-fit, minmax(300px, 1fr) );
    justify-content: center;
    align-items: center;
    max-width: 90%;
    margin: 0 auto;
    padding: 0 20px;
}

h1 {
    font-size: 24px;
}

.nav ul {
    list-style-type: none;
}

.nav ul li {
    display: inline;
    margin-right: 1rem;
    margin-left: 1rem;
     /* text-align: center; */
}

.nav ul li a {
    color: white;
    text-decoration: none;
}

.login-button {
    background-color: var(--greenbutton); /* Vert */
    color: white;
    padding: .8rem 2rem;
    text-decoration: none;
    border: none;
    outline: greenyellow solid 1px;
    border-radius: 5px;
    cursor: pointer;
    transition: .2s;
}
.login-button:hover{
    background-color: var(--greenbuttonhover);
    outline: greenyellow solid 2px;
    font-weight: bolder;
    transition: .2s;
    padding: .8rem 2.5rem;
}

.menu-icon {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.bar {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 3px 0;
}

/* menu hamberger pour mobile */
@media (orientation: portrait) {
    .nav ul {
        display: none;
        flex-direction: column;
        background-color: #243a7a; /* Fond du menu hamburger */
        position: absolute;
        top: 4rem;
        right: 0;
        left: 0;
        transition: .2s;
        font-weight: lighter;
    }

    .nav ul.active {
        display: flex;
        transition: .2s;
        font-weight: lighter;
    }

    .menu-icon {
        display: flex;
        transition: .2s;
        flex-direction: column;
    }
}


/* ICI C HUMAIN vvv */

#xtitle{
    margin: auto;
    text-align: center;
    padding-top: 1rem;
    padding-bottom: 2rem;
}
</style>
