<div class="page-on-top container-fluid w-100 h-auto" id="page_filtre" style="display: block;min-height:100%; background-color:var(--blueheader);color:white;">
    <div class="grid text-start row-gap-5 ">
        <div class="row pt-4 ">
            <label class="row w-100 p-0 m-0">

                {{-- <span class="w-75 p-0" style="font-size: 22px">Filtres</span> --}}
                <div class="col-5" style="font-size: 22px">
                    <div class="row" style="width:200px;">
                        <div class="col-4">
                            Filtres
                        </div>
                        <div class="col-8">
                            <label id="label-reset">
                                <span>
                                    <span class="fas fa-trash" id="text-reset-filter" class="w-75 p-0"
                                        style="font-size: 20px"></span>
                                    <span id=number-filter>(0)</span>
                                </span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="col-5"></div>
                <div class="col-2 d-flex align-items-center justify-content-end fas fa-times h-15" id="close_page_filters"></div>
            </label>
        </div>
        <div class="row pb-3">
        </div>
        <div class="row pb-3">
            <label id="label-brand" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Marques
                </div>
                <div class="col-6"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3">
            <label id="label-body" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Carroserie
                </div>
                <div class="col-6"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3">
            <label id="label-transmission" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Transmission
                </div>
                <div class="col-6"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3">
            <label id="label-price" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Prix
                </div>
                <div id="amount-price" class="col-6 d-flex align-items-end justify-content-end flex-fill">
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3">
            <label id="label-kilometer" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Kilométrage
                </div>
                <div id="amount-kilometer" class="col-6 d-flex align-items-end justify-content-end flex-fill">
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3">
            <label id="label-trier" class="row w-100 p-0 m-0">
                <div class="col-5 " style="font-size: 22px">
                    Trier par
                </div>
                <div class="col-6 d-flex align-items-end justify-content-end flex-fill">
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
                <span id="orderby-list">
                    {{-- <div class="row" style="min-height: 20px;"></div> --}}
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="orderPrice" type="radio" id="ascPrice"><label for="ascPrice">Prix ascendant</label>
                        </div>
                    </div>
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="orderPrice" type="radio" id="descPrice"><label for="descPrice">Prix descendant</label>
                        </div>
                    </div>
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="orderMileage" type="radio"  id="ascKilo"><label for="ascKilo">Kilométrage ascendant</label>
                        </div>
                    </div>
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="orderMileage" type="radio"  id="descKilo"><label for="descKilo">Kilométrage descendant</label>
                        </div>
                    </div>
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="distance" type="radio" id="nearZone"><label for="nearZone">Les plus proches</label>
                        </div>
                    </div>
                    <div class="row orderby-element">
                        <div class="col-2"> </div>
                        <div class="col-9 text-start d-flex align-items-center">
                            <input name="distance" type="radio" id="farZone"><label for="farZone">Les plus loins</label>
                        </div>
                    </div>
                </span>
        </div>
        <div class="row" style="min-height:100px;"></div>
        <div class="row text-center fixed-bottom" id="btn-search" style="background-color: green">
            <span>
                <span style="font-size: 30px">Rechercher</span>
                <span class="fas fa-search fa-2x px-3"></span>
            </span>
        </div>
    </div>
</div>

<div id="myMap" style="display:none;"></div>