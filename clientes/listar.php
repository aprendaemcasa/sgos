<?php

require_once "../config/conexao.php";

// Buscar todos os clientes cadastrados
$sql = "SELECT * FROM clientes ORDER BY id DESC";

$comando = $conexao->prepare($sql);

$comando->execute();

$clientes = $comando->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Clientes - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Clientes Cadastrados</h2>

        <div class="card">

            <table border="1" width="100%" cellpadding="10">

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($clientes as $cliente): ?>

                    <tr>
                        <td><?= $cliente["id"] ?></td>

                        <td><?= htmlspecialchars($cliente["nome"]) ?></td>
                        <<td>
    <a href="editar.php?id=<?= $cliente['id'] ?>">Editar</a>

    |

    <a href="excluir.php?id=<?= $cliente['id'] ?>"
       onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
        Excluir
    </a>
</td>
                        <td><?= htmlspecialchars($cliente["telefone"]) ?></td>

                        <td><?= htmlspecialchars($cliente["email"] ?? "") ?></td>

                        <td><?= htmlspecialchars($cliente["endereco"] ?? "") ?></td>
                    </tr>

                <?php endforeach; ?>

            </table>

            <br>

            <a href="cadastrar.php">Cadastrar novo cliente</a>

            <br><br>

            <a href="../index.php">Voltar ao início</a>

        </div>

    </main>

</body>
</html>