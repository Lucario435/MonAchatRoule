<div class="page-on-top container-fluid w-100 h-auto scroll" id="page_filtre">
    <div class="grid text-start row-gap-5">
        
        <div class="row pt-4 user-select-none">
            <label class="row w-100 p-0 m-0">
                <div class="col-5">
                    <div class="row" style="width:200px;">

                        <div class="col-8">
                            <label role="button"  id="label-reset">
                                <span>
                                    <span class="fas fa-trash" id="text-reset-filter" class="w-75 p-0"></span>
                                    <span id=number-filter>(0)</span>
                                </span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="col-5"></div>
                <div class="col-2 d-flex align-items-center justify-content-end fas fa-times h-15"
                    id="close_page_filters"></div>
            </label>
        </div>
        <div class="pt-4 d-flex gap-2 ">
            
            <div class="align-items-center" style="width:fit-content">
                <input  name="title-search" id="title-search" type="text" placeholder="titre de l'annonce" style="width:190px;">
            </div>
            <div role="button"  id="search-by-title" class="fas fa-search d-flex align-items-center justify-content-start mx-1" style="font-size: 19px;"></div>
        </div>
        <div class="row pb-3 user-select-none">
        </div>
        <div class="row pb-3 user-select-none">

            <label role="button"  class="col-4" for="followedPublications" style="width: 140px">
                Annonces suivis
            </label>
            <div  class="col-1 d-flex align-items-center">
                <input role="button"  type="checkbox" id="followedPublications">
            </div>
            <div class="col-7"></div>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-brand" class="row w-100 p-0 m-0">
                <div class="col-8 ">
                    Marques
                </div>
                <div class="col-2"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-body" class="row w-100 p-0 m-0">
                <div class="col-8">
                    Type de carroserie
                </div>
                <div class="col-2"></div>
                <div
                    class="col-2 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-transmission" class="row w-100 p-0 m-0">
                <div class="col-8">
                    Transmission
                </div>
                <div class="col-2"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-fuelType" class="row w-100 p-0 m-0">
                <div class="col-8">
                    Type de carburant
                </div>
                <div class="col-2"></div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-year" class="row w-100 p-0 m-0">
                <div class="col-3">
                    Année
                </div>
                <div id="amount-year" class="col-7 d-flex align-items-end justify-content-end">
                    
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-price" class="row w-100 p-0 m-0">
                <div class="col-3">
                    Prix
                </div>
                <div id="amount-price" class="col-7 d-flex align-items-end justify-content-end">
                    
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <label role="button"  id="label-kilometer" class="row w-100 p-0 m-0">
                <div class="col-3">
                    Kilométrage
                </div>
                <div id="amount-kilometer" class="col-7 d-flex align-items-end justify-content-end ">
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </label>
        </div>
        <div class="row pb-3 user-select-none">
            <div role="button"  id="label-trier" class="row w-100 p-0 m-0">
                <div class="col-8">
                    Trier par
                </div>
                <div class="col-2 d-flex align-items-end justify-content-end ">
                </div>
                <div
                    class="col-1 d-flex align-items-center justify-content-center fas fa-caret-down flex-grow-1 ms-auto">
                </div>
            </div>
            <span id="orderby-list" class="hidden mt-2">

            </span>
        </div>
        <div class="row" style="min-height:200px;"></div>
        <div role="button"  class="row text-center user-select-none fixed-bottom" id="btn-search" style="background-color: green">

            <div class="col-8 d-flex align-items-center justify-content-end">Voir les résultats</div>
            <div class="col-4 fas fa-search px-3 d-flex align-items-center justify-content-start"></div>

        </div>
    </div>
</div>

<div id="myMap" style="display:none;"></div>
