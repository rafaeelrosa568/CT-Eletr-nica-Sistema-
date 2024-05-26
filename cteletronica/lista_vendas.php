<?php
session_start();
require_once 'includes/db_connection.php';
include 'includes/menu_dashboard.php';

if ($_SESSION['perfil'] !== 'administrador') {
    header('Location: dashboard.php');
    exit;
}

// Consulta para obter todas as vendas com detalhes do vendedor e do produto
$sql = "SELECT v.*, f.nome AS vendedor_nome, p.nome AS produto_nome
        FROM vendas v
        INNER JOIN funcionarios f ON v.vendedor_id = f.id
        INNER JOIN produtos p ON v.produto_id = p.id";
$stmt = $pdo->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Vendas</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
<a class="green-button" href="relatorio_vendas.php">Ver Relatório</a>
    <h1>Lista de Vendas</h1>
    <table>
        <tr>
            <th>Vendedor</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Total</th>
            <!-- ... outros campos ... -->
        </tr>
        <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><?= $venda['vendedor_nome'] ?></td>
                <td><?= $venda['produto_nome'] ?></td>
                <td><?= $venda['quantidade'] ?></td>
                <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                <!-- ... outros campos ... -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
