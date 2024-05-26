<?php
session_start();

// Verifica se o usuário não está logado ou se o perfil não é nem administrador nem estoquista
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] !== 'administrador' && $_SESSION['perfil'] !== 'estoquista')) {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Obtenha o ID do produto da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os valores do formulário
    $nome = $_POST['nome'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    // Atualize o produto no banco de dados
    $sql = "UPDATE produtos SET nome = :nome, modelo = :modelo, marca = :marca, quantidade = :quantidade, valor = :valor WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirecione o usuário para a lista de produtos
    header('Location: lista_produtos.php');
    exit;
}

// Se o ID do produto foi fornecido, obtenha os detalhes do produto
if ($id) {
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/form-styles.css">
</head>
<body>
<a class="green-button" href="lista_produtos.php">Voltar</a>
    <h1>Editar Produto</h1>
    <form method="post">
        EDITAR NOME DO PRODUTO
        <input type="text" name="nome" placeholder="Nome" value="<?= $produto['nome'] ?>" required>
        EDITAR MODELO
        <input type="text" name="modelo" placeholder="Modelo" value="<?= $produto['modelo'] ?>" required>
        EDITAR MARCA
        <input type="text" name="marca" placeholder="Marca" value="<?= $produto['marca'] ?>" required>
        <p>
        EDITAR A QUANTIDADE
        <input type="number" name="quantidade" placeholder="Quantidade" value="<?= $produto['quantidade'] ?>" required>
        </p>
        EDITAR O VALOR
        <input type="number" step="0.01" name="valor" placeholder="Valor" value="<?= $produto['valor'] ?>" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
