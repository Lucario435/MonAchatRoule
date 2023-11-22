@extends('partials.xlayout')

@php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use App\Models\User;
    // $addedCssProfilDiv = "float: left;"
@endphp


@section('title')
<h1 id="xtitle">Profil de {{$user->getDisplayName()}}</h1>
@endsection

@section('content')
    <div class="userp mt-5">
    @include('partials.profilDiv')
    <br><br>
    <div style="width: 100%;">
        @include('publications.carte')

    </div>
</div>
@include('partials.xfooter')
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
    width: 90%;
    margin: auto;
}

/* Media query for mobile devices */
@media (orientation:portrait) {
    .userp {
        flex-direction: column;
    }
}
</style>
