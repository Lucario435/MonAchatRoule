@extends('partials.xlayout')

@push('css')
    <link rel="stylesheet" href="{{ URL::asset('css/publication.css') }}">
@endpush
@push('js')
    <script type='text/javascript'
        src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AtND6We4q6ydLy0dVPwZ1NGD__tCGQzhVSIhMA4EQnSTMVgtOg9TwWhOYzYvVzVC'
        async defer>
    </script>
@endpush
<div style="padding-bottom:7em; min-height:100%" >
@section('content')

    @include('filters.menu')
    <div class="container-fluid">
            <div class="col-4" id="filters-wrapper">
                @include('filters.filterPage')
            </div>
            <div class="col content">
                <span id="content">
                    @include('publications.carte')
                </span>
            </div>
    </div>
</div>
@include('partials.xfooter')
@endsection
