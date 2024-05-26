<?php
session_start();
require_once 'includes/db_connection.php'; // Certifique-se de que o caminho está correto

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $produto_id = intval($_GET['id']);
    $vendedor_id = $_SESSION['user_id']; // Pega o ID do vendedor da sessão
    $quantidade = 1; // Quantidade vendida. Você pode ajustar conforme necessário.

    // Obter detalhes do produto
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto && $produto['quantidade'] >= $quantidade) {
        // Calcular o valor total da venda e a comissão (ajuste a comissão conforme necessário)
        $valor_total = $produto['valor'] * $quantidade;
        $comissao = $valor_total * 0.10; // 10% de comissão, por exemplo

        // Inserir a venda na tabela 'vendas'
        $sql = "INSERT INTO vendas (produto_id, vendedor_id, quantidade, valor_total, comissao) 
                VALUES (:produto_id, :vendedor_id, :quantidade, :valor_total, :comissao)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'produto_id' => $produto_id,
            'vendedor_id' => $vendedor_id,
            'quantidade' => $quantidade,
            'valor_total' => $valor_total,
            'comissao' => $comissao
        ]);

        // Atualizar a quantidade do produto
        $nova_quantidade = $produto['quantidade'] - $quantidade;
        $sql = "UPDATE produtos SET quantidade = :quantidade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['quantidade' => $nova_quantidade, 'id' => $produto_id]);

        // Redirecionar de volta para a lista de produtos com uma mensagem de sucesso
        header("Location: lista_produtos.php?status=success");
        exit();
    } else {
        // Redirecionar de volta com uma mensagem de erro se o produto não for encontrado ou a quantidade for insuficiente
        header("Location: lista_produtos.php?status=error");
        exit();
    }
} else {
    // Redirecionar de volta se o ID do produto não for fornecido
    header("Location: lista_produtos.php?status=error");
    exit();
}
?>
