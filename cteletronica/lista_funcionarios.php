<?php
session_start();

// Verifica se o usuário não está logado ou se o perfil não é administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'administrador') {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

require_once 'includes/db_connection.php'; // Caminho para o banco de dados
require_once 'includes/menu_dashboard.php'; // inclusão do botão inicio para o menu principal

// Consulta para obter todos os funcionários
$sql = "SELECT * FROM funcionarios";
$stmt = $pdo->query($sql);
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Funcionários</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
    <a class="green-button" href="cadastro_funcionarios.php">Cadastrar Funcionário</a>
    <h1>Lista de Funcionários</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Perfil</th>
            <th>Ações</th> <!-- Nova coluna para as ações -->
        </tr>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr>
                <td><?= $funcionario['nome'] ?></td>
                <td><?= $funcionario['perfil'] ?></td>
                <td>
                    <!-- Botões de editar, exibir e excluir -->
                    <a href="editar_funcionario.php?id=<?= $funcionario['id'] ?>" class="button">Editar</a>
                    <a href="excluir_funcionario.php?id=<?= $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')" class="button">Excluir</a>
                    <a href="exibir_funcionarios.php?id=<?= $funcionario['id'] ?>" class="button">Exibir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
