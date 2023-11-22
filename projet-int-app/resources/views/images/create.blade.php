@extends('partials.xlayout')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('title', "Gestion d'images")
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
                <form class="form-style" method="post" action="{{ route('image.store', ['publication_id' => $pid]) }}"
                    enctype="multipart/form-data">
                    {{-- <input type="hidden" name="publication_id" value="{{ isset($pid) ? $pid : '' }}"> --}}
                @else
                    <form class="form-style" method="post" action="{{ route('image.store', ['publication_id' => $pid]) }}"
                        enctype="multipart/form-data">
            @endif


            <br>


            <!--For Security-->
            @csrf
            @method('post')
            <!--////////////-->

            <!--Form Content-->
            <!--Gets all the owner's publication so he can link the uploaded images to the publication's id-->


            <div class="image-container" style="row-gap: 20px;display:block;">
                @if (isset($ilist))
                    <div class="text-wrap">
                        <h2>Retirer des images de votre annonce</h2>
                    </div>
                    <span class="image-container" id="old-images" style="gap:1em;">
                        @foreach (@$ilist as $i)
                            <div class="image-preview">
                                <img class="image-css" src="{{ asset($i->url) }}" alt="">

                                <span id="{{ $i->id }}" class="remove-image image-from-db"
                                    style="color:red;font-weight:bolder;">X</span>

                            </div>
                        @endforeach
                    </span>
                @endif

                <hr class="my-3">
                
                <div class="text-wrap">
                    <h2>Ajoutez des images à votre annonce</h2>
                </div>
                <span id="upload-input-container" style="margin:auto;width:fit-content">
                    <input type="file" id="image-input" name="images[]" accept="image/*" multiple onclick="addInput(this)"
                    onchange="handleImageUpload(this)"
                    style="margin:10px 0px 10px 0px; opacity:0;position:relative;z-index:-1;display:none;">
                    <label id="label-image-input" class="buttonEffect p-1" for="image-input">Téléverser</label>
                </span>
                <span class="image-container mt-3" id="new-images" style="gap:1em;"></span>
                <!-- Les images uploadées seront affichées ici -->
            </div>
            {{-- <button class="buttonEffect" type="button" id="seeFilesName" onclick="myf()">See files</button> --}}
            <div id="displayFileNames"></div>

            {{-- <br>{{ Auth::user()->publications }} --}}
            

            {{-- <button class="buttonEffect" type="button" onclick="document.getElementById('image-input').click();">Téléverser
                des images</button> --}}

            <br>
            <hr>

            <!--Form Content-->

            <br>
            <div class="d-flex gap-2" style="margin:auto;width:fit-content;">
                <a href="{{ route('publication.detail', ['id' => $pid]) }}"><button type="button"
                        class="buttonEffect">Annuler</button></a>
                <input class="buttonEffect" type="submit" value="Soumettre" />
            </div>
            <br>
            </form>
            <div>
                <script>
                    $(() => {
                        $(".image-from-db").on("click", (e) => {
                            //console.log($(e.target).parent());
                            $.ajax({
                                url: `/image/delete/${e.target.id}`,
                                async: true,
                                success: function(data) {
                                    //console.log($(e.target).parent()[0]);
                                    $(e.target).parent().remove();
                                },
                                error: (xhr) => {
                                    console.log(xhr);
                                }
                            });
                        })
                    });

                    //Source : https://codepen.io/mrtokachh/pen/LYGvPBj and chat gpt
                    const imageContainer = document.getElementById('new-images');

                    var imageInput = document.getElementById('image-input');

                    //imageInput.addEventListener('change', handleImageUpload);



                    function addInput(obj) {
                        console.log(obj);
                        $(obj).hide();
                        $(obj).removeAttr("id");
                        let newInput =
                            `<input type="file" id="image-input" name="images[]" accept="image/*" multiple onclick=addInput(this) onchange=handleImageUpload(this) style="margin:10px 0px 10px 0px; opacity:0;position:relative;z-index:-1; display:none;">`;
                        $("#upload-input-container").append(newInput);
                        //$("#label-image-input").remove();
                        // let newLabel = `<label id="label-image-input" class="buttonEffect p-1" for="image-input">Téléverser des images</label>`;
                        // $("#upload-input-container").append(newLabel);
                        //$(newInput).on("change",handleImageUpload(this));
                        //imageInput = newInput;
                    }

                    function myf() {
                        $('#displayFileNames').html('');
                        let array = $("input[type=file]");
                        console.log(array);
                        for (let i = 0; i < array.length; i++) {
                            let files = array[i].files;
                            console.log("files.length > 0 => ", files.length > 0);
                            for (let j = 0; j < array.length && files.length > 0; j++) {
                                //console.log(files);
                                if (files[j] != undefined)
                                    $('#displayFileNames').append(files[j].name + '<br>');
                            }
                        }
                    }

                    function handleImageUpload(obj) {
                        console.log(obj.files);
                        const files = obj.files;
                        console.log(`ligne 155 : ${obj.files}`)
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
                                removeButton.setAttribute('linked-image', file.name);
                                // obj.setAttribute("linked-image",file.name);
                                removeButton.addEventListener('click', () => {
                                    imageContainer.removeChild(imagePreview);
                                    // If is multi image upload
                                    console.log(obj.files);
                                    
                                    removeFileFromFileList(file.name, obj);
                                    console.log(obj.files);
                                });

                                imagePreview.appendChild(img);
                                imagePreview.appendChild(removeButton);
                                imageContainer.appendChild(imagePreview);
                            }
                        }

                        $(obj).off('change', handleImageUpload);

                    }

                    function removeFileFromFileList(fileName, inputToModify) {
                        //https://stackoverflow.com/a/64019766
                        const dt = new DataTransfer()
                        const input = inputToModify;
                        const {
                            files
                        } = input
                        console.log(`file name: ${fileName} `);
                        for (let i = 0; i < files.length; i++) {
                            console.log(`name to delete: ${fileName} , current index : ${files[i].name}`);
                            const file = files[i]
                            if (fileName !== files[i].name)
                                dt.items.add(file) // here you exclude the file. thus removing it.
                        }

                        input.files = dt.files // Assign the updates list
                    }

                    //Chat gpt
                </script>
            @endsection
