<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
// Conectar ao banco de dados
require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$cliente_id = filter_input(INPUT_POST, "cliente_id", FILTER_VALIDATE_INT);

$servico_id = filter_input(INPUT_POST, "servico_id", FILTER_VALIDATE_INT);

$descricao = trim($_POST["descricao"] ?? "");

$data_prazo = $_POST["data_prazo"] ?? "";

$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);


// Verificar se os campos obrigatórios foram preenchidos
if (
    !$cliente_id ||
    !$servico_id ||
    $descricao === "" ||
    $valor === false ||
    $valor === null ||
    $valor < 0
) {
    die("Erro: preencha corretamente todos os campos obrigatórios.");
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


// Preparar o comando para cadastrar a ordem
$sql = "INSERT INTO ordens_servico
        (cliente_id, servico_id, descricao, data_prazo, valor)
        VALUES
        (:cliente_id, :servico_id, :descricao, :data_prazo, :valor)";


// Preparar e executar o cadastro
$comando = $conexao->prepare($sql);

$comando->execute([

    ":cliente_id" => $cliente_id,

    ":servico_id" => $servico_id,

    ":descricao" => $descricao,

    ":data_prazo" => $data_prazo !== "" ? $data_prazo : null,

    ":valor" => $valor

]);


// Mostrar confirmação
echo "<h2>Ordem de Serviço cadastrada com sucesso!</h2>";

echo "<p>Número da Ordem: " . $conexao->lastInsertId() . "</p>";

echo '<a href="cadastrar.php">Cadastrar outra ordem</a>';

echo "<br><br>";

echo '<a href="../index.php">Voltar ao início</a>';

?>