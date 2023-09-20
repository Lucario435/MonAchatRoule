<?php
if(isset($_POST['title']))
{
    echo('THIS WORKS');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Créez un produit</h1>
    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
    <form method="post" action="{{route('publication.store')}}">
        <!--For Security-->
        @csrf
        @method('post')
        <div>
            <label>Titre</label>
            <input type="text" name="title" required placeholder="Titre"/>
        </div>
        <div>
            <label>Description</label>
            <input type="text" name="description" placeholder="Description"/>
        </div>
        <div>
            <label>Type d'annonce</label>
            <!--0=non enchère 1= enchère-->
            <p>Enchère</p>
            <input type="radio" name="type" value="1" checked="checked" />
            <p>Prix fixe</p>
            <input type="radio" name="type" value="0" />
        </div>
        <div>
            <label>Visibilité</label>
            <!--0=non visible 1= visible-->
            <p>Publique</p>
            <input type="radio" name="hidden" value="1" checked="checked" />
            <p>Privée</p>
            <input type="radio" name="hidden" value="0" />
        </div>
        <div>
            <label>Prix</label>
            <input type="number" max="999999" min="0" step=".01" required name="fixedPrice" placeholder="Prix"/>
        </div>
        <div>
            <label>Date de fin de l'enchère</label>
            <input type="date" name="expirationOfBid" placeholder="date"/>
        </div>
        <div>
            <label>Code postal</label>
            <input type="text" required name="postalCode" placeholder="Code postal"/>
        </div>
        <div>
            <input type="submit" value="Créer l'annonce"/>
        </div>
    </form>
</body>
</html>