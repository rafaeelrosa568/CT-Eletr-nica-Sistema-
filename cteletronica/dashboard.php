<?php
session_start();
require_once 'includes/db_connection.php';


if (!isset($_SESSION['perfil'])) {
    header('Location: login.php');
    exit;
}

$perfil = $_SESSION['perfil'];
$nome = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/Dashboard.css">
    <link rel="icon" href="images/faviconCT.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/faviconCT.ico" type="image/x-icon">
    
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>!</h1>
    
    <ul>
        <?php if ($perfil == 'estoquista' || $perfil == 'administrador') { ?>
            <li><a class="btn" href="cadastro_produtos.php">Cadastro de Produtos</a></li>
        <?php } ?>
        <?php if ($perfil == 'estoquista' || $perfil == 'vendedor' || $perfil == 'administrador') { ?>
            <li><a class="btn" href="lista_produtos.php">Lista de Produtos</a></li>
        <?php } ?>
        <?php if ($perfil == 'administrador') { ?>
            <li><a class="btn" href="lista_funcionarios.php" >Gerenciar Funcionários</a></li>
        <?php } ?>
        <?php if ($perfil == 'administrador') { ?>
            <li><a class="btn" href="relatorio_vendas.php">Gerenciar Vendas</a></li>
            <li><a class="btn" href="comissoes.php">Relatorio de comissoes</a></li>
            <!-- <li><a class="btn" href="lista_vendas.php">Lista de Vendas</a></li> -->
            <!-- <li><a class="btn" href="produtos_vendidos.php">Produtos Vendidos</a></li> -->
        <?php } ?>
        <?php if ($perfil == 'estoquista' || $perfil == 'administrador') { ?>
            <li><a class="btn" href="relatorio_produtos.php"> Relatório de Produtos</a></li>
        <?php } ?>
    </ul>
    
    <p><a class="btn" href="logout.php">Sair</a></p>
</body>
</html>

<?php
require_once 'includes/footer.php';
?>
