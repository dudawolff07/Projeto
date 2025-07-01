document.addEventListener('DOMContentLoaded', function() {
    // Função do ano opcional (só executa se o elemento existir)
    if(document.getElementById("displayYear")) {
        document.getElementById("displayYear").innerHTML = new Date().getFullYear();
    }

    // Restante do código Isotope
    var $grid = $('.grid').isotope({
        itemSelector: '.all',
        layoutMode: 'fitRows',
        percentPosition: true
    });

    $('.filters_menu li').click(function() {
        var filterValue = $(this).attr('data-filter');
        $('.filters_menu li').removeClass('active');
        $(this).addClass('active');
        $grid.isotope({ filter: filterValue });
    });

    // Inicializa outros plugins somente se existirem
    if($('select').length) {
        $('select').niceSelect();
    }
    
    if($(".client_owl-carousel").length) {
        $(".client_owl-carousel").owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            nav: true,
            autoplay: true,
            autoplayHoverPause: true,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                1000: { items: 2 }
            }
        });
    }
});

// Google Maps (só executa se o elemento existir)
if(document.getElementById("googleMap")) {
    function myMap() {
        var map = new google.maps.Map(document.getElementById("googleMap"), {
            center: new google.maps.LatLng(40.712775, -74.005973),
            zoom: 18
        });
    }
}