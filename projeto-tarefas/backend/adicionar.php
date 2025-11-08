<?php
session_start();
require_once '../../data/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Frontend/pages/index.html");
    exit;
}

$titulo = $_POST['titulo'];
$categoria = $_POST['categoria'];
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("INSERT INTO tarefas (id_usuario, titulo, categoria) VALUES (?, ?, ?)");
$stmt->execute([$id_usuario, $titulo, $categoria]);

header("Location: ../Frontend/pages/tarefas.html?msg=sucesso_adicionar");
exit;
?>
