document.addEventListener('DOMContentLoaded', function() {
    // Preços dos serviços (pode ser movido para API depois)
    const servicePrices = {
        '120': 120,
        '70': 70,
        '100': 100,
        '150': 150,
        '90': 90,
        '180': 180
    };

    // Atualiza o ano no footer
    if(document.getElementById("displayYear")) {
        document.getElementById("displayYear").textContent = new Date().getFullYear();
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

    // Verifica login e preenche dados na página de agendamento
    if(window.location.pathname.includes('agenda.html')) {
        checkLoginForAppointment();
        
        // Configura links de login/cadastro
        $('#loginLink, #registerLink').on('click', function(e) {
            e.preventDefault();
            abrirLoginModal();
            
            if ($(this).attr('id') === 'registerLink') {
                mostrarFormulario('cadastro');
            }
        });
        
        // Atualiza preço quando o serviço muda
        $('#serviceType').on('change', updateTotalPrice);
        
        // Inicializa o preço
        updateTotalPrice();
        
        // Lógica do formulário de agendamento
        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();
            submitAppointment();
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

    // Inicializa o carrossel principal
    var carousel = document.getElementById('customCarousel1');
    if (carousel) {
        var myCarousel = new bootstrap.Carousel(carousel, {
            interval: 4000,
            wrap: true,
            ride: 'carousel'
        });
        
        carousel.addEventListener('mouseenter', function() {
            myCarousel.pause();
        });
        carousel.addEventListener('mouseleave', function() {
            myCarousel.cycle();
        });
        
        setTimeout(() => {
            myCarousel.to(0);
        }, 100);
    }
});

// Funções específicas para agendamento
function checkLoginForAppointment() {
    const isLoggedIn = localStorage.getItem('userLoggedIn') === 'true';
    const userData = JSON.parse(localStorage.getItem('userData') || '{}');
    
    if (isLoggedIn && userData) {
        // Preenche os campos com os dados do usuário
        $('#clientName').val(userData.name || '');
        $('#clientPhone').val(userData.phone || '');
        $('#clientEmail').val(userData.email || '');
        
        // Mostra o formulário
        $('#appointmentForm').fadeIn();
        $('#loginRequired').hide();
    } else {
        // Mostra a mensagem de login necessário
        $('#loginRequired').fadeIn();
        $('#appointmentForm').hide();
    }
}

function updateTotalPrice() {
    const selectedService = $('#serviceType').val();
    const price = servicePrices[selectedService] || 0;
    $('#totalPrice').text(`R$ ${price.toFixed(2).replace('.', ',')}`);
}

function submitAppointment() {
    // Simulação de envio para o backend
    const appointmentData = {
        serviceId: $('#serviceType').val(),
        serviceName: $('#serviceType option:selected').text().split(' - ')[0],
        date: $('#appointmentDate').val(),
        paymentMethod: $('#paymentMethod').val(),
        notes: $('#clientNotes').val(),
        price: $('#totalPrice').text()
    };

    // Aqui você substituirá por uma chamada AJAX real para o backend
    console.log('Dados do agendamento:', appointmentData);
    
    // Simulando resposta do servidor
    setTimeout(() => {
        showSuccessModal();
    }, 1000);
}

function showSuccessModal() {
    // Cria modal de sucesso dinamicamente
    const modalHtml = `
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 5rem;"></i>
                    <h3 class="mb-3">Agendamento Confirmado!</h3>
                    <p>Seu horário foi reservado com sucesso. Enviamos os detalhes para seu e-mail.</p>
                    <p class="fw-bold">Valor: ${$('#totalPrice').text()}</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-rosa" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>`;
    
    $('body').append(modalHtml);
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
    
    // Limpa o formulário após fechar o modal
    $('#successModal').on('hidden.bs.modal', function() {
        $('#appointmentForm')[0].reset();
        $('#totalPrice').text('R$ 0,00');
        $(this).remove();
    });
}

// Função chamada após login bem-sucedido
function onLoginSuccess(userData) {
    // Salva os dados do usuário
    localStorage.setItem('userLoggedIn', 'true');
    localStorage.setItem('userData', JSON.stringify(userData));
    
    // Fecha o modal
    fecharLoginModal();
    
    // Se estiver na página de agendamento, atualiza o formulário
    if (window.location.pathname.includes('agenda.html')) {
        checkLoginForAppointment();
    }
}

// Funções do modal de login (precisa ser integrado com seu login.js existente)
function abrirLoginModal() {
    $('#loginModal').fadeIn();
}

function fecharLoginModal() {
    $('#loginModal').fadeOut();
}

function mostrarFormulario(tipo) {
    $('.login-form').removeClass('active');
    $(`#form${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`).addClass('active');
    
    $('.login-tab').removeClass('active');
    $(`.login-tab:contains(${tipo === 'login' ? 'Login' : 'Cadastro'})`).addClass('active');
}