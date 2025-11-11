<?php
session_start();
require_once '../../data/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['id'] = $user['id'];
    header("Location: ../Frontend/pages/tarefas.php");
    exit;
} else {
    header("Location: ../Frontend/pages/index.html?erro=1");
    exit;
}
?>
