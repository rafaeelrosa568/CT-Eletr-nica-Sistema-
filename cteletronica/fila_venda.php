<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Verifique se o produto foi selecionado para venda
if (isset($_GET['id'])) {
    $produtoId = $_GET['id'];

    // Consulta para obter informações do produto
    $sqlProduto = "SELECT * FROM produtos WHERE id = :produtoId";
    $stmtProduto = $pdo->prepare($sqlProduto);
    $stmtProduto->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtProduto->execute();
    $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        // Lógica para finalizar a venda (atualize a tabela de vendas conforme necessário)
        $vendedorId = 1; // Defina o ID do vendedor (ou obtenha dinamicamente)
        $quantidade = 1; // Defina a quantidade vendida (ou obtenha dinamicamente)
        $valorTotal = $produto['valor'] * $quantidade;
        $comissao = $valorTotal * 0.1; // Exemplo: 10% de comissão

        $sqlVenda = "INSERT INTO vendas (produto_id, vendedor_id, quantidade, valor_total, comissao)
                     VALUES (:produtoId, :vendedorId, :quantidade, :valorTotal, :comissao)";
        $stmtVenda = $pdo->prepare($sqlVenda);
        $stmtVenda->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
        $stmtVenda->bindParam(':vendedorId', $vendedorId, PDO::PARAM_INT);
        $stmtVenda->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmtVenda->bindParam(':valorTotal', $valorTotal, PDO::PARAM_STR);
        $stmtVenda->bindParam(':comissao', $comissao, PDO::PARAM_STR);
        $stmtVenda->execute();

         // Lógica para remover a referência do produto na tabela de vendas
    $sqlRemoverReferencia = "UPDATE vendas SET produto_id = NULL WHERE produto_id = :produtoId";
    $stmtRemoverReferencia = $pdo->prepare($sqlRemoverReferencia);
    $stmtRemoverReferencia->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtRemoverReferencia->execute();


    // Lógica para remover o produto da tabela de produtos (você precisa criar a tabela 'produtos_vendidos')
        // Exemplo: DELETE FROM produtos WHERE id = :produtoId;
        // Lembre-se de tratar erros e exceções aqui
        $sqlRemoverProduto = "DELETE FROM produtos WHERE id = :produtoId";
    $stmtRemoverProduto = $pdo->prepare($sqlRemoverProduto);
    $stmtRemoverProduto->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtRemoverProduto->execute();

        // Redirecione para a página de relatório de vendas após a finalização
        header('Location: relatorio_vendas.php');
        exit;
    }
}
?>
<!-- Restante do código HTML permanece o mesmo -->


<!DOCTYPE html>
<html>
<head>
    <title>Fila de Venda</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
</head>
<body>
    <h1>Fila de Venda</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        <?php if (isset($produto)): ?>
            <tr>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['modelo'] ?></td>
                <td><?= $produto['marca'] ?></td>
                <td><?= $produto['quantidade'] ?></td>
                <td>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></td>
                <td>
                    <!-- Botão para finalizar a venda -->
                    <a href="finalizar_venda.php?id=<?= $produto['id'] ?>" class="button">Finalizar Venda</a>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
