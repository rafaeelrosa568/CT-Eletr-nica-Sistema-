<?php
session_start();
require_once 'includes/db_connection.php';

if ($_SESSION['perfil'] !== 'administrador') {
    header('Location: dashboard.php');
    exit;
}

if (isset($_GET['id'])) {
    $venda_id = intval($_GET['id']);

    // Obter detalhes da venda
    $sql = "SELECT * FROM vendas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $venda_id]);
    $venda = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($venda) {
        // Obter detalhes do produto
        $sql = "SELECT * FROM produtos WHERE id = :produto_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['produto_id' => $venda['produto_id']]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Atualizar a quantidade do produto
            $nova_quantidade = $produto['quantidade'] + $venda['quantidade'];
            $sql = "UPDATE produtos SET quantidade = :quantidade WHERE id = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['quantidade' => $nova_quantidade, 'produto_id' => $produto['id']]);

            // Deletar a venda
            $sql = "DELETE FROM vendas WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $venda_id]);

            header("Location: relatorio_vendas.php?status=success");
            exit();
        }
    }
}
header("Location: relatorio_vendas.php?status=error");
exit();
?>
