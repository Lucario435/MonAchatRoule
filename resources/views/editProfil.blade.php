@extends('partials.xlayout')
@push('js')
    <script type="text/javascript" src="{{ URL::asset ('js/validation.js') }}"></script>
@endpush
@section('title')
    <div id="xtitle">
        Modifier votre profil
    </div>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    required>
            </div>
            <div class="form-group">
                <label for="surname">Prénom:</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $user->surname) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" class="Email" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Téléphone:</label>
                <input type="phone" class="Phone form-control" id="phone" name="phone"
                    value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-group formImage">
                <label for="userimage">Image de profil:</label>
                <input type="file" class="form-control" id="userimage" name="userimage">
                <br>
                <img title="Votre image actuelle" src="{{ $user->getImage() }}" id="image-preview" style="display: none; height: 5rem;">
            </div>
            <script defer>
                $(document).ready(function () {
                    // Function to read and preview the image
                    if($("#image-preview").attr("src") != ""){
                        $("#image-preview").show();
                        // console.log("yes");
                    }
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function (e) {
                                $('#image-preview').attr('src', e.target.result).show();
                            };

                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    // Trigger the readURL function when a file is selected
                    $("#userimage").change(function () {
                        readURL(this);
                    });
                });
            </script>
            <br>
            <div class="form-group">
                {{-- <label for="email_notification">Recevoir des notifications par email</label> --}}
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="email_notification" name="email_notification" value="1" @if($user->email_notification) checked @endif>
                    <label class="form-check-label" for="email_notification">
                        Activer les notifications par email
                    </label>
                </div>
            </div>
            <br>

            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route("userProfile",["id" => $user->id]) }}"><button type="button" class="btn btn-secondary">Annuler</button></a>
        </form>
    </div>

    <style>
        .form-group {
            margin-bottom: .5rem;
        }
        .formImage{
            /* box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px; */
            border-radius: .5rem;
            border: 1px solid #ced4da; /* Border color used in Bootstrap */
            padding: 1rem .5rem;
        }
        #image-preview{
            /* border-radius: 100%; */
        }
    </style>
 @push('js')
 @vite(['resources/js/notification_checkbox_to_bool.js'])
 @vite(['resources/js/show_hide_password.js'])
 {{-- @vite(['resources/js/phone_number_formatter.js']) --}}
 @vite(['resources/js/validation.js'])
@endpush
@endsection
