<?php
session_start();
require_once '../../data/conexao.php'; 


if (!isset($_SESSION['id'])) {
    header("Location: ../Frontend/pages/index.html");
    exit;
}


$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');
$status = strtolower(trim($_POST['status'] ?? 'pendente')); 
$id_usuario = $_SESSION['id'];


if (empty($titulo) || empty($categoria)) {
    header("Location: ../Frontend/pages/tarefas.php?msg=erro_campos_vazios");
    exit;
}

try {
   
    $stmt = $pdo->prepare("
        INSERT INTO tarefas (usuario_id, titulo, descricao, categoria, status)
        VALUES (:usuario_id, :titulo, :descricao, :categoria, :status)
    ");
    $stmt->execute([
        ':usuario_id' => $id_usuario,
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':categoria' => $categoria,
        ':status' => $status
    ]);

   
    header("Location: ../Frontend/pages/tarefas.php?msg=sucesso_adicionar");
    exit;

} catch (PDOException $e) {
    
    header("Location: ../Frontend/pages/tarefas.php?msg=erro_bd");
    exit;
}
?>
