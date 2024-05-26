<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto


// Receba o ID do produto da URL (por exemplo, exibir_produto.php?id=1)
$produto_id = $_GET['id'];

// Consulta para obter os detalhes do produto
$sql = "SELECT * FROM produtos WHERE id = :produto_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':produto_id', $produto_id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo 'Produto não encontrado.';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Produto</title>
    <link rel="stylesheet" type="text/css" href="css/form-styles.css">
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
</head>
<body>
<a class="green-button" href="lista_produtos.php">Voltar</a>
    <h1>Detalhes do Produto</h1>
    <p><strong>Nome:</strong> <?= $produto['nome'] ?></p>
    <p><strong>Modelo:</strong> <?= $produto['modelo'] ?></p>
    <!-- ... outros campos ... -->
    
    

    <p><a class="green-button" href="editar_produto.php?id=<?= $produto_id ?>">Editar Produto</a></p>
</body>
</html>
