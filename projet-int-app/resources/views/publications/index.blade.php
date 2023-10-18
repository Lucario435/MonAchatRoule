@extends('partials.xlayout')

@push('css')
    @vite(['resources/css/publication.css'])
@endpush
@push('js')
    @vite(['resources/js/filterUI.js'])
    <script type='text/javascript'
        src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC'
        async defer></script>
@endpush
@section('content')
    @include('filters.menu')
    @include('filters.filterPage')

    <span id="content">
        @include('publications.carte')
    </span>
@endsection
