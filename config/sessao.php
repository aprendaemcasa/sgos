<?php

// Iniciar a sessão do usuário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se existe um usuário conectado
function verificarLogin()
{
    if (!isset($_SESSION["usuario_id"])) {

        header("Location: /sgos/login.php");

        exit;
    }
}

?>