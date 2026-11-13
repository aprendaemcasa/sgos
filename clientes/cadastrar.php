<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Cliente - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Cadastrar Cliente</h2>

        <div class="card">

            <form action="salvar.php" method="POST">

                <label>Nome do cliente:</label>
                <input type="text" name="nome" required>

                <br><br>

                <label>Telefone:</label>
                <input type="text" name="telefone" required>

                <br><br>

                <label>E-mail:</label>
                <input type="email" name="email">

                <br><br>

                <label>Endereço:</label>
                <input type="text" name="endereco">

                <br><br>

                <button type="submit">Cadastrar Cliente</button>

            </form>

        </div>

        <p><a href="../index.php">Voltar ao início</a></p>

    </main>

</body>
</html>