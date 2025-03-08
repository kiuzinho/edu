

<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>


<style>
  .text-danger {
    color: #dc3545;
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
  }

  input.form-control {
    border-color: #ced4da;
    /* Cor padrão */
  }
</style>

<script>
  // Máscara de CPF (permite digitar, colar e apagar)
  function mascaraCPF(input) {
    let cpf = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    // Aplica a máscara
    if (cpf.length > 3 && cpf.length <= 6) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3)}`;
    } else if (cpf.length > 6 && cpf.length <= 9) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3, 6)}.${cpf.slice(6)}`;
    } else if (cpf.length > 9) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3, 6)}.${cpf.slice(6, 9)}-${cpf.slice(9, 11)}`;
    }

    input.value = cpf;
  }

  // Validação do CPF
  function validarCPF(cpf) {
    const error = document.getElementById('cpf-error');

    // Verifica se tem 11 dígitos numéricos
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11) {
      error.style.display = 'inline';
      return false;
    }

    // Validação dos dígitos verificadores
    let soma = 0;
    for (let i = 0; i < 9; i++) {
      soma += parseInt(cpf[i]) * (10 - i);
    }
    let resto = (soma * 10) % 11;
    resto = (resto === 10 || resto === 11) ? 0 : resto;
    if (resto !== parseInt(cpf[9])) {
      error.style.display = 'inline';
      return false;
    }

    soma = 0;
    for (let i = 0; i < 10; i++) {
      soma += parseInt(cpf[i]) * (11 - i);
    }
    resto = (soma * 10) % 11;
    resto = (resto === 10 || resto === 11) ? 0 : resto;
    if (resto !== parseInt(cpf[10])) {
      error.style.display = 'inline';
      return false;
    }

    error.style.display = 'none';
    return true;
  }


  //Função para associar botão aos 4 formularios
  function enviarCadastro() {
  const dados = new FormData();

  // Formulário 1: Dados Principais
  const formGeral1 = document.getElementById('form-geral1');
  Array.from(formGeral1.elements).forEach(input => {
    if (input.name) dados.append(input.name, input.value);
  });

  // Formulário 2: CPF e RG
  const formGeral2 = document.getElementById('form-geral2');
  Array.from(formGeral2.elements).forEach(input => {
    if (input.name) dados.append(input.name, input.value);
  });

  // Formulário 3: Acesso
  const formAcesso = document.getElementById('form-acesso');
  Array.from(formAcesso.elements).forEach(input => {
    if (input.name) dados.append(input.name, input.value);
  });

  // Formulário 4: Localização
  const formLocalizacao = document.getElementById('form-localizacao');
  Array.from(formLocalizacao.elements).forEach(input => {
    if (input.name) dados.append(input.name, input.value);
  });

  // Validação de senhas
  const senha = dados.get('senha');
  const confirmarSenha = dados.get('confirmarSenha');
  
  if (senha !== confirmarSenha) {
    alert('As senhas não coincidem!');
    return;
  }

  // Requisição AJAX
  fetch('cadastrar_aluno.php', {
    method: 'POST',
    body: dados
  })
  .then(response => response.json())
  .then(resultado => {
    if (resultado.sucesso) {
      alert('Aluno cadastrado!');
      formGeral1.reset();
      formGeral2.reset();
      formAcesso.reset();
      formLocalizacao.reset();
    } else {
      alert('Erro: ' + resultado.erro);
    }
  });
}
</script>

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->
  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="../dashboard/index.html" class="b-brand text-primary">
          <!-- ========   Change your logo from here   ============ -->
          <img src="../assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="../dashboard/index.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <li class="pc-item pc-caption">
            <label>UI Components</label>
            <i class="ti ti-dashboard"></i>
          </li>
          <li class="pc-item">
            <a href="../elements/bc_typography.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-typography"></i></span>
              <span class="pc-mtext">Typography</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="../elements/bc_color.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
              <span class="pc-mtext">Color</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="../elements/icon-tabler.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
              <span class="pc-mtext">Icons</span>
            </a>
          </li>

          <li class="pc-item pc-caption">
            <label>Pages</label>
            <i class="ti ti-news"></i>
          </li>
          <li class="pc-item">
            <a href="../pages/login-v3.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-lock"></i></span>
              <span class="pc-mtext">Login</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="../pages/register-v3.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
              <span class="pc-mtext">Register</span>
            </a>
          </li>

          <li class="pc-item pc-caption">
            <label>Other</label>
            <i class="ti ti-brand-chrome"></i>
          </li>
          <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Menu
                levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
            <ul class="pc-submenu">
              <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
              <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                  <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                  <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                  <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                      <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                      <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="pc-item pc-hasmenu">
                <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                <ul class="pc-submenu">
                  <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                  <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                  <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                      <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                      <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="pc-item">
            <a href="../other/sample-page.html" class="pc-link">
              <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
              <span class="pc-mtext">Sample page</span>
            </a>
          </li>
        </ul>
        <div class="card text-center">
          <div class="card-body">
            <img src="../assets/images/img-navbar-card.png" alt="images" class="img-fluid mb-2">
            <h5>Help?</h5>
            <p>Get to resolve query</p>
            <button class="btn btn-success">Support</button>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
  <header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <!-- ======= Menu collapse Icon ===== -->
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="dropdown pc-h-item d-inline-flex d-md-none">
            <a
              class="pc-head-link dropdown-toggle arrow-none m-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false">
              <i class="ti ti-search"></i>
            </a>
            <div class="dropdown-menu pc-h-dropdown drp-search">
              <form class="px-3">
                <div class="form-group mb-0 d-flex align-items-center">
                  <i data-feather="search"></i>
                  <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                </div>
              </form>
            </div>
          </li>
          <li class="pc-h-item d-none d-md-inline-flex">
            <form class="header-search">
              <i data-feather="search" class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search here. . .">
            </form>
          </li>
        </ul>
      </div>
      <!-- [Mobile Media Block end] -->
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item pc-mega-menu">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false">
              <i class="ti ti-layout-grid"></i>
            </a>
            <div class="dropdown-menu pc-h-dropdown pc-mega-dmenu">
              <div class="row g-0">
                <div class="col image-block">
                  <h2 class="text-white">Explore Components</h2>
                  <p class="text-white my-4">Try our pre made component pages to check how it feels and suits as per your need.</p>
                  <div class="row align-items-end">
                    <div class="col-auto">
                      <div class="btn btn btn-light">View All <i class="ti ti-arrow-narrow-right"></i></div>
                    </div>
                    <div class="col">
                      <img src="../assets/images/mega-menu/chart.svg" alt="image" class="img-fluid img-charts">
                    </div>
                  </div>
                </div>
                <div class="col">
                  <h6 class="mega-title">UI Components</h6>
                  <ul class="pc-mega-list">
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Alerts</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Accordions</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Avatars</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Badges</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Breadcrumbs</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Button</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Buttons Groups</a></li>
                  </ul>
                </div>
                <div class="col">
                  <h6 class="mega-title">UI Components</h6>
                  <ul class="pc-mega-list">
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Menus</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Media Sliders / Carousel</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Modals</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Pagination</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Progress Bars &amp; Graphs</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Search Bar</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Tabs</a></li>
                  </ul>
                </div>
                <div class="col">
                  <h6 class="mega-title">Advance Components</h6>
                  <ul class="pc-mega-list">
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Advanced Stats</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Advanced Cards</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Lightbox</a></li>
                    <li><a href="#!" class="dropdown-item"><i class="ti ti-circle"></i> Notification</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="dropdown pc-h-item">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false">
              <i class="ti ti-language"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
              <a href="#!" class="dropdown-item">
                <i class="ti ti-user"></i>
                <span>My Account</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ti ti-settings"></i>
                <span>Settings</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ti ti-headset"></i>
                <span>Support</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ti ti-lock"></i>
                <span>Lock Screen</span>
              </a>
              <a href="#!" class="dropdown-item">
                <i class="ti ti-power"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
          <li class="dropdown pc-h-item">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false">
              <i class="ti ti-bell"></i>
              <span class="badge bg-success pc-h-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header d-flex align-items-center justify-content-between">
                <h5 class="m-0">Notification</h5>
                <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-circle-check text-success"></i></a>
              </div>
              <div class="dropdown-divider"></div>
              <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
                <div class="list-group list-group-flush w-100">
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="user-avtar bg-light-success"><i class="ti ti-gift"></i></div>
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">3:00 AM</span>
                        <p class="text-body mb-1">It's <b>Cristina danny's</b> birthday today.</p>
                        <span class="text-muted">2 min ago</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="user-avtar bg-light-primary"><i class="ti ti-message-circle"></i></div>
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">6:00 PM</span>
                        <p class="text-body mb-1"><b>Aida Burg</b> commented your post.</p>
                        <span class="text-muted">5 August</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="user-avtar bg-light-danger"><i class="ti ti-settings"></i></div>
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">2:45 PM</span>
                        <p class="text-body mb-1">Your Profile is Complete &nbsp;<b>60%</b></p>
                        <span class="text-muted">7 hours ago</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="user-avtar bg-light-primary"><i class="ti ti-headset"></i></div>
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">9:10 PM</span>
                        <p class="text-body mb-1"><b>Cristina Danny </b> invited to join <b> Meeting.</b></p>
                        <span class="text-muted">Daily scrum meeting time</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="text-center py-2">
                <a href="#!" class="link-primary">View all</a>
              </div>
            </div>
          </li>
          <li class="dropdown pc-h-item">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false">
              <i class="ti ti-mail"></i>
            </a>
            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header d-flex align-items-center justify-content-between">
                <h5 class="m-0">Message</h5>
                <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
              </div>
              <div class="dropdown-divider"></div>
              <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
                <div class="list-group list-group-flush w-100">
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">3:00 AM</span>
                        <p class="text-body mb-1">It's <b>Cristina danny's</b> birthday today.</p>
                        <span class="text-muted">2 min ago</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar">
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">6:00 PM</span>
                        <p class="text-body mb-1"><b>Aida Burg</b> commented your post.</p>
                        <span class="text-muted">5 August</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img src="../assets/images/user/avatar-3.jpg" alt="user-image" class="user-avtar">
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">2:45 PM</span>
                        <p class="text-body mb-1"><b>There was a failure to your setup.</b></p>
                        <span class="text-muted">7 hours ago</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <img src="../assets/images/user/avatar-4.jpg" alt="user-image" class="user-avtar">
                      </div>
                      <div class="flex-grow-1 ms-1">
                        <span class="float-end text-muted">9:10 PM</span>
                        <p class="text-body mb-1"><b>Cristina Danny </b> invited to join <b> Meeting.</b></p>
                        <span class="text-muted">Daily scrum meeting time</span>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="text-center py-2">
                <a href="#!" class="link-primary">View all</a>
              </div>
            </div>
          </li>
          <li class="dropdown pc-h-item">
            <a class="pc-head-link me-0" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
              <i class="ti ti-settings"></i>
            </a>
          </li>
          <li class="dropdown pc-h-item header-user-profile">
            <a
              class="pc-head-link dropdown-toggle arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              data-bs-auto-close="outside"
              aria-expanded="false">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
              <span>Stebin Ben</span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Stebin Ben</h6>
                    <span>UI/UX Designer</span>
                  </div>
                  <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
                </div>
              </div>
              <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="drp-t1"
                    data-bs-toggle="tab"
                    data-bs-target="#drp-tab-1"
                    type="button"
                    role="tab"
                    aria-controls="drp-tab-1"
                    aria-selected="true"><i class="ti ti-user"></i> Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="drp-t2"
                    data-bs-toggle="tab"
                    data-bs-target="#drp-tab-2"
                    type="button"
                    role="tab"
                    aria-controls="drp-tab-2"
                    aria-selected="false"><i class="ti ti-settings"></i> Setting</button>
                </li>
              </ul>
              <div class="tab-content" id="mysrpTabContent">
                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-edit-circle"></i>
                    <span>Edit Profile</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>View Profile</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-clipboard-list"></i>
                    <span>Social Profile</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-wallet"></i>
                    <span>Billing</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-power"></i>
                    <span>Logout</span>
                  </a>
                </div>
                <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-help"></i>
                    <span>Support</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>Account Settings</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-lock"></i>
                    <span>Privacy Center</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-messages"></i>
                    <span>Feedback</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-list"></i>
                    <span>History</span>
                  </a>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <section class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Cadastros</a></li>
                <li class="breadcrumb-item" aria-current="page">Cadastros alunos</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Cadastrar novo aluno</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ form-element ] start -->
        <div class="col-lg-12">
          <div class="card">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5>Nova entrada</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <button type="button" class="btn btn-success" onclick="enviarCadastro()">cadastrar</button>
                    <button type="reset" class="btn btn-light-secondary">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h5>Dados Principais</h5>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <form id="form-geral1">
                    <div class="form-group">
                      <label for="demo-text-input" class="form-label">Nome Completo</label>
                      <input class="form-control" name="nome" type="text" placeholder="João da Silva" alt="Nome" id="demo-text-input" required>
                    </div>
                    <div class="form-group">
                      <label for="demo-date-only" class="form-label">Data de Nascimento</label>
                      <input class="form-control" name="data_nascimento" type="date" id="demo-date-only" min="2000-01-01" required>
                    </div>
                    <div class="form-group">
                      <label for="demo-text-input" class="form-label">Nacionalidade</label>
                      <input class="form-control" name="nacionalidade" type="text" value="Brasileiro" id="demo-text-input">
                    </div>

                    <button type="submit" class="btn btn-primary mb-4">Salvar</button>
                  </form>
                </div>
                <div class="col-md-6">
                  <form id="form-geral2">
                    <div class="form-group">
                      <label class="form-label">CPF</label>
                      <input
                        type="text"
                        class="form-control"
                        name="cpf"
                        placeholder="000.000.000-00"
                        oninput="mascaraCPF(this)"
                        onblur="validarCPF(this.value)"
                        maxlength="14">
                      <span id="cpf-error" class="text-danger" style="display: none;">
                        CPF inválido ou incompleto
                      </span>
                    </div>

                    <div class="form-group">
                      <label for="demo-text-input" class="form-label">RG</label>
                      <input class="form-control" name="rg" type="text" placeholder="00.000.000-0" id="demo-text-input">
                    </div>
                  </form>
                </div>
              </div>
              <hr>
              <h5 class="mt-3">Acesso</h5>
              <br>
              <form id="form-acesso">
                <div class="row">
                
                  <div class="form-group col-md-6">
                    <label class="form-label" for="inputEmail4">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-label" for="senha">Senha</label>
                    <input
                      type="password"
                      name="senha"
                      class="form-control"
                      id="senha"
                      placeholder="Senha"
                      oninput="validarSenha()">
                  </div>
                  <div class="form-group col-6">
                    <label class="form-label" for="inlineFormInputGroupUsername">Nome de usuário</label>
                    <div class="input-group">
                      <div class="input-group-text">@</div>
                      <input type="text" class="form-control" name="usuario" id="inlineFormInputGroupUsername" placeholder="Nome de usuário">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-label" for="confirmarSenha">Confirme a Senha</label>
                    <input
                      type="password"
                      class="form-control"
                      id="confirmarSenha"
                      name="confirmarSenha"
                      placeholder="Confirme a senha"
                      oninput="validarSenha()">
                    <!-- Mensagem de erro -->
                    <span id="senha-error" class="text-danger"></span>
                  </div>
              </form>
              </div>
              <hr>
              <h5 class="mt-2">Localização</h5>
              <br>
              <br>
              <form id="form-localizacao">
                <div class="form-group">
                  <label class="form-label" for="inputAddress">Endereço</label>
                  <input type="text" name="endereco" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0">
                </div>
                <div class="form-group">
                  <label class="form-label" for="inputAddress2">Complemento</label>
                  <input type="text" name="complemento" class="form-control" id="inputAddress2" placeholder="Apartamento, hotel, casa, etc.">
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label class="form-label" for="inputCity">Cidade</label>
                    <input type="text" name="cidade" class="form-control" id="inputCity">
                  </div>
                  <div class="form-group col-md-4">
                    <label class="form-label" for="inputState">Estado</label>
                    <select name="estado" id="inputState" class="form-select">
                      <option value="PE">Pernambuco (PE)</option>
                      <option value="AC">Acre (AC)</option>
                      <option value="AL">Alagoas (AL)</option>
                      <option value="AP">Amapá (AP)</option>
                      <option value="AM">Amazonas (AM)</option>
                      <option value="BA">Bahia (BA)</option>
                      <option value="CE">Ceará (CE)</option>
                      <option value="DF">Distrito Federal (DF)</option>
                      <option value="ES">Espírito Santo (ES)</option>
                      <option value="GO">Goiás (GO)</option>
                      <option value="MA">Maranhão (MA)</option>
                      <option value="MT">Mato Grosso (MT)</option>
                      <option value="MS">Mato Grosso do Sul (MS)</option>
                      <option value="MG">Minas Gerais (MG)</option>
                      <option value="PA">Pará (PA)</option>
                      <option value="PB">Paraíba (PB)</option>
                      <option value="PR">Paraná (PR)</option>

                      <option value="PI">Piauí (PI)</option>
                      <option value="RJ">Rio de Janeiro (RJ)</option>
                      <option value="RN">Rio Grande do Norte (RN)</option>
                      <option value="RS">Rio Grande do Sul (RS)</option>
                      <option value="RO">Rondônia (RO)</option>
                      <option value="RR">Roraima (RR)</option>
                      <option value="SC">Santa Catarina (SC)</option>
                      <option value="SP">São Paulo (SP)</option>
                      <option value="SE">Sergipe (SE)</option>
                      <option value="TO">Tocantins (TO)</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label class="form-label" for="inputZip">CEP</label>
                    <input name="cep" type="text" class="form-control" id="inputZip">
                  </div>
                </div>
                </form>

            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            
          </div>
        </div>
      </div>
      <!-- [ form-element ] end -->
    </div>
    <!-- [ Main Content ] end -->
    </div>
  </section>
  <!-- [ Main Content ] end -->
  <?php include '../includes/footer.php'; ?>

  </html>