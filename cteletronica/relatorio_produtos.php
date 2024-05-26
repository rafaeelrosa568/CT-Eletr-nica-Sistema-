<?php
session_start();

// Verifica se o usuário não está logado ou se o perfil não é nem administrador nem estoquista
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] !== 'administrador' && $_SESSION['perfil'] !== 'estoquista')) {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

require_once 'includes/db_connection.php'; // Conexão com banco de dados
require_once 'includes/menu_dashboard.php';

// Consulta para obter todos os produtos
$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Produtos</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
<a class="green-button" href="cadastro_produtos.php">Cadastrar Produtos</a>
<a class="green-button" href="lista_produtos.php">Ver Produtos</a>
    <h1>Relatório de Produtos</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Modelo</th>
            <th>valor</th>
            <!-- ... outros campos ... -->
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['modelo'] ?></td>
                <td><?= $produto['valor'] ?></td>
                <!-- ... outros campos ... -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
