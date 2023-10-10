var selectedBrands = [];
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
            $.each(brands, function(brand,nombre) {

                if(!brand in selectedBrands)
                    selectedBrands[brand] = false;

                output += `
                <div class="row ${selectedBrands[brand] ? 'selected-element':''}" brand=${brand} >

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
            $.each(brands, function(brand,nombre) {
                $(`div[brand=${brand}]`).on("click",(ev)=>{
                    console.log(brand);
                    $(`div[brand=${brand}]`).toggleClass("selected-element");
                    selectedBrands[brand] = $(`div[brand=${brand}]`).hasClass("selected-element");
                    console.log(selectedBrands[brand]);
                });
            })
        }else{
            $('#brands-list').remove();
        }
    })
});