<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Usuário - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Cadastrar Funcionário</h2>

        <div class="card">

            <form action="salvar.php" method="POST">

                <label for="nome">Nome completo:</label>

                <input
                    type="text"
                    name="nome"
                    id="nome"
                    maxlength="100"
                    required
                >

                <br><br>

                <label for="email">E-mail:</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    maxlength="150"
                    required
                >

                <br><br>

                <label for="senha">Senha:</label>

                <input
                    type="password"
                    name="senha"
                    id="senha"
                    minlength="8"
                    required
                >

                <br><br>

                <?php if (($_SESSION["usuario_tipo"] ?? "") === "administrador"): ?>
                <label for="tipo">Tipo de usuário:</label>

                <select name="tipo" id="tipo" required>

                    <option value="funcionario">Funcionário</option>

                    <option value="administrador">Administrador</option>

                </select>
                <?php else: ?>
                <input type="hidden" name="tipo" value="funcionario">
                <?php endif; ?>

                <br><br>

                <button type="submit">Cadastrar Usuário</button>

            </form>

        </div>

        <br>

        <a href="../index.php">Voltar ao início</a>

    </main>

</body>

</html>