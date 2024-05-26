<?php
require_once 'includes/db_connection.php'; // Caminho para o banco de dados

// Verifica se o ID do funcionário foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Exclui o funcionário do banco de dados
    $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
    $stmt->execute([$id]);
    
    // Redireciona de volta para a página de listagem de funcionários
    header("Location: lista_funcionarios.php");
    exit(); // Termina o script para garantir que o redirecionamento ocorra
} else {
    echo "ID do funcionário não especificado.";
}
?>
