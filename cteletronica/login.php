<?php
session_start();
require_once 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, nome, perfil FROM funcionarios WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['perfil'] = $user['perfil'];
        header('Location: dashboard.php');
        exit;
    } else {
        echo 'Credenciais inválidas.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/Dashboard.css">
</head>
<body>
    <h2> CT ELETRÔNICA </h2>
    <H3> Entre com suas credenciais para acessar o sistema</h3>
    <h1>Login</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>

<?php
require_once 'includes/footer.php';
?>
