<?php
session_start();
require_once '../../data/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Frontend/pages/login.html");
    exit;
}

$id = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $id_usuario]);
$tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($tarefa);
?>
