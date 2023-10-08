@extends('partials.xlayout')

@section('title', "Page de publication")

@section('content')
<head>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="align-center">
    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
        <form class="form-style" method="post" action="{{route('image.store')}}" enctype="multipart/form-data">
            <div>
                <h1>Ajoutez des images à votre annonce</h1>
            </div>
            <br>
            <a style="margin:0px;width:5em;" href="../publication" class="buttonEffect">RETOUR</a>
            <!--For Security-->
            @csrf
            @method('post')
            <!--////////////-->

            <!--Form Content-->
            <!--Gets all the owner's publication so he can link the uploaded images to the publication's id-->
            <select style="width: fit-content;">
                <option disabled selected value="">*Choisissez votre annonce*</option>
            </select><label class="important"> * </label>
            <div id="image-container">
                <!-- Les images uploadées seront affichées ici -->
            </div>
            <br>
            <input type="file" id="image-input" name="images[]" accept="image/*" multiple style="display:none;">
            <button class="buttonEffect" type="button" onclick="document.getElementById('image-input').click();">Ajouter une image</button>
            <h4>Il faut être connecté pour ajouter des images sur une annonce dont vous êtes propriétaire.</h4>
            <hr>
            <!--Form Content-->

            <br>
            <div>
                <input class="buttonEffect" type="submit" value="Ajouter les image à la publication"/>
            </div>
            <br>
        </form>
    <div>


<script>
    //Source : https://codepen.io/mrtokachh/pen/LYGvPBj and chat gpt
    const imageContainer = document.getElementById('image-container');
    
    const imageInput = document.getElementById('image-input');

    imageInput.addEventListener('change', handleImageUpload);

    function handleImageUpload() {
        const files = imageInput.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const imagePreview = document.createElement('div');
                imagePreview.className = 'image-preview';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'image-css';

                const removeButton = document.createElement('span');
                removeButton.className = 'remove-image';
                removeButton.innerText = 'X';
                removeButton.addEventListener('click', () => {
                    imageContainer.removeChild(imagePreview);
                });

                imagePreview.appendChild(img);
                imagePreview.appendChild(removeButton);
                imageContainer.appendChild(imagePreview);
            }
        }
    }
    //Chat gpt
</script>
@endsection