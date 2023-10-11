@extends('partials.xlayout')

@push('css')
    @vite(['resources/css/publication.css'])
@endpush
@push('js')
    @vite(['resources/js/filterUI.js'])
@endpush
@section('content')
    {{-- prix marque kilometre couleur tranmission corps  --}}
    <div class="page-on-top container-fluid w-100 h-100" id="page_filtre" style="display: block">
        <div class="grid text-start row-gap-5 ">
            <div class="row pt-4 px-2">
                <label id="close_page_filters" class="p-0">
                    <span>
                        <span class="fas fa-filter fa-lg w-20 p-0"></span>
                        <span class="w-75 p-0" style="font-size: 22px">Filtres</span>
                        <span class="fas fa-times h-15 float-end py-2 pe-2"></span>
                    </span>
                </label>
            </div>
            <div class="row" style="min-height: 60px;"></div>
            <div class="row pb-3">
                <label id="label-reset">
                    <span>
                        <span id="text-reset-filter" class="w-75 p-0" style="font-size: 18px">Réinitialiser les
                            filtres</span>
                        <span id=number-filter>(0)</span>
                        {{-- <span class="fas fa-caret-down w-5 float-end pe-1"></span> --}}
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label id="label-brand">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Marques</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label id="label-body">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Carroserie</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label id="label-transmission">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Transmission</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label id="label-price">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Prix</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                        
                    </span>
                </label>
            </div>
            <div class="row pb-3">
                <label id="label-kilometer">
                    <span>
                        <span class="w-75 p-0" style="font-size: 22px">Kilométrage</span>
                        <span class="fas fa-caret-down w-5 float-end pe-1"></span>
                    </span>
                </label>
            </div>
            <div class="row text-center fixed-bottom mb-2" id="btn-search">
                <span style="background-color: green">
                    <span style="font-size: 30px">Rechercher</span>
                    <span class="fas fa-search fa-2x px-3"></span>
                </span>
            </div>
        </div>
    </div>

    {{-- Fin filtres --}}

    <div class="container-fluid w-100 text-center" style="height: 100px">
        <div class="row">
            <div class="col">
                <div class="row border">
                    <label for="filters" class="p-3 filter" id="filters">
                        <span id="filters">
                            <span class="fas fa-filter fa-lg w-20 p-0"></span>
                            <span class="w-75 p-0" style="font-size: 22px">Filtrer</span>
                            <span class="fas fa-caret-down w-5"></span>
                        </span>
                    </label>
                </div>
            </div>
            <div class="col ">
                <div class="row border">
                    <label for="order" class="p-3 filter">
                        <span id="order">
                            <span class="fas fa-sort-amount-up-alt fa-lg w-20 px-0"></span>
                            <span class="w-75 p-1" style="font-size: 22px">Trier</span>
                            <span class="fas fa-caret-down fa-1x"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <span id="content">
        @include('publications.carte')
    </span>
@endsection
