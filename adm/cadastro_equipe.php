

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
        <?php include '../includes/sidebar_menu.php'; ?>
    <!-- [ Sidebar Menu ] end --> 

    <!-- [ Header Topbar ] start -->
        <?php include '../includes/header_topbar.php'; ?>
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
                <li class="breadcrumb-item" aria-current="page">Cadastros Equipe</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Cadastrar Novo</h2>
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
                    <button type="button" class="btn btn-success" onclick="enviarCadastro()">Cadastrar</button>
                    
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
            <button type="submit" onclick="enviarCadastro()" class="btn btn-success">Salvar</button>
            
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