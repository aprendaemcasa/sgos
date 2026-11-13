<?php

// Conectar ao banco de dados
require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$status = $_POST["status"] ?? "";

// Lista de status permitidos
$statusPermitidos = [
    "Aberta",
    "Em andamento",
    "Concluída",
    "Cancelada"
];

// Validar os dados
if (!$id || !in_array($status, $statusPermitidos, true)) {
    die("Erro: dados inválidos.");
}

// Verificar se a ordem existe
$sqlVerificar = "SELECT id FROM ordens_servico WHERE id = :id";

$consulta = $conexao->prepare($sqlVerificar);

$consulta->execute([
    ":id" => $id
]);

if (!$consulta->fetch()) {
    die("Erro: ordem de serviço não encontrada.");
}

// Atualizar o status
$sql = "UPDATE ordens_servico
        SET status = :status
        WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":status" => $status,
    ":id" => $id
]);

// Redirecionar para a listagem
header("Location: listar.php");

exit;

?>