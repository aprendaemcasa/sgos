<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once "../config/conexao.php";

// Buscar os clientes cadastrados
$sqlClientes = "SELECT * FROM clientes ORDER BY nome ASC";
$consultaClientes = $conexao->prepare($sqlClientes);
$consultaClientes->execute();
$clientes = $consultaClientes->fetchAll(PDO::FETCH_ASSOC);

// Buscar os serviços cadastrados
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

    <title>Cadastrar Ordem de Serviço - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Nova Ordem de Serviço</h2>

        <div class="card">

            <form action="salvar.php" method="POST">

                <label for="cliente_id">Cliente:</label>

                <select name="cliente_id" id="cliente_id" required>

                    <option value="">Selecione um cliente</option>

                    <?php foreach ($clientes as $cliente): ?>

                        <option value="<?= $cliente['id'] ?>">

                            <?= htmlspecialchars($cliente['nome']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <br><br>

                <label for="servico_id">Serviço:</label>

                <select name="servico_id" id="servico_id" required>

                    <option value="">Selecione um serviço</option>

                    <?php foreach ($servicos as $servico): ?>

                        <option
                            value="<?= $servico['id'] ?>"
                            data-valor="<?= htmlspecialchars($servico['valor']) ?>"
                        >

                            <?= htmlspecialchars($servico['nome']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <br><br>

                <label for="descricao">Descrição do problema ou solicitação:</label>

                <textarea
                    name="descricao"
                    id="descricao"
                    rows="5"
                    required
                ></textarea>

                <br><br>

                <label for="data_prazo">Data prevista para conclusão:</label>

                <input
                    type="date"
                    name="data_prazo"
                    id="data_prazo"
                >

                <br><br>

                <label for="valor">Valor do serviço (R$):</label>

                <input
                    type="number"
                    name="valor"
                    id="valor"
                    step="0.01"
                    min="0"
                    required
                >

                <br><br>

                <button type="submit">Cadastrar Ordem de Serviço</button>

            </form>

        </div>

        <br>

        <a href="../index.php">Voltar ao início</a>

    </main>

</body>

</html>