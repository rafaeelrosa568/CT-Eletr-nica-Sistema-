<?php
session_start();

// Destrua todas as variáveis de sessão
$_SESSION = array();

// Se você deseja destruir completamente a sessão, remova também
// o cookie de sessão. Isso irá destruir a sessão e não apenas os dados da sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrua a sessão.
session_destroy();

// Redirecione o usuário para a página de login
header("Location: login.php");
exit;
?>
