<?php
session_start();
require_once '../../../data/conexao.php';


if (!isset($_SESSION['id'])) {
    header("Location: ../pages/index.html");
    exit;
}

$id_usuario = $_SESSION['id'];
$filtro = $_GET['filtro'] ?? 'todas';


$sql = "SELECT * FROM tarefas WHERE usuario_id = :usuario_id";
$params = [':usuario_id' => $id_usuario];

if ($filtro !== 'todas') {
    $sql .= " AND status = :status";
    $params[':status'] = $filtro;
}

$sql .= " ORDER BY data_criacao DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar tarefas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minhas Tarefas</title>
    <link rel="stylesheet" href="../css/tarefas.css">
</head>

<body>

   
    <header class="header">
        <h1>Minhas Tarefas</h1>
        <button class="logout-btn" onclick="window.location.href='../../backend/logout.php'">Sair</button>
    </header>

    <main class="main-content">

        
        <div class="filter">
            <form method="GET" action="tarefas.php">
                <label for="filtro">Filtrar por status:</label>
                <select name="filtro" id="filtro" onchange="this.form.submit()">
                    <option value="todas" <?= $filtro === 'todas' ? 'selected' : '' ?>>Todas</option>
                    <option value="pendente" <?= $filtro === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="em andamento" <?= $filtro === 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                    <option value="concluida" <?= $filtro === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                </select>
            </form>
        </div>

        
        <div id="mensagem" style="text-align:center; margin-bottom:10px;">
            <?php
            if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                $texto = '';
                $cor = 'green';

                switch ($msg) {
                    case 'sucesso_adicionar':
                        $texto = 'Tarefa adicionada com sucesso!';
                        break;
                    case 'sucesso_editar':
                        $texto = 'Tarefa atualizada com sucesso!';
                        break;
                    case 'sucesso_excluir':
                        $texto = 'Tarefa excluída!';
                        $cor = 'red';
                        break;
                    case 'sucesso_concluir':
                        $texto = 'Tarefa marcada como concluída!';
                        break;
                }

                if ($texto) {
                    echo "<p style='color:{$cor}; font-weight:500;'>{$texto}</p>";
                }
            }
            ?>
        </div>

       
        <ul id="lista-tarefas" class="task-list">
            <?php if (count($tarefas) > 0): ?>
                <?php foreach ($tarefas as $t): ?>
                    <li class="task-item <?= $t['status'] === 'concluida' ? 'concluida' : '' ?>">
                        <div class="task-info">
                            <h3><?= htmlspecialchars($t['titulo']) ?></h3>
                            <?php if (!empty($t['descricao'])): ?>
                                <p><?= htmlspecialchars($t['descricao']) ?></p>
                            <?php endif; ?>
                            <small><strong>Categoria:</strong> <?= htmlspecialchars($t['categoria']) ?></small><br>
                            <small><strong>Status:</strong> <?= ucfirst($t['status']) ?></small>
                        </div>
                        <div class="task-actions">
                            <button class="btn-small" onclick="window.location.href='../../backend/editar.php?id=<?= $t['id'] ?>'">✏️</button>
                            <?php if ($t['status'] !== 'concluida'): ?>
                                <button class="btn-small" onclick="window.location.href='../../backend/concluida.php?id=<?= $t['id'] ?>'">✅</button>
                            <?php endif; ?>
                            <button class="btn-small" onclick="window.location.href='../../backend/excluir.php?id=<?= $t['id'] ?>'">❌</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;">Nenhuma tarefa encontrada 😴</p>
            <?php endif; ?>
        </ul>

    </main>


    <button class="add-btn" onclick="window.location.href='adicionar.html'">+</button>

</body>

</html>
