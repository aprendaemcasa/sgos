<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
require_once __DIR__ . '/../config/conexao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método não permitido.'); }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Cliente inválido.'); }
try {
    $stmt = $conexao->prepare('DELETE FROM clientes WHERE id = :id');
    $stmt->execute([':id' => $id]);
    if (!$stmt->rowCount()) { http_response_code(404); exit('Cliente não encontrado.'); }
    header('Location: listar.php?sucesso=excluido');
    exit;
} catch (PDOException $erro) {
    if ($erro->getCode() === '23000') {
        http_response_code(409);
        exit('Não é possível excluir este cliente porque há ordens de serviço vinculadas a ele.');
    }
    throw $erro;
}
