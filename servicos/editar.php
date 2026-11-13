<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once "../config/conexao.php";

// Verificar se o ID foi recebido
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID do serviço inválido.");
}

// Buscar o serviço no banco de dados
$sql = "SELECT * FROM servicos WHERE id = :id";

$comando = $conexao->prepare($sql);
$comando->execute([":id" => $id]);

$servico = $comando->fetch(PDO::FETCH_ASSOC);

if (!$servico) {
    die("Serviço não encontrado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Serviço - SGOS</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <header>
        <h1>SGOS</h1>
        <p>Sistema de Gerenciamento de Ordens de Serviço</p>
    </header>

    <main class="container">

        <h2>Editar Serviço</h2>

        <div class="card">

            <form action="atualizar.php" method="POST">

                <input type="hidden" name="id"
                    value="<?= $servico['id'] ?>">

                <label>Nome do serviço:</label>
                <input type="text" name="nome"
                    value="<?= htmlspecialchars($servico['nome']) ?>" required>

                <br><br>

                <label>Descrição:</label>
                <textarea name="descricao" rows="4"><?= htmlspecialchars($servico['descricao'] ?? '') ?></textarea>

                <br><br>

                <label>Valor do serviço (R$):</label>
                <input type="number" name="valor"
                    value="<?= htmlspecialchars((string) $servico['valor']) ?>"
                    step="0.01" min="0" required>

                <br><br>

                <button type="submit">Salvar Alterações</button>

            </form>

        </div>

        <p><a href="listar.php">Voltar para a lista de serviços</a></p>

    </main>

</body>
</html>