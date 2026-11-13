<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
?>

<?php

require_once "../config/conexao.php";

// Receber o ID do serviço pela URL
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Verificar se o ID é válido
if (!$id) {
    die("ID do serviço inválido.");
}

// Verificar se o serviço existe
$sql = "SELECT id FROM servicos WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":id" => $id
]);

$servico = $comando->fetch(PDO::FETCH_ASSOC);

if (!$servico) {
    die("Serviço não encontrado.");
}

// Excluir o serviço
$sql = "DELETE FROM servicos WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":id" => $id
]);

echo "Serviço excluído com sucesso!";

echo "<br><br>";

echo '<a href="listar.php">Voltar para a lista de serviços</a>';

?>
