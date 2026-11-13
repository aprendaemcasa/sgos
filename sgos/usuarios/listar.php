<?php

// Conectar ao banco de dados
require_once "../config/conexao.php";

// Buscar os usuários cadastrados
$sql = "SELECT id, nome, email, tipo
        FROM usuarios
        ORDER BY id DESC";

$comando = $conexao->prepare($sql);

$comando->execute();

$usuarios = $comando->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Usuários Cadastrados - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Usuários Cadastrados</h2>

        <div class="card">

            <table border="1" width="100%" cellpadding="10">

                <tr>

                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Tipo de Usuário</th>

                </tr>

                <?php foreach ($usuarios as $usuario): ?>

                    <tr>

                        <td>
                            <?= $usuario["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario["nome"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario["email"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario["tipo"]) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if (count($usuarios) === 0): ?>

                    <tr>
                        <td colspan="4">
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>

                <?php endif; ?>

            </table>

            <br>

            <a href="cadastrar.php">Cadastrar novo usuário</a>

            <br><br>

            <a href="../index.php">Voltar ao início</a>

        </div>

    </main>

</body>

</html>