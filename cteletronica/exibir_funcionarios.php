<?php
// Conexão com o banco de dados (use PDO ou MySQLi)
require_once 'includes/db_connection.php'; // Substitua pelo caminho correto

// Receba o ID do funcionário da URL (por exemplo, exibir_funcionario.php?id=1)
$funcionario_id = $_GET['id'];

// Consulta para obter os detalhes do funcionário
$sql = "SELECT * FROM funcionarios WHERE id = :funcionario_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':funcionario_id', $funcionario_id);
$stmt->execute();
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    echo 'Funcionário não encontrado.';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Funcionário</title>
    <link rel="stylesheet" type="text/css" href="css/form-styles.css">
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
</head>
<body>
    <a class="green-button" href="lista_funcionarios.php">Voltar</a>
    <h1>Detalhes do Funcionário</h1>
    <p><strong>Nome:</strong> <?= $funcionario['nome'] ?></p>
    <p><strong>Perfil:</strong> <?= $funcionario['perfil'] ?></p>
    <!-- ... outros campos ... -->
    <p><a class="green-button" href="editar_funcionario.php?id=<?= $funcionario_id ?>">Editar Funcionário</a></p>
    
</body>
</html>
