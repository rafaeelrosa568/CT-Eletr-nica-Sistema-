<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Obtenha o ID do produto da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Se o ID do produto foi fornecido
if ($id) {
    // Verifique se há vendas relacionadas a este produto
    $sql_verificar_vendas = "SELECT * FROM vendas WHERE produto_id = :produto_id";
    $stmt_verificar_vendas = $pdo->prepare($sql_verificar_vendas);
    $stmt_verificar_vendas->bindParam(':produto_id', $id);
    $stmt_verificar_vendas->execute();
    $vendas_relacionadas = $stmt_verificar_vendas->fetch(PDO::FETCH_ASSOC);

    // Se houver vendas relacionadas, exclua-as primeiro
    if ($vendas_relacionadas) {
        $sql_excluir_vendas = "DELETE FROM vendas WHERE produto_id = :produto_id";
        $stmt_excluir_vendas = $pdo->prepare($sql_excluir_vendas);
        $stmt_excluir_vendas->bindParam(':produto_id', $id);
        $stmt_excluir_vendas->execute();
    }

    // Exclua o produto
    $sql_excluir_produto = "DELETE FROM produtos WHERE id = :id";
    $stmt_excluir_produto = $pdo->prepare($sql_excluir_produto);
    $stmt_excluir_produto->bindParam(':id', $id);
    $stmt_excluir_produto->execute();
}

// Redirecione o usuário para a lista de produtos
header('Location: lista_produtos.php');
exit;
?>
