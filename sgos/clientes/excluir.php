<?php

require_once "../config/conexao.php";

// Verificar se o ID foi enviado
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID do cliente inválido.");
}

// Verificar se o cliente existe
$sql = "SELECT id FROM clientes WHERE id = :id";

$comando = $conexao->prepare($sql);
$comando->execute([":id" => $id]);

if (!$comando->fetch()) {
    die("Cliente não encontrado.");
}

// Excluir o cliente
$sql = "DELETE FROM clientes WHERE id = :id";

$comando = $conexao->prepare($sql);
$comando->execute([":id" => $id]);

echo "Cliente excluído com sucesso!";

echo "<br><br>";

echo '<a href="listar.php">Voltar para a lista de clientes</a>';

?>