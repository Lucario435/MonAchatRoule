<div>
    <h2>Bonjour,</h2>
    <h3>L'annonce: <i><a href="{{ $url }}">{{ $title }}</i> vient d'être modifiée par son propriétaire.
    </h3>
    <ul>
        @foreach ($changedAttributesArray as $attr)
            <li>{{$attr}}</li>
        @endforeach
    </ul>
    <p>Cette notification automatisée vous est envoyée car vous suiviez une annonce</p>
    <p>MonAchatRoule - 2023</p>
</div>
