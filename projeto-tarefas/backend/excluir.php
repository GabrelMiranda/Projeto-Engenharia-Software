<?php
session_start();
require_once '../../data/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Frontend/pages/index.html");
    exit;
}

$id = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $id_usuario]);

header("Location: ../Frontend/pages/tarefas.html?msg=sucesso_excluir");
exit;
?>
