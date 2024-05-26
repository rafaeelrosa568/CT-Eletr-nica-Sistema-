<?php
require_once 'includes/db_connection.php'; // Caminho para o banco de dados

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID do funcionário foi enviado
    if (isset($_POST['id'])) {
        // Obtém os dados do formulário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $perfil = $_POST['perfil'];
        
        // Atualiza as informações do funcionário no banco de dados
        $stmt = $pdo->prepare("UPDATE funcionarios SET nome = ?, perfil = ? WHERE id = ?");
        $stmt->execute([$nome, $perfil, $id]);
        
        // Redireciona de volta para a página de listagem de funcionários
        header("Location: lista_funcionarios.php");
        exit(); // Termina o script para garantir que o redirecionamento ocorra
    } else {
        echo "ID do funcionário não especificado.";
    }
} else {
    // Se os dados do formulário não foram enviados via POST, exibe uma mensagem de erro
    echo "Erro: O formulário não foi submetido corretamente.";
}
?>
