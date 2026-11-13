<?php
require_once __DIR__ . '/config/sessao.php';
require_once __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
    header('Location: login.php?erro=1');
    exit;
}
$consulta = $conexao->prepare('SELECT id, nome, email, senha, tipo FROM usuarios WHERE email = :email LIMIT 1');
$consulta->execute([':email' => $email]);
$usuario = $consulta->fetch();
if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    header('Location: login.php?erro=1');
    exit;
}
session_regenerate_id(true);
$_SESSION['usuario_id'] = (int)$usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_tipo'] = $usuario['tipo'];
header('Location: index.php');
exit;
