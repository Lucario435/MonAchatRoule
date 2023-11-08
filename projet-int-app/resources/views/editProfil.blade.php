@extends('partials.xlayout')

@section('title', 'Modifier votre profil')

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
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Téléphone:</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-group">
                <label for="userimage">Image de profil:</label>
                <input type="file" class="form-control" id="userimage" name="userimage">
            </div>
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
    </style>
@endsection
