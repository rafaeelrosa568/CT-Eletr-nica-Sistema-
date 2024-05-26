<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Verifique se o produto foi selecionado para venda
if (isset($_GET['id'])) {
    $produtoId = $_GET['id'];

    // Consulta para obter informações do produto
    $sql = "SELECT * FROM produtos WHERE id = :produtoId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lógica para finalizar a venda (atualize a tabela de vendas conforme necessário)
    // Exemplo: INSERT INTO vendas (produto_id, vendedor_id, quantidade, valor_total, comissao) VALUES (:produtoId, :vendedorId, :quantidade, :valorTotal, :comissao);
    // Lembre-se de tratar erros e exceções aqui
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Finalizar Venda</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
    <h1>Finalizar Venda</h1>
    <?php if (isset($produto)): ?>
        <p>Produto vendido:</p>
        <p>Nome: <?= $produto['nome'] ?></p>
        <p>Modelo: <?= $produto['modelo'] ?></p>
        <!-- Adicione mais informações do produto conforme necessário -->
        <!-- Exiba uma mensagem de sucesso ou redirecione para outra página após a finalização -->
    <?php else: ?>
        <p>Nenhum produto selecionado para venda.</p>
    <?php endif; ?>
</body>
</html>
