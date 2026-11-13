<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
// Conectar ao banco de dados
require_once "../config/conexao.php";

// Receber o ID da ordem pela URL
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Verificar se o ID é válido
if (!$id) {
    die("Ordem de serviço inválida.");
}

// Verificar se a ordem existe
$sqlVerificar = "SELECT id FROM ordens_servico WHERE id = :id";

$consulta = $conexao->prepare($sqlVerificar);

$consulta->execute([
    ":id" => $id
]);

if (!$consulta->fetch()) {
    die("Ordem de serviço não encontrada.");
}

// Excluir a ordem
$sql = "DELETE FROM ordens_servico WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":id" => $id
]);

// Retornar para a listagem
header("Location: listar.php");

exit;

?>