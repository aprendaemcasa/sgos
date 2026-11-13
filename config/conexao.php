<?php

$servidor = "localhost";
$banco = "sgos";
$usuario = "root";
$senha = "";

try {

    $conexao = new PDO(
        "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    $conexao->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $erro) {

    die("Erro na conexão: " . $erro->getMessage());

}

?>
