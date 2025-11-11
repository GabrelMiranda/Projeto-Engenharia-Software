<?php
session_start();
require_once '../../data/conexao.php';


if (!isset($_SESSION['id'])) {
    header("Location: index.html");
    exit;
}

$id_usuario = $_SESSION['id'];
$id = $_GET['id'] ?? null;


if (!$id) {
    header("Location: ../Frontend/pages/tarefas.php?msg=erro_id");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $categoria = trim($_POST['categoria']);
    $status = trim($_POST['status']);

    try {
        $stmt = $pdo->prepare("
            UPDATE tarefas 
            SET titulo = ?, descricao = ?, categoria = ?, status = ?
            WHERE id = ? AND usuario_id = ?
        ");
        $stmt->execute([$titulo, $descricao, $categoria, $status, $id, $id_usuario]);

       
        header("Location: ../Frontend/pages/tarefas.php");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar tarefa: " . $e->getMessage());
    }
}


try {
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $id_usuario]);
    $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tarefa) {
        header("Location: ../Frontend/pages/tarefas.php?msg=erro_tarefa_nao_encontrada");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao carregar tarefa: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="../Frontend/css/editar.css">
</head>

<body>
    <header class="header">
        <h1>Editar Tarefa</h1>
        <button class="voltar-btn" onclick="window.location.href='../Frontend/pages/tarefas.php'">← Voltar</button>
    </header>

    <main class="main-content">
        <form class="task-form" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($tarefa['id']) ?>">

            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>

            <label for="categoria">Categoria</label>
            <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($tarefa['categoria']) ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="pendente" <?= $tarefa['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="em andamento" <?= $tarefa['status'] === 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                <option value="concluida" <?= $tarefa['status'] === 'concluida' ? 'selected' : '' ?>>Concluída</option>
            </select>

            <div class="buttons">
                <button type="submit" class="btn salvar">Salvar Alterações</button>
                <button type="button" class="btn cancelar" onclick="window.location.href='../Frontend/pages/tarefas.php'">Cancelar</button>
            </div>
        </form>
    </main>
</body>
</html>
