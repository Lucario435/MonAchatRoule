
$(() => {
    $("#page_filtre").hide();
    // $("#content").hide();
    // $("#xheader").hide();
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
});