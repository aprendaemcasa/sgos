<?php

require_once "../config/conexao.php";

// Receber o ID da ordem pela URL
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Ordem de serviço inválida.");
}

// Buscar os dados da ordem
$sql = "SELECT * FROM ordens_servico WHERE id = :id";

$comando = $conexao->prepare($sql);

$comando->execute([
    ":id" => $id
]);

$ordem = $comando->fetch(PDO::FETCH_ASSOC);

if (!$ordem) {
    die("Ordem de serviço não encontrada.");
}

// Buscar clientes
$sqlClientes = "SELECT * FROM clientes ORDER BY nome ASC";

$consultaClientes = $conexao->prepare($sqlClientes);
$consultaClientes->execute();

$clientes = $consultaClientes->fetchAll(PDO::FETCH_ASSOC);

// Buscar serviços
$sqlServicos = "SELECT * FROM servicos ORDER BY nome ASC";

$consultaServicos = $conexao->prepare($sqlServicos);
$consultaServicos->execute();

$servicos = $consultaServicos->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Ordem de Serviço - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Editar Ordem de Serviço Nº <?= $ordem["id"] ?></h2>

        <div class="card">

            <form action="atualizar.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $ordem["id"] ?>"
                >

                <label for="cliente_id">Cliente:</label>

                <select name="cliente_id" id="cliente_id" required>

                    <?php foreach ($clientes as $cliente): ?>

                        <option
                            value="<?= $cliente["id"] ?>"
                            <?= $ordem["cliente_id"] == $cliente["id"] ? "selected" : "" ?>
                        >

                            <?= htmlspecialchars($cliente["nome"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <br><br>

                <label for="servico_id">Serviço:</label>

                <select name="servico_id" id="servico_id" required>

                    <?php foreach ($servicos as $servico): ?>

                        <option
                            value="<?= $servico["id"] ?>"
                            <?= $ordem["servico_id"] == $servico["id"] ? "selected" : "" ?>
                        >

                            <?= htmlspecialchars($servico["nome"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <br><br>

                <label for="descricao">Descrição:</label>

                <textarea
                    name="descricao"
                    id="descricao"
                    rows="5"
                    required
                ><?= htmlspecialchars($ordem["descricao"]) ?></textarea>

                <br><br>

                <label for="data_prazo">Data prevista para conclusão:</label>

                <input
                    type="date"
                    name="data_prazo"
                    id="data_prazo"
                    value="<?= htmlspecialchars($ordem["data_prazo"] ?? "") ?>"
                >

                <br><br>

                <label for="valor">Valor do serviço (R$):</label>

                <input
                    type="number"
                    name="valor"
                    id="valor"
                    step="0.01"
                    min="0"
                    value="<?= htmlspecialchars((string) $ordem["valor"]) ?>"
                    required
                >

                <br><br>

                <button type="submit">Salvar Alterações</button>

            </form>

        </div>

        <br>

        <a href="listar.php">Voltar para as ordens</a>

    </main>

</body>

</html>