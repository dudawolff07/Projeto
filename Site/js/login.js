// Carrega o modal de login dinamicamente
function carregarLoginModal() {
  fetch('login-modal.html')
    .then(res => res.text())
    .then(html => {
      document.body.insertAdjacentHTML('beforeend', html);

      configurarEventosLogin(); // configurar eventos após o conteúdo estar no DOM
    });
}

// Executa ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
  carregarLoginModal();

  // Mostrar nome do usuário salvo (se existir)
  const saved = localStorage.getItem("userData");
  if (saved) {
    const user = JSON.parse(saved);
    const nomeEl = document.getElementById("userName");
    if (nomeEl) {
      nomeEl.textContent = user.nome.split(" ")[0];
    }
  }
});
document.addEventListener('click', function(e) {
  if (e.target.closest('#abrirLoginModal')) {
    const modal = document.getElementById('loginModal');
    if (modal) modal.style.display = 'block';
  }
});

window.fecharLoginModal = function() {
  const modal = document.getElementById('loginModal');
  if (modal) modal.style.display = 'none';
}

window.mostrarFormulario = function(tipo) {
  const formLogin = document.getElementById('formLogin');
  const formCadastro = document.getElementById('formCadastro');
  const tabs = document.querySelectorAll('.login-tab');

  if (tipo === 'login') {
    formLogin.classList.add('active');
    formCadastro.classList.remove('active');
    tabs[0].classList.add('active');
    tabs[1].classList.remove('active');
  } else {
    formCadastro.classList.add('active');
    formLogin.classList.remove('active');
    tabs[1].classList.add('active');
    tabs[0].classList.remove('active');
  }
}


// Evento global para abrir o modal
document.addEventListener("click", function (e) {
  const userLink = e.target.closest(".user_link");
  if (userLink) {
    e.preventDefault();
    const modal = document.getElementById("loginModal");
    if (modal) {
      modal.style.display = "flex";
    }
  }

  if (e.target.classList.contains("login-modal")) {
    fecharLoginModal();
  }
});

function fecharLoginModal() {
  const modal = document.getElementById("loginModal");
  if (modal) {
    modal.style.display = "none";
  }
}

function mostrarFormulario(tipo) {
  const loginTab = document.querySelector(".login-tab:nth-child(1)");
  const cadastroTab = document.querySelector(".login-tab:nth-child(2)");
  const formLogin = document.getElementById("formLogin");
  const formCadastro = document.getElementById("formCadastro");

  if (!loginTab || !cadastroTab || !formLogin || !formCadastro) return;

  if (tipo === "login") {
    loginTab.classList.add("active");
    cadastroTab.classList.remove("active");
    formLogin.classList.add("active");
    formCadastro.classList.remove("active");
  } else {
    cadastroTab.classList.add("active");
    loginTab.classList.remove("active");
    formCadastro.classList.add("active");
    formLogin.classList.remove("active");
  }
}

// Ativa os eventos após o modal ser carregado no DOM
function configurarEventosLogin() {
  const formCadastro = document.getElementById("formCadastro");
  if (formCadastro) {
    formCadastro.addEventListener("submit", function (e) {
      e.preventDefault();

      const nome = document.getElementById("cadastroNome").value;
      const senha = document.getElementById("cadastroSenha").value;
      const confirmar = document.getElementById("confirmarSenha").value;

      if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return;
      }

      const userData = { nome: nome };
      localStorage.setItem("userData", JSON.stringify(userData));
      fecharLoginModal();

      const nomeEl = document.getElementById("userName");
      if (nomeEl) {
        nomeEl.textContent = nome.split(" ")[0];
      }
    });
  }
}

