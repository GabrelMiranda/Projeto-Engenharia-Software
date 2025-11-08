<?php
session_start();
require_once '../../data/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_nome'] = $user['nome'];
    header("Location: ../Frontend/pages/tarefas.html");
    exit;
} else {
    header("Location: ../Frontend/pages/login.html?erro=1");
    exit;
}
?>
