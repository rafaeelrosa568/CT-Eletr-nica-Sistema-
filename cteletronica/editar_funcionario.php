<?php

session_start();

// Verifica se o usuário não está logado ou se o perfil não é administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'administrador') {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Obtenha o ID do funcionário da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os valores do formulário
    $nome = $_POST['nome'];
    $perfil = $_POST['perfil'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Atualize o funcionário no banco de dados
    $sql = "UPDATE funcionarios SET nome = :nome, perfil = :perfil, username = :username, password = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':perfil', $perfil);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirecione o usuário para a lista de funcionários
    header('Location: lista_funcionarios.php');
    exit;
}

// Se o ID do funcionário foi fornecido, obtenha os detalhes do funcionário
if ($id) {
    $sql = "SELECT * FROM funcionarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Funcionário</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/form-styles.css"> <!-- Substitua pelo caminho correto -->
</head>
<body>
<a class="green-button" href="lista_funcionarios.php">Voltar</a>
    <h1>Editar Funcionário</h1>
    <form method="post">
        EDITAR NOME
        <input type="text" name="nome" placeholder="Nome" value="<?= $funcionario['nome'] ?>" required>
        MUDAR O PERFIL
        <select name="perfil" required>
            <option value="administrador" <?= ($funcionario['perfil'] == 'administrador') ? 'selected' : '' ?>>Administrador</option>
            <option value="vendedor" <?= ($funcionario['perfil'] == 'vendedor') ? 'selected' : '' ?>>Vendedor</option>
            <option value="estoquista" <?= ($funcionario['perfil'] == 'estoquista') ? 'selected' : '' ?>>Estoquista</option>
        </select>
        EDITAR LOGIN
        <input type="text" name="username" placeholder="Nome de Usuário" value="<?= $funcionario['username'] ?>" required>
        EDITAR SENHA
        <input type="password" name="password" placeholder="Senha" value="<?= $funcionario['password'] ?>" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
