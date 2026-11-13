<?php
require_once __DIR__ . '/config/sessao.php';
verificarLogin();
require_once __DIR__ . '/config/conexao.php';

$sql = "SELECT COUNT(*) AS total,
SUM(status = 'Aberta') AS abertas,
SUM(status = 'Em andamento') AS andamento,
SUM(status = 'Concluída') AS concluidas
FROM ordens_servico";
$consulta = $conexao->query($sql);
$indicadores = $consulta->fetch() ?: [];
$total = (int)($indicadores['total'] ?? 0);
$abertas = (int)($indicadores['abertas'] ?? 0);
$andamento = (int)($indicadores['andamento'] ?? 0);
$concluidas = (int)($indicadores['concluidas'] ?? 0);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SGOS - Painel Principal</title><link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><h1>SGOS</h1><p>Sistema de Gerenciamento de Ordens de Serviço</p></header>
<nav>
<a href="index.php">Início</a><a href="clientes/cadastrar.php">Cadastrar cliente</a><a href="clientes/listar.php">Clientes</a>
<a href="servicos/cadastrar.php">Cadastrar serviço</a><a href="servicos/listar.php">Serviços</a>
<a href="ordens/cadastrar.php">Nova ordem</a><a href="ordens/listar.php">Ordens</a>
<?php if (($_SESSION['usuario_tipo'] ?? '') === 'administrador'): ?><a href="usuarios/listar.php">Usuários</a><?php endif; ?>
<a href="logout.php">Sair (<?= h($_SESSION['usuario_nome'] ?? '') ?>)</a>
</nav>
<main class="container">
<h2>Painel principal</h2><p>Bem-vindo ao SGOS.</p>
<h3 class="titulo-indicadores">Resumo das ordens de serviço</h3>
<div class="dashboard">
<div class="indicador"><h3>Total de ordens</h3><p><?= $total ?></p></div>
<div class="indicador"><h3>Abertas</h3><p><?= $abertas ?></p></div>
<div class="indicador"><h3>Em andamento</h3><p><?= $andamento ?></p></div>
<div class="indicador"><h3>Concluídas</h3><p><?= $concluidas ?></p></div>
</div>
<div class="card"><h3>Controle de serviços</h3><p>Cadastre clientes e serviços, abra ordens e acompanhe os atendimentos.</p></div>
</main>
<footer><p>SGOS - Projeto acadêmico.</p></footer>
</body>
</html>
