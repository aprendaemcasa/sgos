<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
?>

<?php

require_once "../config/conexao.php";

// Receber os dados enviados pelo formulário
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_FLOAT);

// Validar os dados recebidos
if (
    !$id ||
    $nome === "" ||
    $valor === false ||
    $valor === null ||
    $valor < 0
) {
    die("Preencha corretamente todos os campos obrigatórios.");
}

// Preparar o comando SQL para atualizar o serviço
$sql = "UPDATE servicos
        SET nome = :nome,
            descricao = :descricao,
            valor = :valor
        WHERE id = :id";

// Preparar a consulta
$comando = $conexao->prepare($sql);

// Executar a atualização
$comando->execute([
    ":nome" => $nome,
    ":descricao" => $descricao,
    ":valor" => $valor,
    ":id" => $id
]);

echo "Serviço atualizado com sucesso!";

echo "<br><br>";

echo '<a href="listar.php">Voltar para a lista de serviços</a>';

?>
