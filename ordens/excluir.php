<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once __DIR__ . '/../config/conexao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método não permitido.'); }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Ordem inválida.'); }
$stmt = $conexao->prepare('DELETE FROM ordens_servico WHERE id = :id');
$stmt->execute([':id' => $id]);
if (!$stmt->rowCount()) { http_response_code(404); exit('Ordem não encontrada.'); }
header('Location: listar.php?sucesso=excluida');
exit;
