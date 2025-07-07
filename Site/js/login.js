// Variável para controlar se o modal foi carregado
let modalCarregado = false;

// Carrega o modal de login dinamicamente
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
    });
}

// Configura todos os eventos do modal
function configurarEventosModal() {
  const modal = document.getElementById('loginModal');
  if (!modal) return;

  // Evento para fechar modal ao clicar no fundo
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      fecharLoginModal();
    }
  });

  // Configura links de login/cadastro
  document.getElementById('loginLink')?.addEventListener('click', abrirLogin);
  document.getElementById('registerLink')?.addEventListener('click', abrirCadastro);

  // Configura formulário de cadastro
  const formCadastro = document.getElementById('formCadastro');
  if (formCadastro) {
    formCadastro.addEventListener('submit', function(e) {
      e.preventDefault();
      processarCadastro();
    });
  }
}

// Funções para abrir o modal nos modos específicos
function abrirLogin(e) {
  if (e) e.preventDefault();
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'flex';
    mostrarFormulario('login');
  } else {
    carregarLoginModal();
    setTimeout(() => abrirLogin(), 300);
  }
}

function abrirCadastro(e) {
  if (e) e.preventDefault();
  const modal = document.getElementById('loginModal');
  if (modal) {
    modal.style.display = 'flex';
    mostrarFormulario('cadastro');
  } else {
    carregarLoginModal();
    setTimeout(() => abrirCadastro(), 300);
  }
}

// Funções globais para controle do modal
window.fecharLoginModal = function() {
  const modal = document.getElementById('loginModal');
  if (modal) modal.style.display = 'none';
}

window.mostrarFormulario = function(tipo) {
  const formLogin = document.getElementById('formLogin');
  const formCadastro = document.getElementById('formCadastro');
  const tabs = document.querySelectorAll('.login-tab');

  if (tipo === 'login') {
    formLogin?.classList.add('active');
    formCadastro?.classList.remove('active');
    tabs[0]?.classList.add('active');
    tabs[1]?.classList.remove('active');
  } else {
    formCadastro?.classList.add('active');
    formLogin?.classList.remove('active');
    tabs[1]?.classList.add('active');
    tabs[0]?.classList.remove('active');
  }
}

// Processa o formulário de cadastro
function processarCadastro() {
  const nome = document.getElementById('cadastroNome')?.value;
  const email = document.getElementById('cadastroEmail')?.value;
  const telefone = document.getElementById('cadastroTelefone')?.value;
  const senha = document.getElementById('cadastroSenha')?.value;
  const confirmar = document.getElementById('confirmarSenha')?.value;

  if (!nome || !email || !senha) {
    alert('Preencha todos os campos obrigatórios!');
    return;
  }

  if (senha !== confirmar) {
    alert('As senhas não coincidem!');
    return;
  }

  const userData = { 
    nome: nome,
    name: nome,
    email: email,
    phone: telefone 
  };
  
  localStorage.setItem('userData', JSON.stringify(userData));
  localStorage.setItem('userLoggedIn', 'true');

  if (typeof onLoginSuccess === 'function') {
    onLoginSuccess(userData);
  } else {
    fecharLoginModal();
    location.reload();
  }
}

// Inicialização
document.addEventListener('DOMContentLoaded', () => {
  carregarLoginModal();
  
  // Verifica se já está logado
  const saved = localStorage.getItem('userData');
  if (saved) {
    const user = JSON.parse(saved);
    const nomeEl = document.getElementById('userName');
    if (nomeEl) {
      nomeEl.textContent = user.nome.split(' ')[0];
    }
  }
});

// Evento para ícone de usuário no cabeçalho
document.addEventListener('click', function(e) {
  if (e.target.closest('.user_link')) {
    e.preventDefault();
    abrirLogin();
  }
});