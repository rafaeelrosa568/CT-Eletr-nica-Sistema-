<?php
echo '<header>';
if (isset($_SESSION['nome'])) {
    echo '<h1>Bem-vindo, ' . $_SESSION['nome'] . '</h1>';
} else {
    echo '<h1>Bem-vindo ao Meu Site</h1>';
}
echo '</header>';
?>
