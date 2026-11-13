<?php

// Conectar ao banco de dados
<?php

// Verificar se o usuário está conectado
require_once "config/sessao.php";

verificarLogin();

// Conectar ao banco de dados
require_once "config/conexao.php";

// Consultar os indicadores das ordens de serviço
$sql = "SELECT
            COUNT(*) AS total,

            SUM(CASE
                WHEN status = 'Aberta' THEN 1
                ELSE 0
            END) AS abertas,

            SUM(CASE
                WHEN status = 'Em andamento' THEN 1
                ELSE 0
            END) AS andamento,

            SUM(CASE
                WHEN status = 'Concluída' THEN 1
                ELSE 0
            END) AS concluidas

        FROM ordens_servico";

$consulta = $conexao->prepare($sql);
$consulta->execute();

$indicadores = $consulta->fetch(PDO::FETCH_ASSOC);

// Garantir que os valores sejam números
$total = (int) $indicadores["total"];
$abertas = (int) $indicadores["abertas"];
$andamento = (int) $indicadores["andamento"];
$concluidas = (int) $indicadores["concluidas"];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SGOS - Painel Principal</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <header>

        <h1>SGOS</h1>

        <p>Sistema de Gerenciamento de Ordens de Serviço</p>

    </header>

    <nav>
        <a href="logout.php">Sair do Sistema</a>
        <a href="index.php">Início</a>

        <a href="clientes/cadastrar.php">Cadastrar Clientes</a>

        <a href="clientes/listar.php">Listar Clientes</a>

        <a href="servicos/cadastrar.php">Cadastrar Serviços</a>

        <a href="servicos/listar.php">Listar Serviços</a>

        <a href="ordens/cadastrar.php">Cadastrar Ordem</a>

        <a href="ordens/listar.php">Listar Ordens</a>

    </nav>

    <main class="container">

        <h2>Painel Principal</h2>

        <p>Bem-vindo ao Sistema de Gerenciamento de Ordens de Serviço!</p>

        <h3 class="titulo-indicadores">Resumo das Ordens de Serviço</h3>

        <div class="dashboard">

            <div class="indicador">

                <h3>Total de Ordens</h3>

                <p><?= $total ?></p>

            </div>

            <div class="indicador">

                <h3>Ordens Abertas</h3>

                <p><?= $abertas ?></p>

            </div>

            <div class="indicador">

                <h3>Em Andamento</h3>

                <p><?= $andamento ?></p>

            </div>

            <div class="indicador">

                <h3>Concluídas</h3>

                <p><?= $concluidas ?></p>

            </div>

        </div>

        <div class="card">

            <h3>SGOS - Controle de Serviços</h3>

            <p>
                O sistema permite cadastrar clientes,
                registrar serviços, abrir ordens de serviço
                e acompanhar o andamento dos atendimentos.
            </p>

        </div>

    </main>

    <footer>

        <p>SGOS - Sistema desenvolvido para fins acadêmicos.</p>

    </footer>

</body>

</html>