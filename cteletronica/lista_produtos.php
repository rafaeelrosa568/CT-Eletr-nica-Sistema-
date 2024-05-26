<?php
session_start();

// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto
include 'includes/menu_dashboard.php';



// Consulta para obter todos os produtos
$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$perfil = $_SESSION['perfil']; // Obtém o perfil do usuário logado
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
    <link rel="stylesheet" type="text/css" href="css/list-styles.css">
    
		<link rel="icon" type="image/x-icon" href="img/faviconCT.ico">
    
</head>
<body>
    <a class="green-button" href="cadastro_produtos.php">Cadastrar Produtos</a>
    <h1>Lista de Produtos</h1>
    <p></p>
    <table>
        <tr>
            <th>Nome</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($produto['modelo'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($produto['marca'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($produto['quantidade'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></td>
                <td>
                    <?php if ($perfil == 'administrador' || $perfil == 'estoquista'): ?>
                        <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="button">Editar</a>
                        <a href="excluir_produto.php?id=<?= $produto['id'] ?>" class="button">Excluir</a>
                    <?php endif; ?>
                    <a href="exibir_produto.php?id=<?= $produto['id'] ?>" class="button">Exibir</a>
                    <?php if ($perfil == 'administrador' || $perfil == 'vendedor'): ?>
                        <a href="processar_venda.php?id=<?= $produto['id'] ?>" class="button">Vender</a>
                    <?php endif; ?>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
