<?php
session_start();
require_once '../../data/conexao.php';


if (!isset($_SESSION['id'])) {
    header("Location: ../Frontend/pages/index.html");
    exit;
}


$id = $_GET['id'] ?? null;
$id_usuario = $_SESSION['id'];


if (!$id) {
    header("Location: ../Frontend/pages/tarefas.php?msg=erro_id");
    exit;
}

try {
    
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $id_usuario]);

    
    header("Location: ../Frontend/pages/tarefas.php?msg=sucesso_excluir");
    exit;

} catch (PDOException $e) {
    
    header("Location: ../Frontend/pages/tarefas.php?msg=erro_bd");
    exit;
}
?>
