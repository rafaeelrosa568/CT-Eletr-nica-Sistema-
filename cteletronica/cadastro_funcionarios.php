<?php
session_start();

// Verifica se o usuário não está logado ou se o perfil não é administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'administrador') {
    // Redireciona para outra página se não for permitido
    header('Location: dashboard.php');
    exit;
}

require_once 'includes/db_connection.php';
require_once 'includes/menu_dashboard.php';

// Verifique se o usuário está logado
if (!isset($_SESSION['perfil'])) {
    header('Location: login.php');
    exit;
}

$perfil = $_SESSION['perfil'];



// Processamento do formulário de cadastro de funcionários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados do formulário
    $nome = $_POST['nome'];
    $perfil = $_POST['perfil']; // Pode ser 'administrador', 'vendedor' ou 'estoquista'
    $username = $_POST['username']; // Novo campo: nome de usuário
    $password = $_POST['password']; // Novo campo: senha

    // Insira os dados na tabela de funcionários
    try {
        $sql = "INSERT INTO funcionarios (nome, perfil, username, password) VALUES (:nome, :perfil, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        echo "Funcionário cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar funcionário: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Funcionários</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/form-styles.css">
</head>
<body>
<a class="green-button" href="lista_funcionarios.php">Ver Funcionário</a>
    <h1>Cadastro de Funcionários</h1>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="username" placeholder="Nome de usuário" required> <!-- Novo campo -->
        <input type="password" name="password" placeholder="Senha" required> <!-- Novo campo -->
        <select name="perfil">
            <option value="administrador">Administrador</option>
            <option value="vendedor">Vendedor</option>
            <option value="estoquista">Estoquista</option>
        </select>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
