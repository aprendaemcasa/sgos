<?php
require_once __DIR__ . '/../config/sessao.php'; verificarLogin();
require_once __DIR__ . '/../config/conexao.php';
$sql = "SELECT os.id, c.nome AS cliente, s.nome AS servico, os.descricao, os.status, os.data_abertura, os.data_prazo, os.valor
FROM ordens_servico os INNER JOIN clientes c ON c.id=os.cliente_id INNER JOIN servicos s ON s.id=os.servico_id ORDER BY os.id DESC";
$ordens = $conexao->query($sql)->fetchAll();
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Ordens - SGOS</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<header><h1>SGOS</h1><p>Sistema de Gerenciamento de Ordens de Serviço</p></header>
<?php require_once __DIR__ . '/../includes/menu.php'; ?><main class="container"><h2>Ordens de serviço</h2><div class="card"><div class="table-wrap"><table><thead><tr><th>Nº</th><th>Cliente</th><th>Serviço</th><th>Descrição</th><th>Status</th><th>Abertura</th><th>Prazo</th><th>Valor</th><th>Alterar status</th><th>Ações</th></tr></thead><tbody>
<?php foreach ($ordens as $ordem): ?><tr>
<td><?= (int)$ordem['id'] ?></td><td><?= h($ordem['cliente']) ?></td><td><?= h($ordem['servico']) ?></td><td><?= h($ordem['descricao']) ?></td><td><?= h($ordem['status']) ?></td>
<td><?= date('d/m/Y H:i', strtotime($ordem['data_abertura'])) ?></td><td><?= $ordem['data_prazo'] ? date('d/m/Y', strtotime($ordem['data_prazo'])) : 'Não informado' ?></td><td>R$ <?= number_format((float)$ordem['valor'],2,',','.') ?></td>
<td><form action="alterar_status.php" method="POST"><input type="hidden" name="id" value="<?= (int)$ordem['id'] ?>"><input type="hidden" name="csrf_token" value="<?= h(gerarTokenCsrf()) ?>"><select name="status" required><?php foreach (['Aberta','Em andamento','Concluída','Cancelada'] as $status): ?><option value="<?= h($status) ?>" <?= $ordem['status']===$status?'selected':'' ?>><?= h($status) ?></option><?php endforeach; ?></select><button type="submit">Salvar</button></form></td>
<td><a href="editar.php?id=<?= (int)$ordem['id'] ?>">Editar</a> | <form class="inline-form" action="excluir.php" method="POST" onsubmit="return confirm('Excluir esta ordem?');"><input type="hidden" name="id" value="<?= (int)$ordem['id'] ?>"><input type="hidden" name="csrf_token" value="<?= h(gerarTokenCsrf()) ?>"><button class="link-button" type="submit">Excluir</button></form></td></tr><?php endforeach; ?>
<?php if (!$ordens): ?><tr><td colspan="10">Nenhuma ordem cadastrada.</td></tr><?php endif; ?></tbody></table></div><p><a href="cadastrar.php">Cadastrar ordem</a> | <a href="../index.php">Voltar ao início</a></p></div></main></body></html>
