document.addEventListener('DOMContentLoaded', function() {
    // Atualiza o ano no footer
    if(document.getElementById("year")) {
        document.getElementById("year").textContent = new Date().getFullYear();
    }

    // Inicializa o menu responsivo do Bootstrap
    var navbarToggler = document.querySelector('.navbar-toggler');
    if(navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            document.querySelector('#navbarSupportedContent').classList.toggle('show');
        });
    }

    // Inicializa Isotope para filtros
    var grid = document.querySelector('.grid');
    if(grid) {
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
    }

    // Inicializa selects estilizados
    if($('select').length) {
        $('select').niceSelect();
    }

    // Lógica do formulário de agendamento
    if($('#appointmentForm').length) {
        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();
            $('#passwordModal').fadeIn();
        });

        $('#cancelBtn').on('click', function() {
            $('#passwordModal').fadeOut();
        });

        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();
            const password = $('#clientPassword').val();
            
            if(password === "beleza123") {
                alert('Agendamento confirmado com sucesso! Entraremos em contato para validação.');
                $('#passwordModal').fadeOut();
                $('#appointmentForm')[0].reset();
            } else {
                $('#passwordError').fadeIn();
            }
        });
    }

    // Inicializa carrossel de clientes
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

// Google Maps
if(document.getElementById("googleMap")) {
    function myMap() {
        var map = new google.maps.Map(document.getElementById("googleMap"), {
            center: new google.maps.LatLng(40.712775, -74.005973),
            zoom: 18
        });
    }
}