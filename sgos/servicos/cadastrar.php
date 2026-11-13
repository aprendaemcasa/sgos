<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Serviço - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Cadastrar Serviço</h2>

        <div class="card">

            <form action="salvar.php" method="POST">

                <label>Nome do serviço:</label>
                <input type="text" name="nome" required>

                <br><br>

                <label>Descrição:</label>
                <textarea name="descricao" rows="4"></textarea>

                <br><br>

                <label>Valor do serviço (R$):</label>
                <input type="number" name="valor"
                    step="0.01" min="0" required>

                <br><br>

                <button type="submit">Cadastrar Serviço</button>

            </form>

        </div>

        <p><a href="../index.php">Voltar ao início</a></p>

    </main>

</body>
</html>