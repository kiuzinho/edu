<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>
<link rel="stylesheet" href="../assets/css/plugins/bootstrap-switch-button.min.css">

<script>
  // máscara de cpf ( digitar, colar e apagar)
  function mascaraCPF(input) {
    let cpf = input.value.replace(/\D/g, ''); // remove caracteres não numéricos

    // aplica a máscara
    if (cpf.length > 3 && cpf.length <= 6) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3)}`;
    } else if (cpf.length > 6 && cpf.length <= 9) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3, 6)}.${cpf.slice(6)}`;
    } else if (cpf.length > 9) {
      cpf = `${cpf.slice(0, 3)}.${cpf.slice(3, 6)}.${cpf.slice(6, 9)}-${cpf.slice(9, 11)}`;
    }

    input.value = cpf;
  }

  // validação do cpf
  function validarCPF(cpf) {
    const error = document.getElementById('cpf-error');

    // ver se tem 11 dígitos numéricos
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11) {
      error.style.display = 'inline';
      return false;
    }

    // validação dos dígitos verificadores
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

  // enviar dados da equipe
  function enviarCadastroEquipe() {
    const dados = new FormData();

    // coleta os dados dos formulários
    ['form-geral1', 'form-geral2', 'form-acesso'].forEach(formId => {
      const form = document.getElementById(formId);
      Array.from(form.elements).forEach(input => {
        if (input.name) dados.append(input.name, input.value);
      });
    });

    // adiciona o valor do cargo ao formdata
    dados.append('cargo', document.getElementById('cargo').value);

    // validação de senhas
    if (dados.get('senha') !== dados.get('confirmarSenha')) {
      alert('As senhas não coincidem!');
      return;
    }

    // validação de cpf
    if (!validarCPF(dados.get('cpf'))) {
      alert('CPF inválido!');
      return;
    }

    // requisição ajax
    fetch('cad_equipe.php', {
        method: 'POST',
        body: dados
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na comunicação com o servidor');
        }
        return response.json();
      })
      .then(resultado => {
        if (resultado.sucesso) {
          alert('Membro da equipe cadastrado!');
          document.querySelectorAll('form').forEach(form => form.reset());
        } else {
          alert('Erro: ' + resultado.erro);
        }
      })
      .catch(error => {
        alert('Erro na comunicação com o servidor: ' + error.message);
      });
  }

  // atualiza o cargo (professor/secretário) no hidden input
  document.querySelector('input[data-toggle="switchbutton"]').addEventListener('change', function() {
    document.getElementById('cargo').value = this.checked ? 'professor' : 'secretario';
  });
</script>

<!-- [body] start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ pre-loader ] end -->

  <!-- [ sidebar menu ] start -->
  <?php include '../includes/sidebar_menu.php'; ?>
  <!-- [ sidebar menu ] end -->

  <!-- [ header topbar ] start -->
  <?php include '../includes/header_topbar.php'; ?>
  <!-- [ header ] end -->

  <!-- [ main content ] start -->
  <section class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Cadastros</a></li>
                <li class="breadcrumb-item" aria-current="page">Cadastrar equipe</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Cadastrar Equipe</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ main content ] start -->
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
                    <button type="button" class="btn btn-success" onclick="enviarCadastroEquipe()">Cadastrar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h5>Dados principais</h5>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <form id="form-geral1">
                    <div class="form-group">
                      <label for="demo-text-input" class="form-label">Nome completo</label>
                      <input class="form-control" name="nome" type="text" placeholder="Ronaldo Alves" alt="nome" id="demo-text-input" required>
                    </div>
                    <div class="form-group">
                      <label for="demo-date-only" class="form-label">Data de nascimento</label>
                      <input class="form-control" name="data_nascimento" type="date" id="demo-date-only" min="2000-01-01" required>
                    </div>
                    <div class="form-group">
                      <label for="demo-text-input" class="form-label">Nacionalidade</label>
                      <input class="form-control" name="nacionalidade" type="text" value="Brasileiro" id="demo-text-input">
                    </div>
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

                    <div class="form-group">
                      <label>Cargo</label>
                      <div class="form-check form-switch">
                        <input
                          type="checkbox"
                          name="cargo-switch"
                          class="form-check-input"
                          data-toggle="switchbutton"
                          checked
                          data-onlabel="Professor"
                          data-offlabel="Secretário"
                          data-onstyle="success"
                          data-offstyle="info"
                          onchange="document.getElementById('cargo').value = this.checked ? 'professor' : 'secretario'">
                      </div>
                      <input type="hidden" id="cargo" name="cargo" value="professor">
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
                    <label class="form-label" for="inputEmail4">E-mail</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="email">
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-label" for="senha">Senha</label>
                    <input
                      type="password"
                      name="senha"
                      class="form-control"
                      oninput="validarSenha()"
                      required>
                  </div>
                  <div class="form-group col-6">
                    <label class="form-label" for="inlineFormInputGroupUsername">Nome de usuário</label>
                    <div class="input-group">
                      <div class="input-group-text">@</div>
                      <input type="text" class="form-control" name="usuario" id="inlineFormInputGroupUsername" placeholder="nome de usuário">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label class="form-label" for="confirmarSenha">Confirme a senha</label>
                    <input
                      type="password"
                      name="confirmarSenha"
                      class="form-control"
                      oninput="validarSenha()"
                      required>
                    <!-- mensagem de erro -->
                    <span id="senha-error" class="text-danger"></span>
                  </div>
              </form>
            </div>
          </div>
          <button type="button" onclick="enviarCadastroEquipe()" class="btn btn-success">Salvar</button>
        </div>
      </div>
    </div>
    <!-- [ form-element ] end -->
    </div>
    <!-- [ main content ] end -->
    </div>
  </section>
  <!-- [ main content ] end -->
  <?php include '../includes/footer.php'; ?>

  <script>
    layout_change('light');
  </script>

  <script>
    change_box_container('false');
  </script>

  <script>
    layout_rtl_change('false');
  </script>

  <script>
    preset_change("preset-1");
  </script>

  <script>
    font_change("public-sans");
  </script>

  <!-- [page specific js] start -->
  <script src="../assets/js/plugins/bootstrap-switch-button.min.js"></script>
  <script>
    (function() {
      var switch_event = document.querySelector('#switch_event');

      switch_event.addEventListener('change', function() {
        if (switch_event.checked) {
          document.querySelector('#console_event').innerHTML = 'switch button checked';
        } else {
          document.querySelector('#console_event').innerHTML = 'switch button unchecked';
        }
      });
    })();
  </script>
  <!-- [page specific js] end -->
</body>
</html>