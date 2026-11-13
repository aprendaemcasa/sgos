<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
// Conectar ao banco de dados
require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$cliente_id = filter_input(INPUT_POST, "cliente_id", FILTER_VALIDATE_INT);

$servico_id = filter_input(INPUT_POST, "servico_id", FILTER_VALIDATE_INT);

$descricao = trim($_POST["descricao"] ?? "");

$data_prazo = $_POST["data_prazo"] ?? "";

$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);


// Validar os campos obrigatórios
if (
    !$id ||
    !$cliente_id ||
    !$servico_id ||
    $descricao === "" ||
    $valor === false ||
    $valor === null ||
    $valor < 0
) {
    die("Erro: preencha corretamente todos os campos.");
}


// Verificar se a ordem existe
$sqlOrdem = "SELECT id FROM ordens_servico WHERE id = :id";

$consultaOrdem = $conexao->prepare($sqlOrdem);

$consultaOrdem->execute([
    ":id" => $id
]);

if (!$consultaOrdem->fetch()) {
    die("Erro: ordem de serviço não encontrada.");
}


// Verificar se o cliente existe
$sqlCliente = "SELECT id FROM clientes WHERE id = :id";

$consultaCliente = $conexao->prepare($sqlCliente);

$consultaCliente->execute([
    ":id" => $cliente_id
]);

if (!$consultaCliente->fetch()) {
    die("Erro: cliente não encontrado.");
}


// Verificar se o serviço existe
$sqlServico = "SELECT id FROM servicos WHERE id = :id";

$consultaServico = $conexao->prepare($sqlServico);

$consultaServico->execute([
    ":id" => $servico_id
]);

if (!$consultaServico->fetch()) {
    die("Erro: serviço não encontrado.");
}


// Atualizar os dados da ordem
$sql = "UPDATE ordens_servico

        SET
            cliente_id = :cliente_id,
            servico_id = :servico_id,
            descricao = :descricao,
            data_prazo = :data_prazo,
            valor = :valor

        WHERE id = :id";


$comando = $conexao->prepare($sql);

$comando->execute([

    ":cliente_id" => $cliente_id,

    ":servico_id" => $servico_id,

    ":descricao" => $descricao,

    ":data_prazo" => $data_prazo !== "" ? $data_prazo : null,

    ":valor" => $valor,

    ":id" => $id

]);


// Voltar para a listagem
header("Location: listar.php");

exit;

?>