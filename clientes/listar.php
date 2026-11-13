<?php
require_once __DIR__ . '/../config/sessao.php'; verificarLogin();
require_once __DIR__ . '/../config/conexao.php';
$clientes = $conexao->query('SELECT * FROM clientes ORDER BY id DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Clientes - SGOS</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header><h1>SGOS</h1><p>Sistema de Gerenciamento de Ordens de Serviço</p></header><main class="container"><h2>Clientes cadastrados</h2><div class="card"><div class="table-wrap"><table><thead><tr><th>ID</th><th>Nome</th><th>Telefone</th><th>E-mail</th><th>Endereço</th><th>Ações</th></tr></thead><tbody>
<?php foreach ($clientes as $cliente): ?><tr><td><?= (int)$cliente['id'] ?></td><td><?= h($cliente['nome']) ?></td><td><?= h($cliente['telefone']) ?></td><td><?= h($cliente['email']) ?></td><td><?= h($cliente['endereco']) ?></td><td><a href="editar.php?id=<?= (int)$cliente['id'] ?>">Editar</a> | <form class="inline-form" action="excluir.php" method="POST" onsubmit="return confirm('Excluir este cliente?');"><input type="hidden" name="id" value="<?= (int)$cliente['id'] ?>"><input type="hidden" name="csrf_token" value="<?= h(gerarTokenCsrf()) ?>"><button class="link-button" type="submit">Excluir</button></form></td></tr><?php endforeach; ?>
<?php if (!$clientes): ?><tr><td colspan="6">Nenhum cliente cadastrado.</td></tr><?php endif; ?>
</tbody></table></div><p><a href="cadastrar.php">Cadastrar cliente</a> | <a href="../index.php">Voltar ao início</a></p></div></main></body></html>
