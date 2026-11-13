<?php
require_once __DIR__ . '/config/sessao.php';
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$erro = isset($_GET['erro']);
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
<header><h1>SGOS</h1><p>Sistema de Gerenciamento de Ordens de Serviço</p></header>
<main class="container">
<h2>Acesso ao sistema</h2>
<div class="card">
<?php if ($erro): ?><p class="mensagem erro">E-mail ou senha incorretos. Tente novamente.</p><?php endif; ?>
<form action="autenticar.php" method="POST">
<label for="email">E-mail:</label>
<input type="email" name="email" id="email" maxlength="150" autocomplete="username" required>
<label for="senha">Senha:</label>
<input type="password" name="senha" id="senha" autocomplete="current-password" required>
<button type="submit">Entrar</button>
</form>
</div>
</main>
</body>
</html>
