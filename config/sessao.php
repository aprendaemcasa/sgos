<?php
// Configurações seguras de sessão para o SGOS.
if (session_status() === PHP_SESSION_NONE) {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

function verificarLogin(): void
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: /sgos/login.php');
        exit;
    }
}

function verificarAdministrador(): void
{
    verificarLogin();
    if (($_SESSION['usuario_tipo'] ?? '') !== 'administrador') {
        http_response_code(403);
        exit('Acesso permitido somente para administradores.');
    }
}

function gerarTokenCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verificarTokenCsrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        exit('Solicitação inválida. Atualize a página e tente novamente.');
    }
}

function h($valor): string
{
    return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
