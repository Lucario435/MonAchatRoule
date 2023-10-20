import {askUserLocation,getDistanceByTransportMethod} from './location';

let filterObject = {
    selectedBrands: new Set(),
    selectedBodyType: new Set(),
    selectedTransmissions: new Set(),
    numberSelectedFilters: 0,
    selectedMinPrice: null,
    selectedMaxPrice: null,
    selectedMinMileage: null,
    selectedMaxMileage: null,
    errorMaxMilage: null,
    errorMaxPrice: null,
    orderPrice:null,
    orderMileage:null,
    distance:null,

}

const removeAccents = str =>
    str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

$(() => {
    $("#page_filtre").hide();
    // $("#content").show();
    // $("#xheader").show();
    //$("#span-price").hide();

    // The Boutons filter and order

    $("#filters").on("click", function (event) {
        console.log("click on filters");
        $("#content").hide();
        $("#xheader").hide();
        $("#footer").hide();
        $("#xtitle").hide();
        $("#menu").hide();
        $("#page_filtre").show();
    })
    $("#close_page_filters").on("click", function (event) {
        $("#content").show();
        $("#xheader").show();
        $(".footer").show();
        $("#xtitle").show();
        $("#menu").show();
        $("#page_filtre").hide();

    })
    $("#order").on("click", function (event) {
        console.log("click on order")
    })

    // Each filter and it's options/UI
    $("#label-price").on("click", function (event) {
        let span = $(`#span-price`);
        if (!span.length) {
            $("#label-price").after(
                `
                    <span id="span-price"  class="w-75 mx-auto mt-4">
                        <span id="amount-price"></span>
                        <div id="slider-range-price"></div>
                    </span>
                `
            );
            let maxPrice = getHighestPriceItemFromServer();
            //console.log(typeof (maxPrice));
            createSlider("price",0,maxPrice,"#amount-price","selectedMinPrice","selectedMaxPrice",' $');

            if (filterObject.errorMaxPrice) {
                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);
            }

            $("#min_price").on("input", function (ev) {

                if (filterObject.selectedMinPrice == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMinPrice = parseInt($("#min_price").val());

                console.log(filterObject.selectedMinPrice);
                if ($("#min_price").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMinPrice = null;
                }
                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                console.log("min price changed " + filterObject.selectedMinPrice);
            })
            $("#max_price").on("input", function (ev) {
                if (filterObject.selectedMaxPrice == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMaxPrice = parseInt($("#max_price").val());

                if ($("#max_price").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMaxPrice = null;
                }

                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                console.log("max kilometer changed " + filterObject.selectedMaxPrice);
            })
        }
        else if($(span).is(":hidden")){
            $("#span-price").show();
        } 
        else {
            $("#span-price").hide();
        }

    });

    $("#label-kilometer").on("click", function (event) {
        let span = $(`#span-kilometer`);
        if (!span.length) {
            $("#label-kilometer").after(
                `
                <span id="span-kilometer" class="w-75 mx-auto mt-4">
                    <span id="amount-kilometer"></span>
                    <div id="slider-range-kilometer"></div>
                </span>
                `
            );

            let maxKilometer = getHighestKilometerItemFromServer();
            //console.log(typeof (maxKilometer));
            createSlider("kilometer",0,maxKilometer,"#amount-kilometer","selectedMinMileage","selectedMaxMileage"," kms")

            $("#min_kilometer").on("input", function (ev) {

                if (filterObject.selectedMinMileage == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMinMileage = parseInt($("#min_kilometer").val());

                console.log(filterObject.selectedMinMileage);
                if ($("#min_kilometer").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMinMileage = null;
                }
                setErrorMaxInput("kilometer", $("#max_kilometer").val(), filterObject.selectedMinMileage);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                console.log("min kilometer changed " + filterObject.selectedMinMileage);
            })
            $("#max_kilometer").on("input", function (ev) {

                if (filterObject.selectedMaxMileage == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMaxMileage = parseInt($("#max_kilometer").val());

                if ($("#max_kilometer").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMaxMileage = null;
                }

                setErrorMaxInput("kilometer", $("#max_kilometer").val(), filterObject.selectedMinMileage);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                console.log("max kilometer changed " + filterObject.selectedMaxMileage);
            })

            if (filterObject.errorMaxMilage) {
                setErrorMaxInput('kilometer', parseInt($("#max_kilometer").val()), filterObject.selectedMinMileage);
            }

        }else if($(span).is(":hidden")) {
            $("#span-kilometer").show();
        }
        else {
            $("#span-kilometer").hide();
        }

    });

    // Submit the search
    $("#btn-search").on("click", (e) => {

        console.log($(".erreur").length);
        if ($(".erreur").length > 0) {
            console.log("Il ya des erreurs");
        }
        else {
            setBackgroundColor("#btn-search", "green");
            HideMenuAfterSearch();
            $.ajax({
                url: searchUrlBuilder('publications/search?'),
                async: false,
                dataType: 'html',
                success: function (data) {
                    $("#content").html(data);
                },
                error: (xhr) => { console.log(xhr); }
            });
            ShowNumberOfActiveFilters("#active_filters_main", filterObject.numberSelectedFilters)
        }

    });
    // Reset filters
    $("#label-reset").on("click", function (event) {
        resetFilters();
    });
    
    $(".orderby-element > div > input").on("change", function (element) {
        console.log(element.currentTarget.id);
        console.log(element.currentTarget.value);
        filterObject[element.currentTarget.name] = element.currentTarget.id;
        console.log(filterObject);
        if(element.currentTarget.name == "orderMileage"){
            let coordinateUser = askUserLocation();
            //getDistanceByTransportMethod(coordinateUser,);
        }
    });

    listFilterDataFromServer("brand", "brands", "selectedBrands");
    
    listFilterDataFromServer("body", "bodies", "selectedBodyType");
    
    listFilterDataFromServer("transmission", "transmissions", "selectedTransmissions");

    



    function setErrorMaxInput(filter, max_input, min_input, selectedElement, selectedErrorElement) {
        let maxValue = parseInt(max_input);
        if (maxValue < min_input) {
            $(`#val-max-${filter}-error`).remove();
            $(`#span-${filter}`).append(`<div id=val-max-${filter}-error class='erreur text-center mt-2'>
            La valeur maximum doit être plus grande que la valeur minimum</div>`);
            filterObject[selectedElement] = maxValue;
            filterObject[selectedErrorElement] = true;
            setBackgroundColor("#btn-search", "red");

        } else if (maxValue >= min_input) {
            $(`#val-max-${filter}-error`).remove();
            setBackgroundColor("#btn-search", "green");
            filterObject[selectedElement] = maxValue;
            filterObject[selectedErrorElement] = null;
            //console.log("max kilo changed " + filterObject.selectedMaxMileage);
        }
    }
    function createSlider(fitler,minVal=0,maxVal,htmlElement,selectedElementMin, selectedElementMax,sign = ''){
        $(`#slider-range-${fitler}`).slider({
            range: true,
            min: minVal,
            max: maxVal,
            values: [0, maxVal],
            slide: function (event, ui) {
                $(`${htmlElement}`).html(ui.values[0] + sign + " - " + ui.values[1] + `${sign} `);
                if(filterObject[selectedElementMax] == null && filterObject[selectedElementMin] == null){
                    filterObject.numberSelectedFilters++;
                    ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                }
                filterObject[selectedElementMax] = ui.values[1];
                filterObject[selectedElementMin] = ui.values[0];
            },

        });
        $(`#amount-${fitler}`).val("$" + $(`#slider-range-${fitler}`).slider("values", 0) +
            " - $" + $(`#slider-range-${fitler}`).slider("values", 1));
    }
    function setBackgroundColor(element, color) {
        if ($("#erreur").length == 0 && color == "green")
            $(element).css("background-color", color);
        else
            $(element).css("background-color", color);
    }
    function listFilterDataFromServer(filter, plural, selectedList) {
        $(`#label-${filter}`).on("click", function (ev) {
            let isDisplayed = $(`#${filter}-list`).length;
            console.log(isDisplayed);

            if (!isDisplayed) {
                // Do ajax call to get all makes of cars in DB
                let elements;
                $.ajax({
                    url: `/api/publications/${plural}`,
                    async: false,
                    success: function (data) {
                        elements = data;
                        console.log(data);
                    },
                    error: (xhr) => { console.log(xhr); }
                });

                // format to html
                let output = `
                <span id=${filter}-list>
                <div class="row" style="min-height: 20px;"></div>`;
                console.log(filterObject);
                $.each(elements, function (element, nombre) {
                    output += `
                    <div class="row ${filterObject[element] ? 'selected-element' : ''}" ${filter}=${element} >

                        ${filter == "brand" ?
                            `<div class='col-2 text-center p-0' style='color:black;'>
                                <span class="car-${element.toLowerCase()} fa-2x"></span>
                            </div>` : `<div class='col-2'> </div>`}
                        
                        <div class='col-9 text-start d-flex align-items-center'>
                            <span class="w-75" style="font-size: 22px">${CapitalizeFirstCase(element)}</span>
                        </div>
                        <div class='col-1 p-1'>
                            <span style="font-size: 20px">${nombre}</span>
                        </div>
                    
                    </div>`;


                });
                output += `</span>`;
                // Show them
                $(`#label-${filter}`).after(
                    output
                );
                // Setting up listeners for selection of filter    
                $.each(elements, function (element, nombre) {
                    $(`div[${filter}=${element}]`).on("click", (ev) => {
                        console.log(element);
                        $(`div[${filter}=${element}]`).toggleClass("selected-element");
                        if ($(`div[${filter}=${element}]`).hasClass("selected-element")) {
                            switch (selectedList) {
                                case 'selectedBrands':
                                    filterObject.selectedBrands.add(element);
                                    break;
                                case 'selectedTransmissions':
                                    filterObject.selectedTransmissions.add(element);
                                    break;
                                case 'selectedBodyType':
                                    filterObject.selectedBodyType.add(element);
                                    break;
                                case 'selectedMileage':
                                    filterObject.selectedMileage.add(element);
                                    break;
                                case 'selectedPrice':
                                    filterObject.selectedPrice.add(element);
                                    break;
                                default:
                                    break;
                            }
                            filterObject.numberSelectedFilters++;
                            ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                        } else {
                            switch (selectedList) {
                                case 'selectedBrands':
                                    filterObject.selectedBrands.delete(element);
                                    break;
                                case 'selectedTransmissions':
                                    filterObject.selectedTransmissions.delete(element);
                                    break;
                                case 'selectedBodyType':
                                    filterObject.selectedBodyType.delete(element);
                                    break;
                                case 'selectedMileage':
                                    filterObject.selectedMileage.delete(element);
                                    break;
                                case 'selectedPrice':
                                    filterObject.selectedPrice.delete(element);
                                    break;
                                default:
                                    break;
                            }
                            filterObject.numberSelectedFilters--;
                            ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                        }
                        filterObject[element] = $(`div[${filter}=${element}]`).hasClass("selected-element");
                        console.log(filterObject[element]);
                    });
                })
            } else {
                $(`#${filter}-list`).remove();
            }
        });
    }
    function searchUrlBuilder(endpointUrl) {
        let url = endpointUrl;
        if (filterObject.selectedBrands.size > 0)
            url += `brand=${formatArrayToUrl(filterObject.selectedBrands)}&`;
        if (filterObject.selectedBodyType.size > 0)
            url += `bodyType=${formatArrayToUrl(filterObject.selectedBodyType)}&`;
        if (filterObject.selectedTransmissions.size > 0)
            url += `transmission=${formatArrayToUrl(filterObject.selectedTransmissions)}&`;
        if (filterObject.selectedMinPrice != null)
            url += `minPrice=${filterObject.selectedMinPrice}&`;
        if (filterObject.selectedMaxPrice != null)
            url += `maxPrice=${filterObject.selectedMaxPrice}&`;
        if (filterObject.selectedMinMileage != null)
            url += `minMileage=${filterObject.selectedMinMileage}&`;
        if (filterObject.selectedMaxMileage != null)
            url += `maxMileage=${filterObject.selectedMaxMileage}&`;
        if(filterObject.orderMileage != null)
            url += `distance=${filterObject.orderMileage}&`;
        console.log("URL: " + url)
        return removeAccents(url);
    }
    function formatArrayToUrl(array) {
        let tab = [];
        array.forEach(element => {
            tab.push(element);
        });
        console.log("formatArrayTOUrl: " + tab.toString());

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
        filterObject = {
            selectedBrands: new Set(),
            selectedBodyType: new Set(),
            selectedTransmissions: new Set(),
            numberSelectedFilters: 0,
            selectedMinPrice: null,
            selectedMaxPrice: null,
            selectedMinMileage: null,
            selectedMaxMileage: null,
            errorMaxMilage: null,
            errorMaxPrice: null,
            orderPrice:null,
            orderMileage:null,
            distance:null,
        }
        $(".selected-element").removeClass("selected-element");
        $("#min_price").val('');
        $("#max_price").val('');
        $("#min_kilometer").val('');
        $("#max_kilometer").val('');
        $(`#val-max-price-error`).remove();
        $(`#val-max-kilometer-error`).remove();
        $('#amount-price').html(' ');
        $('#amount-kilometer').html(' ');
        $('.orderby-element > div > input').prop("checked",false);
        $(`#slider-range-price`).slider("values",[0,getHighestPriceItemFromServer()])
        $(`#slider-range-kilometer`).slider("values",[0,getHighestKilometerItemFromServer()])
        
        setBackgroundColor("#btn-search", "green");
        ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
    }
    function HideMenuAfterSearch() {
        $("#page_filtre").hide();
        $("#content").show();
        $("#xheader").show();
    }
    function CapitalizeFirstCase(str) {
        return str[0].toUpperCase() + str.slice(1).toLowerCase();
    }
    function ShowNumberOfActiveFilters(element, number) {
        $(element).html('(' + number + ')');
    }
    function getHighestPriceItemFromServer() {
        let response;
        $.ajax({
            url: '/api/publications/maxPrice',
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(parseInt(data));
                response = parseInt(data);
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
    function getHighestKilometerItemFromServer(){
        
        let response;
        $.ajax({
            url: '/api/publications/maxKilometer',
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(parseInt(data));
                response = parseInt(data);
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
});