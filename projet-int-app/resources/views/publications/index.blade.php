@extends('partials.xlayout')

@push('css')
    @vite(['resources/css/publication.css'])
@endpush
@push('js')
    @vite(['resources/js/filterUI.js'])
@endpush
@section('content')

    @include("filters.menu")
    @include("filters.filterPage")
    @include("filters.orderbyPage")

    <span id="content">
        @include('publications.carte')
    </span>
@endsection
