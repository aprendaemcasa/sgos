<?php

require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$nome = trim($_POST["nome"] ?? "");
$telefone = trim($_POST["telefone"] ?? "");
$email = trim($_POST["email"] ?? "");
$endereco = trim($_POST["endereco"] ?? "");

// Verificar os campos obrigatórios
if (!$id || $nome === "" || $telefone === "") {
    die("Preencha corretamente os campos obrigatórios.");
}

// Atualizar os dados do cliente
$sql = "UPDATE clientes
        SET nome = :nome,
            telefone = :telefone,
            email = :email,
            endereco = :endereco
        WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":nome" => $nome,
    ":telefone" => $telefone,
    ":email" => $email,
    ":endereco" => $endereco,
    ":id" => $id
]);

echo "Cliente atualizado com sucesso!";

echo "<br><br>";

echo '<a href="listar.php">Voltar para a lista de clientes</a>';

?>