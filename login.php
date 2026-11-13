<?php

// Iniciar a sessão
session_start();

// Se já estiver conectado, ir para o painel
if (isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SGOS</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <main class="container">

        <h2>Acesso ao Sistema</h2>

        <div class="card">

            <form action="autenticar.php" method="POST">

                <label for="email">E-mail:</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                >

                <br><br>

                <label for="senha">Senha:</label>

                <input
                    type="password"
                    name="senha"
                    id="senha"
                    required
                >

                <br><br>

                <button type="submit">Entrar</button>

            </form>

        </div>

    </main>

</body>

</html>