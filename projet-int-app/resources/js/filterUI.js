var selectedBrands = new Set();
var selectedBodyType = [];
var selectedTransmission = [];
var selectedPrice = null;
var selectedMileage = null;

$(() => {
    $("#page_filtre").show();
    $("#content").hide();
    $("#xheader").hide();

    // The Boutons filter and order
    $("#filters").on("click", function (event) {
        console.log("click on filters");
        $("#content").hide();
        $("#xheader").hide();
        $("#page_filtre").show();
    })
    $("#close_page_filters").on("click", function (event) {
        $("#content").show();
        $("#xheader").show();
        $("#page_filtre").hide();
    })
    $("#order").on("click", function (event) {
        console.log("click on order")
    })
    // Each filter and it's options/UI
    $("#label-marque").on("click", function (ev) {
        let isDisplayed = $('#brands-list').length;
        console.log(isDisplayed);
        if (!isDisplayed) {
            // Do ajax call to get all makes of cars in DB
            let brands;
            $.ajax({
                url: '/api/publications/brands',
                async: false,
                success: function (data) {
                    brands = data;
                    console.log(data);
                },
                error: (xhr) => { console.log(xhr); }
            });

            // format to html
            let output = `<span id=brands-list>
            <div class="row" style="min-height: 20px;"></div>`;
            $.each(brands, function (brand, nombre) {

                // if (!brand in selectedBrands)
                //     selectedBrands.push({ brand: false });

                output += `
                <div class="row ${selectedBrands[brand] ? 'selected-element' : ''}" brand=${brand} >

                    <div class='col-2 text-center p-0' style='color:black;'>
                        <span class="car-${brand.toLowerCase()} fa-2x"></span>
                    </div>
                    <div class='col-9 text-start d-flex align-items-center'>
                        <span class="w-75" style="font-size: 22px">${brand}</span>
                    </div>
                    <div class='col-1 p-1'>
                        <span style="font-size: 20px">${nombre}</span>
                    </div>
                
                </div>`;


            });
            output += `</span>`;
            // Show them
            $("#label-marque").after(
                output
            );
            // Setting up listeners for selection of filter    
            $.each(brands, function (brand, nombre) {
                $(`div[brand=${brand}]`).on("click", (ev) => {
                    console.log(brand);
                    $(`div[brand=${brand}]`).toggleClass("selected-element");
                    if ($(`div[brand=${brand}]`).hasClass("selected-element")) {
                        selectedBrands.add(brand);
                    } else {
                        selectedBrands.delete(brand);
                    }
                    selectedBrands[brand] = $(`div[brand=${brand}]`).hasClass("selected-element");
                    console.log(selectedBrands[brand]);
                });
            })
        } else {
            $('#brands-list').remove();
        }
    })
    $("#label-body").on("click", function (ev) {
        let isDisplayed = $('#body-list').length;
        console.log(isDisplayed);
        if (!isDisplayed) {
            // Do ajax call to get all makes of cars in DB
            let bodies;
            $.ajax({
                url: '/api/publications/bodies',
                async: false,
                success: function (data) {
                    bodies = data;
                    console.log(data);
                },
                error: (xhr) => { console.log(xhr); }
            });

            // format to html
            let output = `<span id=body-list>
            <div class="row" style="min-height: 20px;"></div>`;
            $.each(bodies, function (body, nombre) {


                output += `
                <div class="row ${selectedBodyType[body] ? 'selected-element' : ''}" brand=${body} >

                    <div class='col-2 text-center p-0' style='color:black;'>
                        <span class="car-${body.toLowerCase()} fa-2x"></span>
                    </div>
                    <div class='col-9 text-start d-flex align-items-center'>
                        <span class="w-75" style="font-size: 22px">${CapitalizeFirstCase(body)}</span>
                    </div>
                    <div class='col-1 p-1'>
                        <span style="font-size: 20px">${nombre}</span>
                    </div>
                
                </div>`;


            });
            output += `</span>`;
            // Show them
            $("#label-body").after(
                output
            );
            // Setting up listeners for selection of filter    
            $.each(bodies, function (body, nombre) {
                $(`div[brand=${body}]`).on("click", (ev) => {
                    console.log(body);
                    $(`div[brand=${body}]`).toggleClass("selected-element");
                    if ($(`div[brand=${body}]`).hasClass("selected-element")) {
                        selectedBodyType.add(body);
                    } else {
                        selectedBodyType.delete(body);
                    }
                    selectedBodyType[body] = $(`div[brand=${body}]`).hasClass("selected-element");
                    console.log(selectedBodyType[body]);
                });
            })
        } else {
            $('#body-list').remove();
        }
    })
    //Submit the search
    $("#btn-search").on("click", (e) => {
        HideMenuAfterSearch();
        console.log("lenth", selectedBrands.size)
        if (selectedBrands.size > 0) {
            $.ajax({
                url: `publications/search?brand=${formatArrayToUrl(selectedBrands)}`,
                async: false,
                dataType: 'html',
                success: function (data) {
                    //console.log(data);
                    let html = $(data).html();
                    let content = $(data).find("#content").find("#content");
                    console.log(data);
                    $("#content").html(data);
                },
                error: (xhr) => { console.log(xhr); }
            });
        }
        else {
            noFilterRequest();
        }
    });
    $("#label-reset").on("click", function (event) {
        resetFilters();
    })
    function formatArrayToUrl(array) {
        let tab = [];
        array.forEach(brand => {
            tab.push(brand);
        });
        console.log(tab.toString());

        return tab;
    }
    function noFilterRequest() {
        $.ajax({
            url: `publications/search?`,
            async: false,
            dataType: 'html',
            success: function (data) {
                $("#content").html(data);
            },
            error: (xhr) => { console.log(xhr); }
        });
    }
    function resetFilters() {
        selectedBrands = new Set();
        selectedBodyType = [];
        selectedTransmission = [];
        selectedPrice = null;
        selectedMileage = null;
        $(".selected-element").removeClass("selected-element");
    }
    function HideMenuAfterSearch() {
        $("#page_filtre").hide();
        $("#content").show();
        $("#xheader").show();
    }
    function CapitalizeFirstCase(str){
        return str[0].toUpperCase() + str.slice(1).toLowerCase();
    }
});