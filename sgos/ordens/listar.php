<?php

require_once "../config/conexao.php";

// Buscar as ordens cadastradas
$sql = "SELECT
            os.id,
            c.nome AS cliente,
            s.nome AS servico,
            os.descricao,
            os.status,
            os.data_abertura,
            os.data_prazo,
            os.valor

        FROM ordens_servico os

        INNER JOIN clientes c
            ON os.cliente_id = c.id

        INNER JOIN servicos s
            ON os.servico_id = s.id

        ORDER BY os.id DESC";

$comando = $conexao->prepare($sql);
$comando->execute();

$ordens = $comando->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ordens de Serviço - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Ordens de Serviço Cadastradas</h2>

        <div class="card">

            <table border="1" width="100%" cellpadding="10">

                <tr>

                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data de Abertura</th>
                    <th>Prazo</th>
                    <th>Valor</th>
                    <th>Alterar Status</th>
                    <th>Ações</th>

                </tr>

                <?php foreach ($ordens as $ordem): ?>

                    <tr>

                        <td><?= $ordem["id"] ?></td>

                        <td>
                            <?= htmlspecialchars($ordem["cliente"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($ordem["servico"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($ordem["descricao"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($ordem["status"]) ?>
                        </td>

                        <td>
                            <?= date("d/m/Y H:i", strtotime($ordem["data_abertura"])) ?>
                        </td>

                        <td>
                            <?= $ordem["data_prazo"]
                                ? date("d/m/Y", strtotime($ordem["data_prazo"]))
                                : "Não informado" ?>
                        </td>

                        <td>
                            R$ <?= number_format((float) $ordem["valor"], 2, ",", ".") ?>
                        </td>

                        <td>

                            <form action="alterar_status.php" method="POST">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $ordem["id"] ?>"
                                >

                                <select name="status" required>

                                    <option value="Aberta"
                                        <?= $ordem["status"] === "Aberta" ? "selected" : "" ?>>
                                        Aberta
                                    </option>

                                    <option value="Em andamento"
                                        <?= $ordem["status"] === "Em andamento" ? "selected" : "" ?>>
                                        Em andamento
                                    </option>

                                    <option value="Concluída"
                                        <?= $ordem["status"] === "Concluída" ? "selected" : "" ?>>
                                        Concluída
                                    </option>

                                    <option value="Cancelada"
                                        <?= $ordem["status"] === "Cancelada" ? "selected" : "" ?>>
                                        Cancelada
                                    </option>

                                </select>

                                <br><br>

                                <button type="submit">Atualizar</button>

                               <td>

    <a href="editar.php?id=<?= $ordem['id'] ?>">Editar</a>

    |

    <a
        href="excluir.php?id=<?= $ordem['id'] ?>"
        onclick="return confirm('Tem certeza que deseja excluir esta ordem de serviço?')"
    >
        Excluir
    </a>

</td>
                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if (count($ordens) === 0): ?>

                    <tr>
                        <td colspan="10">Nenhuma ordem de serviço cadastrada.</td>
                    </tr>

                <?php endif; ?>

            </table>

            <br>

            <a href="cadastrar.php">Cadastrar nova ordem</a>

            <br><br>

            <a href="../index.php">Voltar ao início</a>

        </div>

    </main>

</body>

</html>