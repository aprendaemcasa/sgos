<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once "../config/conexao.php";

// Receber os dados do formulário
$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);

// Validar os campos
if ($nome === "" || $valor === false || $valor === null || $valor < 0) {
    die("Preencha corretamente os campos obrigatórios.");
}

// Preparar o comando SQL
$sql = "INSERT INTO servicos (nome, descricao, valor)
        VALUES (:nome, :descricao, :valor)";

// Executar o cadastro
$comando = $conexao->prepare($sql);

$comando->execute([
    ":nome" => $nome,
    ":descricao" => $descricao,
    ":valor" => $valor
]);

echo "Serviço cadastrado com sucesso!";

echo "<br><br>";

echo '<a href="cadastrar.php">Cadastrar outro serviço</a>';

echo "<br><br>";

echo '<a href="../index.php">Voltar ao início</a>';

?>