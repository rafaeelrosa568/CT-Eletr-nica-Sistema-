<?php
// Arquivo: includes/db_connection.php

// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$dbname = 'controle_estoque'; // Nome do banco de dados
$username = 'root'; // Nome de usuário do banco de dados (root)
$password = ''; // Senha do banco de dados (em branco)

try {
    // Criação da conexão usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configurações adicionais (opcional)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Tratamento de erros
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Modo de busca padrão

    // Agora você pode usar a variável $pdo para executar consultas no banco de dados
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
