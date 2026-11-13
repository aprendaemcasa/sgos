<?php

require_once "../config/conexao.php";

// Buscar todos os serviços cadastrados
$sql = "SELECT * FROM servicos ORDER BY id DESC";

$comando = $conexao->prepare($sql);

$comando->execute();

$servicos = $comando->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Serviços - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Serviços Cadastrados</h2>

        <div class="card">

            <table border="1" width="100%" cellpadding="10">

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($servicos as $servico): ?>

                    <tr>
                        <td><?= $servico["id"] ?></td>

                        <td><?= htmlspecialchars($servico["nome"]) ?></td>

                        <td><?= htmlspecialchars($servico["descricao"] ?? "") ?></td>

                        <td>
                            R$ <?= number_format((float) $servico["valor"], 2, ",", ".") ?>
                        </td>
                        <td>
    <a href="editar.php?id=<?= $servico['id'] ?>">Editar</a>

    |

    <a href="excluir.php?id=<?= $servico['id'] ?>"
       onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
        Excluir
    </a>
</td>
                    </tr>

                <?php endforeach; ?>

            </table>

            <br>

            <a href="cadastrar.php">Cadastrar novo serviço</a>

            <br><br>

            <a href="../index.php">Voltar ao início</a>

        </div>

    </main>

</body>
</html>