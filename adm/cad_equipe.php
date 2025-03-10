<?php
include '../includes/db.php';

// Recebe os dados
$dados = [
  'nome' => $_POST['nome'],
  'data_nascimento' => $_POST['data_nascimento'],
  'nacionalidade' => $_POST['nacionalidade'],
  'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf']),
  'email' => $_POST['email'],
  'usuario' => $_POST['usuario'],
  'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
  'cargo' => $_POST['cargo']
];

// Valida CPF único
$stmt = $pdo->prepare("SELECT id FROM equipe_escolar WHERE cpf = ?");
$stmt->execute([$dados['cpf']]);
if ($stmt->rowCount() > 0) {
  echo json_encode(['sucesso' => false, 'erro' => 'CPF já cadastrado']);
  exit;
}

// Insere no banco
try {
  $sql = "INSERT INTO equipe_escolar (
    nome, data_nascimento, nacionalidade, cpf, email, usuario, senha, cargo
  ) VALUES (
    :nome, :data_nascimento, :nacionalidade, :cpf, :email, :usuario, :senha, :cargo
  )";
  
  $pdo->prepare($sql)->execute($dados);
  echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
  echo json_encode(['sucesso' => false, 'erro' => 'Erro: ' . $e->getMessage()]);
}
?>