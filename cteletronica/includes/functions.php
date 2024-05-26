<?php
function checkUserLoggedIn() {
    // Verifique se o usuário está logado
if (!isset($_SESSION['perfil'])) {
    header('Location: login.php');
    exit;
 }
}
?>
