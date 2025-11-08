<?php
require_once '../../data/conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senha]);
    header("Location: ../Frontend/pages/index.html?sucesso=1");
} catch (PDOException $e) {
    header("Location: ../Frontend/pages/index.html?erro=email");

}
?>
