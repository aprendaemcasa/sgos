<?php
$servidor = getenv('SGOS_DB_HOST') ?: 'localhost';
$banco = getenv('SGOS_DB_NAME') ?: 'sgos';
$usuario = getenv('SGOS_DB_USER') ?: 'root';
$senha = getenv('SGOS_DB_PASS') ?: '';

try {
    $conexao = new PDO(
        "mysql:host={$servidor};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $erro) {
    error_log('Falha na conexão SGOS: ' . $erro->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Confira a configuração do SGOS.');
}
