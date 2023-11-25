@extends('partials.xlayout')


@section('title', "Définir un acheteur")
@section("content")
<div class="container" style="max-width: 40rem !important">
<form method="post" action="{{ route('messages.markAsBuyerPost') }}">
    @csrf
    <div class="form-group">
        <div style="display: grid; grid-template-columns: 2rem auto; gap: 1rem; grid-template-rows: auto;">
            <img src="{{ $targetUser->getImage() }}" style="width:2rem;height:2rem; border-radius:100%;" alt="">
           {{ $targetUser->getDisplayName() }}
        </div> <br>
        <label for="pidVendu">Laquelle de vos annonces a été acheté par cet acheteur? <span style="color: red;">*</span> </label>
        <select class="form-control" id="pidVendu" name="pidVendu"
        {{-- @if (request("usertarget") != null)
            disabled style="cursor:not-allowed;"
        @endif> --}}
        required >
        {{-- <option value="-1">Aucun</option> --}}
            @foreach($publications as $p)
                <option value="{{ $p->id }}">{{ $p->title }}</option>
            @endforeach
        </select>
    </div>
    <br>
    <input type="hidden" value="{{ $targetUser->id }}" name="uid">
    {{-- <input type="hidden" name="hideText" value="{{ request("hideText") }}"> --}}
    <button type="submit" class="btn btn-primary">Soumettre</button>
    <a href="{{ route("messages") }}"><button type="button" class="btn btn-secondary">Retour</button></a>

</form>
</div>
@endsection
