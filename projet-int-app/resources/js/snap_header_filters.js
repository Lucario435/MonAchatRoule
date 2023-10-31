// Added scroll listener
// https://www.w3schools.com/howto/howto_js_sticky_header.asp
// When the user scrolls the page, execute myFunction
document.addEventListener("DOMContentLoaded", function () {
    window.onscroll = function () {
        myFunction();
        //myFunction2();
        console.log('scroll');
    };

    // Get the header
    var header = document.querySelector("#xheader");
    var sideFilters = document.getElementById("page_filtre");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;
    var sticky2 = sideFilters.offsetTop;

    //Init
    myFunction();

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        console.log(window.pageYOffset, ' > ', sticky)
        if (window.pageYOffset > sticky) {
            // header.classList.add("sticky");
            // sideFilters.classList.add("sticky-sidebar");
            toggleFixed();
        } else {
            toggleFixed();
        }
    }

    function toggleFixed() {
        $(header).addClass("sticky");
        $(sideFilters).addClass("sticky-sidebar");
        adjustWidth();

    }
    function RemoveFixed() {
        $(header).removeClass("sticky");
        $(sideFilters).removeClass("sticky-sidebar");
        adjustWidth();
    }

    function adjustWidth() {
        var parentwidth = $("body").width();
        $(header).width(parentwidth);
        $(sideFilters).width('350px');
    }
});