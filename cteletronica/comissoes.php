<?php


session_start();

// Verifica se o usuário não está logado ou se o perfil não é administrador (Restringir acessos para perfis especificos)
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'administrador') {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

require_once 'includes/db_connection.php'; // Substitua pelo caminho correto
// Consulta para obter todas as vendas com detalhes do vendedor
$sql = "SELECT v.*, f.nome AS vendedor_nome, v.comissao FROM vendas v
        INNER JOIN funcionarios f ON v.vendedor_id = f.id";
$stmt = $pdo->query($sql);
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comissões</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
<a class="green-button" href="dashboard.php">Voltar</a>
    <h1>Comissões</h1>
    <table>
        <tr>
            <th>Vendedor</th>
            <th>Valor Total</th>
            <th>Comissão</th>
        </tr>
        <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><?= $venda['vendedor_nome'] ?></td>
                <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($venda['comissao'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
