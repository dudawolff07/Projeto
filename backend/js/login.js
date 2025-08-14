// login.js - Versão corrigida e otimizada

let modalCarregado = false;

// ========== FUNÇÕES PRINCIPAIS ========== //

function carregarLoginModal() {
  if (modalCarregado) return;
  
  fetch('login-modal.html')
    .then(res => {
      if (!res.ok) throw new Error('Modal não encontrado');
      return res.text();
    })
    .then(html => {
      document.body.insertAdjacentHTML('beforeend', html);
      modalCarregado = true;
      configurarEventosModal();
    })
    .catch(err => {
      console.error('Erro ao carregar modal:', err);
      // Fallback: Mostra mensagem amigável
      alert('Sistema temporariamente indisponível. Tente novamente mais tarde.');
    });
}

function configurarEventosModal() {
  const modal = document.getElementById('loginModal');
  if (!modal) return;

  // Fechar modal ao clicar no fundo ou no 'X'
  modal.addEventListener('click', (e) => {
    if (e.target === modal || e.target.classList.contains('close-modal')) {
      fecharLoginModal();
    }
  });

  // Configura navegação entre abas
  document.querySelectorAll('.login-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const tipo = tab.textContent.toLowerCase();
      mostrarFormulario(tipo);
    });
  });

  // Configura formulários
  document.getElementById('formLogin')?.addEventListener('submit', processarLogin);
  document.getElementById('formCadastro')?.addEventListener('submit', processarCadastro);
  
  // Links especiais
  document.getElementById('forgotPasswordLink')?.addEventListener('click', (e) => {
    e.preventDefault();
    mostrarRecuperacaoSenha();
  });
}

// ========== CONTROLE DO MODAL ========== //

function abrirLogin(e) {
  if (e) e.preventDefault();
  const modal = document.getElementById('loginModal');
  
  if (!modal) {
    carregarLoginModal();
    setTimeout(() => abrirLogin(), 300);
    return;
  }
  
  modal.style.display = 'flex';
  mostrarFormulario('login');
}

function fecharLoginModal() {
  const modal = document.getElementById('loginModal');
  if (modal) modal.style.display = 'none';
}

function mostrarFormulario(tipo) {
  // Esconde todos os formulários
  document.querySelectorAll('.login-form').forEach(form => {
    form.classList.remove('active');
  });

  // Ativa formulário selecionado
  if (tipo === 'login') {
    document.getElementById('formLogin')?.classList.add('active');
    document.querySelector('.login-tab:first-child')?.classList.add('active');
    document.querySelector('.login-tab:last-child')?.classList.remove('active');
  } else if (tipo === 'cadastro') {
    document.getElementById('formCadastro')?.classList.add('active');
    document.querySelector('.login-tab:last-child')?.classList.add('active');
    document.querySelector('.login-tab:first-child')?.classList.remove('active');
  }
}

// ========== FORMULÁRIO DE RECUPERAÇÃO ========== //

function mostrarRecuperacaoSenha() {
  const container = document.querySelector('.login-content');
  
  // Remove formulário existente se houver
  const oldForm = document.getElementById('formRecovery');
  if (oldForm) oldForm.remove();

  // Cria novo formulário
  const recoveryHTML = `
    <form id="formRecovery" class="login-form active">
      <h4>Recuperar Senha</h4>
      <p>Digite seu e-mail para receber o link de recuperação</p>
      <input type="email" id="recoveryEmail" placeholder="Seu e-mail" required>
      <button type="submit" class="btn-rosa">Enviar Link</button>
      <div class="text-center mt-3">
        <a href="#" id="backToLogin">Voltar ao Login</a>
      </div>
    </form>
  `;
  
  container.insertAdjacentHTML('beforeend', recoveryHTML);
  
  // Configura eventos
  document.getElementById('formRecovery').addEventListener('submit', processarRecuperacaoSenha);
  document.getElementById('backToLogin').addEventListener('click', (e) => {
    e.preventDefault();
    mostrarFormulario('login');
  });
}

// ========== PROCESSAMENTO DE FORMULÁRIOS ========== //

function processarLogin(e) {
  e.preventDefault();
  
  const email = document.querySelector('#formLogin input[type="text"]').value;
  const senha = document.querySelector('#formLogin input[type="password"]').value;
  
  // Validação básica
  if (!email || !senha) {
    alert('Preencha todos os campos!');
    return;
  }

  // Verifica no localStorage (simulação)
  const userData = JSON.parse(localStorage.getItem('userData') || 'null');
  
  if (userData && userData.email === email) {
    localStorage.setItem('userLoggedIn', 'true');
    alert(`Bem-vindo(a) de volta, ${userData.nome.split(' ')[0]}!`);
    fecharLoginModal();
    location.reload();
  } else {
    alert('Credenciais inválidas!');
  }
}

function processarCadastro(e) {
  e.preventDefault();
  
  const nome = document.getElementById('cadastroNome').value;
  const email = document.getElementById('cadastroEmail').value;
  const senha = document.getElementById('cadastroSenha').value;
  const confirmarSenha = document.getElementById('confirmarSenha').value;

  // Validações
  if (!nome || !email || !senha) {
    alert('Preencha todos os campos obrigatórios!');
    return;
  }

  if (senha !== confirmarSenha) {
    alert('As senhas não coincidem!');
    return;
  }

  // Salva dados (simulação)
  const userData = { nome, email, senha };
  localStorage.setItem('userData', JSON.stringify(userData));
  
  alert('Cadastro realizado com sucesso! Faça login para continuar.');
  mostrarFormulario('login');
}

function processarRecuperacaoSenha(e) {
  e.preventDefault();
  const email = document.getElementById('recoveryEmail').value;
  
  if (!email) {
    alert('Digite seu e-mail cadastrado');
    return;
  }

  // Simula envio
  const btn = document.querySelector('#formRecovery button');
  btn.disabled = true;
  btn.textContent = 'Enviando...';
  
  setTimeout(() => {
    btn.textContent = 'Link Enviado!';
    setTimeout(() => {
      mostrarFormulario('login');
    }, 1000);
  }, 1500);
}

// ========== INICIALIZAÇÃO ========== //

document.addEventListener('DOMContentLoaded', () => {
  // Carrega o modal antecipadamente
  carregarLoginModal();
  
  // Configura clique no ícone de usuário
  document.getElementById('abrirLoginModal')?.addEventListener('click', abrirLogin);
  
  // Verifica se usuário está logado
  if (localStorage.getItem('userLoggedIn') === 'true') {
    const userData = JSON.parse(localStorage.getItem('userData'));
    if (userData?.nome) {
      const nomeEl = document.getElementById('userName');
      if (nomeEl) nomeEl.textContent = userData.nome.split(' ')[0];
    }
  }
});