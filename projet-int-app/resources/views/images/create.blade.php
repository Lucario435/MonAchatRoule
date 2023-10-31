@extends('partials.xlayout')
@php
    use Illuminate\Support\Facades\Auth;
@endphp
@push('css')
    @vite(['resources/css/publication.css'])
@endpush
@section('title', 'Page de publication')
{{-- valeur possible: $pid, $isEdit --}}
@section('content')

    <body>
        <div class="align-center">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (isset($isEdit))
                <form class="form-style" method="post" action="{{ route('image.update', ['id' => isset($pid) ? $pid : '']) }}"
                    enctype="multipart/form-data">
                    {{-- <input type="hidden" name="publication_id" value="{{ isset($pid) ? $pid : '' }}"> --}}
                    <span>SUPPRIMEZ </span>
                    @if (isset($ilist))
                    <div class="imgdestroyer">
                        @foreach ($ilist as $i)

                                <a href="/image/delete/{{ $i->id }}"><img src="{{ asset($i->url)  }}" alt=""><sbutton>X</sbutton></a>

                        @endforeach
                    </div>
                        <style>
                            .imgdestroyer{display: flex;   justify-content: center; /* centers children elements horizontally */
  align-items: center;}
                            .imgdestroyer>a{width: 10rem; height: 10rem; position: relative;}
                            .imgdestroyer>a>img{width:100%;}
                            .imgdestroyer>a>sbutton{transition: .2s; display: block; color: white; font-weight: bolder; font-family: arial; position: absolute; top: 0; left: 0; background: rgb(194, 0, 0); width: 5rem; border: none; border-radius: 10px; outline: 2px solid rgb(255, 0, 0);}
                            .imgdestroyer>a>sbutton:hover{background: rgb(140, 0, 0); transition: .2s; }
                        </style>
                    @endif
                @else
                    <form class="form-style" method="post" action="{{ route('image.store') }}"
                        enctype="multipart/form-data">
            @endif

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
            <select style="width: fit-content;" name="publication_id">

                @if (isset($plist))
                    @if (count($plist) == 1)
                        {{-- @php dump($plist); @endphp --}}
                        <option selected value="{{ $plist[0]->id }}">{{ $plist[0]->title }}</option>
                    @else
                        @foreach ($plist as $p)
                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                        @endforeach
                    @endif
                @else
                    <option disabled selected value="{{ isset($pid) ? $pid : '' }}">*Choisissez votre annonce*</option>
                @endif

            </select><label class="important"> * </label>
            <div id="image-container">
                <!-- Les images uploadées seront affichées ici -->
            </div>
            <br>{{ Auth::user()->publications }}
            <input type="file" id="image-input" name="images[]" accept="image/*" multiple style="display:none;">
            <button class="buttonEffect" type="button" onclick="document.getElementById('image-input').click();">Ajouter
                une image</button>
            <h4>Il faut être connecté pour ajouter des images sur une annonce dont vous êtes propriétaire.</h4>
            <hr>
            <!--Form Content-->

            <br>
            <div>
                <input class="buttonEffect" type="submit" value="Soumettre" />
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
