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
@section('content')
<br>
<a style="margin: 1em;" href="{{ route("publication.index") }}"><button type="button" class="btn btn-secondary">Retour</button></a>
<br>
<div style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;padding-top:1em;padding-bottom:1em;margin:1em;">
    <div class="comparator-container2">
        <!--Title 1-->
            <div class="comparator-case shadow-display">
                <label class="detail-info-text">
                    @if(isset($car1))
                        {{$car1->title}}
                    @else
                        {{$default}}
                    @endif
                </label>
            </div>
        <!--Title 2-->        
            <div class="comparator-case shadow-display">
                <label class="detail-info-text">
                @if(isset($car2))
                    {{$car2->title}}
                @else 
                    {{$default}}
                @endif</label>
            </div>
    </div>
    <div class="comparator-container">
        <!--Price-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Prix</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->fixedPrice}} $
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->fixedPrice}} $
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Fabricant-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Fabricant</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->brand}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->brand}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Kilométrage-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Kilométrage</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->kilometer}} km
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->kilometer}} km
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Transmission-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Transmission</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->transmission}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->transmission}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Carosserie-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Carosserie</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->bodyType}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->bodyType}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Couleur-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Couleur</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->color}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->color}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Année-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Année</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->year}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->year}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--Essence-->        
        <div class="comparator-case shadow-display">

            <div class="comparator-case">
                <label class="detail-info-text">Type d'Essence</label>
                <div class="comparator-row">
                    <div class="comparator-case">
                        @if(isset($car1))
                            {{$car1->fuelType}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                    <div class="comparator-case">
                        @if(isset($car2))
                            {{$car2->fuelType}}
                        @else
                            {{$default}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.xfooter')
@endsection
