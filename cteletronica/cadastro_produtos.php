<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php';

require_once 'includes/menu_dashboard.php';

// Processamento do formulário de cadastro de produtos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados do formulário
    $nome = $_POST['nome'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    // Insira os dados na tabela de produtos
    try {
        $sql = "INSERT INTO produtos (nome, modelo, marca, tipo, quantidade, descricao, valor) VALUES (:nome, :modelo, :marca, :tipo, :quantidade, :descricao, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();

        echo "Produto cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar produto: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Produtos</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/form-styles.css">
</head>
<body>
    <h1>Cadastro de Produtos</h1>
    <a class="green-button" href="lista_produtos.php">Ver Produtos</a>
    <form method="post">
        NOME DO PRODUTO
        <input type="text" name="nome" placeholder="Nome" required>
        MODELO DO PRODUTO
        <input type="text" name="modelo" placeholder="Modelo" required>
        MARCA
        <input type="text" name="marca" placeholder="Marca" required>
        TIPO DE PRODUTO
        <input type="text" name="tipo" placeholder="Tipo" required>
        QUANTIDADE
        <p>
        <input type="number" name="quantidade" placeholder="Quantidade" required>
        </p>
        DESCRIÇÃO DO PRODUTO
        
        <textarea name="descricao" placeholder="Descrição"></textarea>
        VALOR
        <input type="number" name="valor" step="0.01" placeholder="Valor" required>
        <p>
        <button type="submit">Cadastrar</button>
        </p>
    </form>
</body>
</html>
