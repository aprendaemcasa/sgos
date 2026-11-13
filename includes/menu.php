<?php
$uriAtual = $_SERVER['REQUEST_URI'] ?? '';
?>
<nav class="menu-principal" aria-label="Navegação principal">
<a href="/index.php">⌂ <span>Início</span></a>
<a href="/clientes/listar.php">♙ <span>Clientes</span></a>
<a href="/servicos/listar.php">▣ <span>Serviços</span></a>
<a href="/ordens/listar.php">▤ <span>Ordens de serviço</span></a>
<?php if (($_SESSION['usuario_tipo'] ?? '') === 'administrador'): ?><a href="/usuarios/listar.php">♙ <span>Usuários</span></a><?php endif; ?>
<a class="sair" href="/logout.php">↪ <span>Sair · <?= h($_SESSION['usuario_nome'] ?? 'Usuário') ?></span></a>
</nav>