
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
}

const removeAccents = str =>
    str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

$(() => {
    $("#page_filtre").show();
    $("#content").hide();
    $("#xheader").hide();
    //$("#span-price").hide();

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

    listFilterDataFromServer("brand", "brands", "selectedBrands");
    listFilterDataFromServer("body", "bodies", "selectedBodyType");
    listFilterDataFromServer("transmission", "transmissions", "selectedTransmissions");

    $("#label-price").on("click", function (event) {
        let isDisplayed = $(`#span-price`).length;
        console.log(isDisplayed);
        if (!isDisplayed) {
            console.log(filterObject);
            $("#label-price").after(
                `
                 <span id="span-price">
                            <div class="row" style=height:10px></div>
                            <div class="row">
                                <div class="col-4 text-end">minimum</div>
                                <div class="col-8">
                                <input class="border" type="number" id="min_price" value=${filterObject.selectedMinPrice != null ? filterObject.selectedMinPrice : ''}>
                                </div>
                            </div>
                            <div class="row" style="height: 10px"></div>
                            <div class="row">
                                <div class="col-4 text-end">maximum</div>
                                <div class="col-8">
                                <input class="border" type="number" id="max_price" value=${filterObject.selectedMaxPrice != null ? filterObject.selectedMaxPrice : ''}></div>
                            </div>
                  </span>
                `
            );
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
                
                if ($("#max_price").val() == ''){
                    filterObject.numberSelectedFilters--;
                    filterObject.selectedMaxPrice = null;
                }

                setErrorMaxInput("price", $("#max_price").val(), filterObject.selectedMinPrice);

                ShowNumberOfActiveFilters("#number-filter", filterObject.numberSelectedFilters);
                console.log("max kilometer changed " + filterObject.selectedMaxPrice);
            })
        } else {
            $("#span-price").remove();
        }

    });

    $("#label-kilometer").on("click", function (event) {
        let isDisplayed = $(`#span-kilometer`).length;
        console.log(isDisplayed);
        if (!isDisplayed) {
            console.log(filterObject);
            $("#label-kilometer").after(
                `
                 <span id="span-kilometer">
                            <div class="row" style=height:10px></div>
                            <div class="row">
                                <div class="col-4 text-end">minimum</div>
                                <div class="col-8">
                                <input class="border" type="number" id="min_kilometer" value=${filterObject.selectedMinMileage != null ? filterObject.selectedMinMileage : ''}>
                                </div>
                            </div>
                            <div class="row" style="height: 10px"></div>
                            <div class="row">
                                <div class="col-4 text-end">maximum</div>
                                <div class="col-8">
                                <input class="border" type="number" id="max_kilometer" value=${filterObject.selectedMaxMileage != null ? filterObject.selectedMaxMileage : ''}></div>
                            </div>
                            
                  </span>
                `
            );

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
                
                if ($("#max_kilometer").val() == ''){
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

            // $("#min_kilometer").on("input", function (ev) {
            //     filterObject.selectedMinMileage = parseInt($("#min_kilometer").val());
            //     setErrorMaxInput('kilometer', parseInt($("#max_kilometer").val()), filterObject.selectedMinMileage);
            //     console.log("min kilo changed " + filterObject.selectedMinMileage);

            // })
            // $("#max_kilometer").on("input", function (ev) {
            //     setErrorMaxInput('kilometer', parseInt($("#max_kilometer").val()), filterObject.selectedMinMileage);

            // })
        } else {
            $("#span-kilometer").remove();
        }

    });

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
    // $("#label-marque").on("click", function (ev) {
    //     let isDisplayed = $('#brands-list').length;
    //     console.log(isDisplayed);
    //     if (!isDisplayed) {
    //         // Do ajax call to get all makes of cars in DB
    //         let brands;
    //         $.ajax({
    //             url: '/api/publications/brands',
    //             async: false,
    //             success: function (data) {
    //                 brands = data;
    //                 console.log(data);
    //             },
    //             error: (xhr) => { console.log(xhr); }
    //         });

    //         // format to html
    //         let output = `<span id=brands-list>
    //         <div class="row" style="min-height: 20px;"></div>`;
    //         $.each(brands, function (brand, nombre) {

    //             // if (!brand in selectedBrands)
    //             //     selectedBrands.push({ brand: false });

    //             output += `
    //             <div class="row ${selectedBrands[brand] ? 'selected-element' : ''}" brand=${brand} >

    //                 <div class='col-2 text-center p-0' style='color:black;'>
    //                     <span class="car-${brand.toLowerCase()} fa-2x"></span>
    //                 </div>
    //                 <div class='col-9 text-start d-flex align-items-center'>
    //                     <span class="w-75" style="font-size: 22px">${brand}</span>
    //                 </div>
    //                 <div class='col-1 p-1'>
    //                     <span style="font-size: 20px">${nombre}</span>
    //                 </div>

    //             </div>`;


    //         });
    //         output += `</span>`;
    //         // Show them
    //         $("#label-marque").after(
    //             output
    //         );
    //         // Setting up listeners for selection of filter    
    //         $.each(brands, function (brand, nombre) {
    //             $(`div[brand=${brand}]`).on("click", (ev) => {
    //                 console.log(brand);
    //                 $(`div[brand=${brand}]`).toggleClass("selected-element");
    //                 if ($(`div[brand=${brand}]`).hasClass("selected-element")) {
    //                     selectedBrands.add(brand);
    //                 } else {
    //                     selectedBrands.delete(brand);
    //                 }
    //                 selectedBrands[brand] = $(`div[brand=${brand}]`).hasClass("selected-element");
    //                 console.log(selectedBrands[brand]);
    //             });
    //         })
    //     } else {
    //         $('#brands-list').remove();
    //     }
    // })

    // $("#label-body").on("click", function (ev) {
    //     let isDisplayed = $('#body-list').length;
    //     console.log(isDisplayed);
    //     if (!isDisplayed) {
    //         // Do ajax call to get all makes of cars in DB
    //         let bodies;
    //         $.ajax({
    //             url: '/api/publications/bodies',
    //             async: false,
    //             success: function (data) {
    //                 bodies = data;
    //                 console.log(data);
    //             },
    //             error: (xhr) => { console.log(xhr); }
    //         });

    //         // format to html
    //         let output = `<span id=body-list>
    //         <div class="row" style="min-height: 20px;"></div>`;
    //         $.each(bodies, function (body, nombre) {


    //             output += `
    //             <div class="row ${selectedBodyType[body] ? 'selected-element' : ''}" body=${body} >

    //                 <div class='col-2 ' >

    //                 </div>
    //                 <div class='col-9 text-start d-flex align-items-center'>
    //                     <span class="w-75" style="font-size: 22px">${CapitalizeFirstCase(body)}</span>
    //                 </div>
    //                 <div class='col-1 p-1'>
    //                     <span style="font-size: 20px">${nombre}</span>
    //                 </div>

    //             </div>`;


    //         });
    //         output += `</span>`;
    //         // Show them
    //         $("#label-body").after(
    //             output
    //         );
    //         // Setting up listeners for selection of filter    
    //         $.each(bodies, function (body, nombre) {
    //             $(`div[body=${body}]`).on("click", (ev) => {
    //                 console.log(body);
    //                 $(`div[body=${body}]`).toggleClass("selected-element");
    //                 if ($(`div[body=${body}]`).hasClass("selected-element")) {
    //                     selectedBodyType.add(body);
    //                 } else {
    //                     selectedBodyType.delete(body);
    //                 }
    //                 selectedBodyType[body] = $(`div[body=${body}]`).hasClass("selected-element");
    //                 console.log(selectedBodyType[body]);
    //             });
    //         })
    //     } else {
    //         $('#body-list').remove();
    //     }
    // });

    //Submit the search

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
                    //console.log(data);
                    let html = $(data).html();
                    let content = $(data).find("#content").find("#content");
                    console.log(data);
                    $("#content").html(data);
                },
                error: (xhr) => { console.log(xhr); }
            });

        }

    });

    $("#label-reset").on("click", function (event) {
        resetFilters();
    });
    function setBackgroundColor(element, color) {
        if ($("#erreur").length == 0 && color == "green")
            $(element).css("background-color", color);
        else
            $(element).css("background-color", color);
    }
    function searchUrlBuilder(endpointUrl) {
        let url = endpointUrl;
        if (filterObject.selectedBrands.size > 0)
            url += `brand=${formatArrayToUrl(filterObject.selectedBrands)}&`;
        //console.log(filterObject.selectedBodyType);
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
        }
        $(".selected-element").removeClass("selected-element");
        $("#min_price").val('');
        $("#max_price").val('');
        $("#min_kilometer").val('');
        $("#max_kilometer").val('');
        $(`#val-max-price-error`).remove();
        $(`#val-max-kilometer-error`).remove();
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
        $(element).html(number);
    }
});