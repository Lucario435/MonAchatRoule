import { UserLocation, getWayPointFromZipCode, getTravelDistance } from './location';

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
    orderPrice: [false, "asc"],
    orderMileage: [false, "asc"],
    orderDistance: [false, "asc"],
    orderDateAdded: [false, "asc"],

}
const MOBILE_WIDTH = 769;
const removeAccents = str =>
    str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');


$(() => {
    $(window).on("resize", function (ev) {
        const viewPortDesktopWidth = 769;
        let width = $(window).width();
        let height = $(window).height();
        console.log('resize', $(window).width(), $(window).height());
        if (viewPortDesktopWidth <= width) {
            hideFilterPage();
            showFilterPage();
            hideMenuFilter();
        }
        else{
            hideFilterPage();
            showMenuFilter();
        }
    });
    //showOnlyFilterPage();

    $("#orderby-list").html(
        createOrderByElementDiv("orderDateAdded", "Date d'ajout") +
        createOrderByElementDiv("orderPrice", "Prix") +
        createOrderByElementDiv("orderMileage", "Kilométrage") +
        createOrderByElementDiv("orderDistance", "Proximité ") +
        '<span class=row style=height:30px></span>'
    );
    $(".arrows").on("click", function (event) {
        let a = event.target;
        let key = $(event.currentTarget).attr("order");
        let orderType = filterObject[key][1] == "asc" ? "desc" : "asc";
        let checkedState = filterObject[key][0];
        //filterObject = { ...filterObject, key: [...checkedState, orderType] }
        filterObject[key][0] = checkedState;
        filterObject[key][1] = orderType;
        console.log(filterObject[key]);
        $(a).toggleClass("arrow-desc");
        $(a).toggleClass("arrow-asc");
        //console.log(a);
    });
    $(".fa-long-arrow-alt-up").on("click", function (event) {
        let selectedElement = $(event.target).parent();
        let prevElementId = jQuery($(selectedElement).prev()[0]).attr("id");

        if (prevElementId != undefined) {
            selectedElement = selectedElement.detach();
            selectedElement.hide();
            $(`#${prevElementId}`).before(
                selectedElement
            );
            selectedElement.fadeIn(200);
        }

        //console.log(selectedElement.attr("id"));


        //console.log("prev element:", prevElementId);
    });
    $(".fa-long-arrow-alt-down").on("click", function (event) {
        let selectedElement = $(event.target).parent();
        let afterElementId = jQuery($(selectedElement).next()[0]).attr("id");
        if (afterElementId != undefined) {
            selectedElement = selectedElement.detach();
            $(`#${afterElementId}`).after(
                selectedElement
            );
        }
        selectedElement.hide();
        selectedElement.fadeIn(200);
        //console.log(selectedElement.attr("id"));


        //console.log("after element:", afterElementId);
    });

    // The Boutons filter and order

    $("#filters").on("click", function (event) {
        //console.log("click on filters");
        showOnlyFilterPage();
    });

    $("#close_page_filters").on("click", function (event) {
        hideFilterPage()
    });

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
            createSlider("price", 0, maxPrice, "#amount-price", "selectedMinPrice", "selectedMaxPrice", ' $');

            if (filterObject.errorMaxPrice) {
                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);
            }

            $("#min_price").on("input", function (ev) {

                if (filterObject.selectedMinPrice == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMinPrice = parseInt($("#min_price").val());

                //console.log(filterObject.selectedMinPrice);
                if ($("#min_price").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMinPrice = null;
                }
                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                //console.log("min price changed " + filterObject.selectedMinPrice);
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
                //console.log("max kilometer changed " + filterObject.selectedMaxPrice);
            })
        }
        else if ($(span).is(":hidden")) {
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
            createSlider("kilometer", 0, maxKilometer, "#amount-kilometer", "selectedMinMileage", "selectedMaxMileage", " kms")

            $("#min_kilometer").on("input", function (ev) {

                if (filterObject.selectedMinMileage == null)
                    filterObject.numberSelectedFilters++;

                filterObject.selectedMinMileage = parseInt($("#min_kilometer").val());

                //console.log(filterObject.selectedMinMileage);
                if ($("#min_kilometer").val() == '') {
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMinMileage = null;
                }
                setErrorMaxInput("kilometer", $("#max_kilometer").val(), filterObject.selectedMinMileage);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                //console.log("min kilometer changed " + filterObject.selectedMinMileage);
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
                //console.log("max kilometer changed " + filterObject.selectedMaxMileage);
            })

            if (filterObject.errorMaxMilage) {
                setErrorMaxInput('kilometer', parseInt($("#max_kilometer").val()), filterObject.selectedMinMileage);
            }

        } else if ($(span).is(":hidden")) {
            $("#span-kilometer").show();
        }
        else {
            $("#span-kilometer").hide();
        }

    });

    $("#label-trier").on("click", function (event) {
        $("#orderby-list").toggleClass("hidden");
    });

    // Submit the search
    $("#btn-search").on("click", (e) => {

        //console.log($(".erreur").length);
        if ($(".erreur").length > 0) {
            console.log("Il ya des erreurs");
        }
        else {
            setBackgroundColor("#btn-search", "green");
            if($(window).width() < MOBILE_WIDTH)
                hideFilterPage();
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
        //console.log(element.currentTarget.name, $(element.target).is(":checked"));
        let key = element.currentTarget.name;
        let checkedState = $(element.target).is(":checked");
        let orderType = filterObject[key][1];
        //console.log(filterObject[key][1]);
        //filterObject[element.currentTarget.name] = $(element).prop("checked");
        filterObject = { ...filterObject, [key]: [checkedState, orderType] }

        if (element.currentTarget.name === "orderDistance" && checkedState) {
            // There is a problem with a div displaying above filters when asking for user location or denied user location
            const coordinateUser = UserLocation;
            console.log(coordinateUser);
            filterObject = { ...filterObject, [key]: [checkedState, orderType, coordinateUser] }
            //let codesPostales = getCodesPostalesFromServer();
            console.log(filterObject[key]);


            //let locations = getDistancesFromLocations([coordinateUser.lat, coordinateUser.long], codesPostales);
            //setCookie("locations",locations);

            //getWayPointFromZipCode('j7h1b6');
            //testGetDist();
            //getTravelDistance([45.6261632,-73.8656256],[]);
        }
    });

    listFilterDataFromServer("brand", "brands", "selectedBrands");

    listFilterDataFromServer("body", "bodies", "selectedBodyType");

    listFilterDataFromServer("transmission", "transmissions", "selectedTransmissions");
    function showMenuFilter(){
        $("#menu").show();
    }
    function hideMenuFilter(){
        $("#menu").hide();
    }
    function showFilterPage() {
        $("#page_filtre").show();
    }
    function showOnlyFilterPage() {
        $("#content").hide();
        $("#xheader").hide();
        $("#footer").hide();
        $("#xtitle").hide();
        $("#menu").hide();
        $("#page_filtre").show();
    }
    function hideFilterPage() {
        $("#content").show();
        $("#xheader").show();
        $("#footer").show();
        $("#xtitle").show();
        $("#menu").show();
        $("#page_filtre").hide();
    }
    function createOrderByElementDiv(inputName, labelText) {
        // removed from last span: fas fa-exchange-alt fa-rotate-90
        return (`
        <div class="row orderby-element" id=mv_${inputName}>
            <div class="col-1 p-0
                d-flex align-items-center justify-content-end
                fas fa-long-arrow-alt-up">
            </div>
            <div class="col-1 p-0
                d-flex align-items-center justify-content-center
                fas fa-long-arrow-alt-down">
            </div>

            <div class="col-1 d-flex align-items-center justify-content-end p-0" style=width:40px>
                <input class=input-checkmark id=${inputName} name=${inputName} type="checkbox">
            </div>
            <label class="col-6 text-start d-flex align-items-center" for=${inputName}>
                <div>
                    ${labelText}
                </div>
            </label>
            <div class="col-1 arrows" order=${inputName}>
                <span class=arrow-asc></span>
            </div>
        </div>
        `);
    }
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
    function createSlider(fitler, minVal = 0, maxVal, htmlElement, selectedElementMin, selectedElementMax, sign = '') {
        $(`#slider-range-${fitler}`).slider({
            range: true,
            min: minVal,
            max: maxVal,
            values: [0, maxVal],
            slide: function (event, ui) {
                $(`${htmlElement}`).html(ui.values[0] + sign + " - " + ui.values[1] + `${sign} `);
                if (filterObject[selectedElementMax] == null && filterObject[selectedElementMin] == null) {
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
            //console.log(isDisplayed);

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
                <span id=${filter}-list class=>
                <div class="row" style="min-height: 10px;"></div>`;
                //console.log(filterObject);
                $.each(elements, function (element, nombre) {
                    output += `
                    <div class="row w-100 m-auto ${filterObject[element] ? 'selected-element' : ''}" ${filter}=${element} >

                        ${filter == "brand" ?
                            `<div class='col-2 d-flex align-items-center justify-content-center p-0' style='color:black;'>
                                <span class="car-${element.toLowerCase()} fa-2x"></span>
                            </div>` : `<div class='col-2'> </div>`}

                        <div class='col-9 text-start d-flex align-items-center'>
                            <span class="w-75" >${CapitalizeFirstCase(element)}</span>
                        </div>
                        <div class='col-1 p-1'>
                            <span >${nombre}</span>
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
                        //console.log(element);
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
                        //console.log(filterObject[element]);
                    });
                })
            } else {
                $(`#${filter}-list`).remove();
            }
        });
    }
    function searchUrlBuilder(endpointUrl) {
        let url = endpointUrl;
        //console.log(filterObject)
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
        url = setOrdersOrder(url);
        console.log("URL: " + url)
        return removeAccents(url);
    }
    function setOrdersOrder(url) {
        console.log($("#orderby-list > div"));
        $("#orderby-list > div").each(function (i, e) {
            console.log(jQuery(e).attr("id"));
            let id = jQuery(e).attr("id").slice(3);
            // Consider we need to send the user coordinates with request of type distance
            if (filterObject[id][0] != false)
                if (filterObject[id] == filterObject.orderDistance)
                    url += `${id}=${filterObject[id][1]},${filterObject[id][2]['lat']},${filterObject[id][2]['long']}&`
                else
                    url += `${id}=${filterObject[id][1]}&`
        })
        return url;
    }
    function formatArrayToUrl(array) {
        let tab = [];
        array.forEach(element => {
            tab.push(element);
        });
        //console.log("formatArrayTOUrl: " + tab.toString());

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
            orderPrice: [null, "asc"],
            orderMileage: [null, "asc"],
            orderDistance: [null, "asc"],
            orderDateAdded: [null, "asc"],
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
        $('.orderby-element > div > input').prop("checked", false);
        $(`#slider-range-price`).slider("values", [0, getHighestPriceItemFromServer()])
        $(`#slider-range-kilometer`).slider("values", [0, getHighestKilometerItemFromServer()])

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
                //console.log(parseInt(data));
                response = parseInt(data);
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
    function getHighestKilometerItemFromServer() {

        let response;
        $.ajax({
            url: '/api/publications/maxKilometer',
            async: false,
            dataType: 'json',
            success: function (data) {
                //console.log(parseInt(data));
                response = parseInt(data);
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
    function getCodesPostalesFromServer() {
        let response;
        $.ajax({
            url: '/api/publications/postalcodes',
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                response = data;
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
    function getDistancesFromLocations(userCoordinates, locations) {
        //console.log(userCoordinates);
        locations.forEach((location) => {
            let destination = getWayPointFromZipCode(location.postalcode.replaceAll(' ', ''));
            location['distance'] = getTravelDistance(userCoordinates, destination);
            //console.log(location);
        });
        console.log(locations);

        return locations;
    }
    function setCookie(name, data) {
        $.cookie(name, data);
    }
    function readCookie(name) {
        return $.cookie(name);
    }
    function serverNewestPublication() {
        let response;
        $.ajax({
            url: '/api/publications/newest',
            async: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                response = data;
            },
            error: (xhr) => { console.log(xhr); }
        });
        return response;
    }
});
