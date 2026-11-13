<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$nome = $_POST["nome"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];
$endereco = $_POST["endereco"];

// Preparar o comando SQL
$sql = "INSERT INTO clientes (nome, telefone, email, endereco)
        VALUES (:nome, :telefone, :email, :endereco)";

// Preparar e executar a consulta
$comando = $conexao->prepare($sql);

$comando->execute([
    ":nome" => $nome,
    ":telefone" => $telefone,
    ":email" => $email,
    ":endereco" => $endereco
]);

echo "Cliente cadastrado com sucesso!";

echo "<br><br>";

echo '<a href="cadastrar.php">Cadastrar outro cliente</a>';

echo "<br><br>";

echo '<a href="../index.php">Voltar ao início</a>';

?>