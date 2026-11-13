<?php

require_once "../config/conexao.php";

// Verificar se o ID foi recebido
if (!isset($_GET["id"])) {
    die("Cliente não informado.");
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID de cliente inválido.");
}

// Buscar o cliente pelo ID
$sql = "SELECT * FROM clientes WHERE id = :id";

$comando = $conexao->prepare($sql);
$comando->execute([":id" => $id]);

$cliente = $comando->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    die("Cliente não encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Editar Cliente</h2>

        <div class="card">

            <form action="atualizar.php" method="POST">

                <input type="hidden" name="id"
                    value="<?= $cliente['id'] ?>">

                <label>Nome do cliente:</label>
                <input type="text" name="nome"
                    value="<?= htmlspecialchars($cliente['nome']) ?>" required>

                <br><br>

                <label>Telefone:</label>
                <input type="text" name="telefone"
                    value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

                <br><br>

                <label>E-mail:</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars($cliente['email'] ?? '') ?>">

                <br><br>

                <label>Endereço:</label>
                <input type="text" name="endereco"
                    value="<?= htmlspecialchars($cliente['endereco'] ?? '') ?>">

                <br><br>

                <button type="submit">Salvar Alterações</button>

            </form>

        </div>

        <p><a href="listar.php">Voltar para a lista de clientes</a></p>

    </main>

</body>
</html>