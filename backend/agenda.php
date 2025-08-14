<?php include 'includes/header.php'; ?>

<!-- Conteúdo principal -->
<section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Agende seu horário
        </h2>
      </div>

      
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="row">
            <div class="col-lg-4">
              <div class="professional-card text-center">
                <img src="images/cabeleireira.png" alt="Juliana Wolff" class="professional-img">
                <h3>Juliana Wolff</h3>
                <h5 class="text-muted mb-4">Especialista em Cuidados Capilares</h5>
                
                <div class="availability mb-4">
                  <p><i class="far fa-clock contact-icon"></i> Terça a Sexta: 9h às 19h</p>
                  <p><i class="far fa-clock contact-icon"></i> Sábado: 9h às 17h</p>
                </div>
                
                <div class="contact-info mb-4">
                  <p><i class="fas fa-phone-alt contact-icon"></i> (51) 98765-4321</p>
                  <p><i class="fas fa-map-marker-alt contact-icon"></i> Rolante/RS</p>
                </div>
                
               
              </div>
            </div>
            
            <div class="col-lg-8">
  <div id="loginRequired" class="alert alert-info" style="display: none;">
  <p>Para agendar um horário, você precisa estar logado. 
     <a href="#" id="loginLink">Faça login</a> ou 
     <a href="#" id="registerLink">cadastre-se</a>.
  </p>
</div>
    
    <form id="appointmentForm" style="display: none;">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="clientName">Nome completo</label>
          <input type="text" class="form-control" id="clientName" readonly>
          <small class="text-muted">Dados do seu cadastro</small>
        </div>
        <div class="form-group col-md-6">
          <label for="clientPhone">Telefone/WhatsApp</label>
          <input type="tel" class="form-control" id="clientPhone" readonly>
          <small class="text-muted">Dados do seu cadastro</small>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="clientEmail">E-mail</label>
          <input type="email" class="form-control" id="clientEmail" readonly>
          <small class="text-muted">Dados do seu cadastro</small>
        </div>
        <div class="form-group col-md-6">
          <label for="appointmentDate">Data preferencial</label>
          <input type="date" class="form-control" id="appointmentDate" required>
        </div>
      </div>
  <div class="form-group col-md-6">
  <label>Horário preferencial</label>
  <div class="time-picker">
    <!-- Manhã -->
    <div class="time-period">
      <h6>Manhã</h6>
      <div class="time-options">
        <label class="time-option">
          <input type="radio" name="appointmentTime" value="09:00" required>
          <span>09:00</span>
        </label>
        <label class="time-option">
          <input type="radio" name="appointmentTime" value="09:30">
          <span>09:30</span>
        </label>
      </div>
    </div>
    
    <!-- Tarde -->
    <div class="time-period">
      <h6>Tarde</h6>
      <div class="time-options">
        <label class="time-option">
          <input type="radio" name="appointmentTime" value="13:00">
          <span>13:00</span>
        </label>
        <label class="time-option">
          <input type="radio" name="appointmentTime" value="13:30">
          <span>13:30</span>
        </label>
      </div>
    </div>
  </div>
</div>


      
      <div class="form-group">
        <label for="serviceType">Serviço desejado</label>
        <select class="form-control nice-select" id="serviceType" required>
          <option value="">Selecione o serviço</option>
          <option value="120">Corte + Hidratação - R$ 120</option>
          <option value="70">Corte - R$ 70</option>
          <option value="100">Corte + Penteado Simples - R$ 100</option>
          <option value="150">Coloração - R$ 150</option>
          <option value="90">Hidratação Profunda - R$ 90</option>
          <option value="180">Progressiva sem Formol - R$ 180</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="paymentMethod">Forma de Pagamento</label>
        <select class="form-control nice-select" id="paymentMethod" required>
          <option value="">Selecione a forma de pagamento</option>
          <option>Dinheiro</option>
          <option>PIX</option>
          <option>Cartão de Crédito</option>
          <option>Cartão de Débito</option>
          <option>Transferência Bancária</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="clientNotes">Observações</label>
        <textarea class="form-control" id="clientNotes" rows="3" placeholder="Alguma observação importante?"></textarea>
      </div>
      
      <div class="total-price-container bg-light p-3 rounded mb-4">
        <h5 class="text-center">Total: <span id="totalPrice">R$ 0,00</span></h5>
      </div>
      
      <div class="text-center mt-2">
        <button type="submit" class="btn btn-rosa btn-confirmar-agendamento">
           Confirmar Agendamento
        </button> 
           </div>
    </form>
  </div>
</div>
          </div>
        </div>
      </div>
    </div>
  </section>
echo '<p>Antes do footer</p>';

<?php include 'includes/footer.php'; ?>

echo '<p>Depois do footer</p>';
