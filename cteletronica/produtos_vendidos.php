<?php

session_start();

// Verifica se o usuário não está logado ou se o perfil não é nem administrador nem estoquista
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] !== 'administrador' && $_SESSION['perfil'] !== 'estoquista')) {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto
include 'includes/menu_dashboard.php';



// Consulta para obter os produtos vendidos (sem repetições)
$sql = "SELECT DISTINCT p.nome AS nome_produto
        FROM vendas v
        INNER JOIN produtos p ON v.produto_id = p.id";
$stmt = $pdo->query($sql);
$produtosVendidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produtos Vendidos</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
<a class="green-button" href="relatorio_vendas.php">Voltar Relatorio Vendas</a>
    <h1>Produtos Vendidos</h1>
    <ul>
        <?php foreach ($produtosVendidos as $produto): ?>
            <li><?= $produto['nome_produto'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
