<?php
session_start();
require_once '../../data/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Frontend/pages/login.html");
    exit;
}

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$categoria = $_POST['categoria'];
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("UPDATE tarefas SET titulo = ?, categoria = ? WHERE id = ? AND id_usuario = ?");
$stmt->execute([$titulo, $categoria, $id, $id_usuario]);

header("Location: ../Frontend/pages/tarefas.html");
?>
