@extends('partials.xlayout')

@php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use App\Models\User;
    // $addedCssProfilDiv = "float: left;"
@endphp

@section('title', "Profil de ".$user->getDisplayName())

@section('content')
    <div class="userp">
        @include("partials.profilDiv")
        <div style="width: 100%; height: 5rem; background-color: red;"> Example de div avec les annonces</div>
    </div>
@endsection

<style>
/* .userp{
        display: grid;
        grid-template-columns: auto auto;
    }
    @media (max-width: 768px) {
    .userp{
        display: grid;
        grid-template-columns: auto;
        grid-template-rows: auto auto;
    }
} */
.userp {
    display: flex;
    width: 90%; margin: auto;
}

/* Media query for mobile devices */
@media (max-width: 768px) {
    .userp {
        flex-direction: column;
    }
}
</style>
