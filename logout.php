<?php

// Iniciar a sessão
require_once "config/sessao.php";

// Apagar todos os dados da sessão
$_SESSION = [];

// Destruir a sessão
session_destroy();

// Voltar para a tela de login
header("Location: login.php");

exit;

?>