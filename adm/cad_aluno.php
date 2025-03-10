<?php
// Conecta ao banco
include '../includes/db.php';

// Recebe e sanitiza dados
$dados = [
  'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
  'data_nascimento' => filter_input(INPUT_POST, 'data_nascimento'),
  'nacionalidade' => filter_input(INPUT_POST, 'nacionalidade', FILTER_SANITIZE_STRING),
  'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf']),
  'rg' => filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING),
  'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
  'usuario' => filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING),
  'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
  'endereco' => filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING),
  'complemento' => filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING),
  'cidade' => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING),
  'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING),
  'cep' => preg_replace('/[^0-9]/', '', $_POST['cep'])
];

// Validações
if (!$dados['email']) {
  echo json_encode(['sucesso' => false, 'erro' => 'E-mail inválido']);
  exit;
}

if (strlen($dados['cpf']) !== 11) {
  echo json_encode(['sucesso' => false, 'erro' => 'CPF inválido']);
  exit;
}

// Insere no banco
try {
  $stmt = $pdo->prepare("
    INSERT INTO alunos (
      nome, data_nascimento, nacionalidade, cpf, rg, email, usuario, senha,
      endereco, complemento, cidade, estado, cep
    ) VALUES (
      :nome, :data_nascimento, :nacionalidade, :cpf, :rg, :email, :usuario,
      :senha, :endereco, :complemento, :cidade, :estado, :cep
    )
  ");

  $stmt->execute($dados);
  echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
  echo json_encode(['sucesso' => false, 'erro' => 'Erro no banco: ' . $e->getMessage()]);
}
?>