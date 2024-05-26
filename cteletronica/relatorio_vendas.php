<?php
session_start();
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto
include 'includes/menu_dashboard.php';

if ($_SESSION['perfil'] !== 'administrador') {
    header('Location: dashboard.php');
    exit;
}

// Consulta para obter todas as vendas
$sql = "SELECT v.*, p.nome AS nome_produto, f.nome AS nome_vendedor
        FROM vendas v
        INNER JOIN produtos p ON v.produto_id = p.id
        INNER JOIN funcionarios f ON v.vendedor_id = f.id
        ORDER BY v.data_venda DESC"; // Ordena por data de venda (mais recente primeiro)
$stmt = $pdo->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Vendas</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
<a class="green-button" href="produtos_vendidos.php">Ver Produtos Vendidos</a>
<a class="green-button" href="lista_vendas.php">Ver Listas de Vendas</a>
    <h1>Relatório de Vendas</h1>
    <table>
        <tr>
            <th>Data</th>
            <th>Produto</th>
            <th>Vendedor</th>
            <th>Quantidade</th>
            <th>Valor Total</th>
            <th>Comissão</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><?= htmlspecialchars($venda['data_venda'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($venda['nome_produto'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($venda['nome_vendedor'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($venda['quantidade'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($venda['comissao'], 2, ',', '.') ?></td>
                <td>
                    <a href="cancelar_venda.php?id=<?= $venda['id'] ?>" class="button">Cancelar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
