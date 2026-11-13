<?php

// Conectar ao banco de dados
require_once "config/conexao.php";

// Iniciar a sessão
require_once "config/sessao.php";

// Receber os dados do formulário
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

// Verificar se os campos foram preenchidos
if ($email === "" || $senha === "") {

    die("Preencha o e-mail e a senha.");

}

// Buscar o usuário pelo e-mail
$sql = "SELECT * FROM usuarios WHERE email = :email";

$consulta = $conexao->prepare($sql);

$consulta->execute([
    ":email" => $email
]);

$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

// Verificar se o usuário existe e se a senha está correta
if ($usuario && password_verify($senha, $usuario["senha"])) {

    // Salvar os dados do usuário na sessão
    session_regenerate_id(true);

    $_SESSION["usuario_id"] = $usuario["id"];

    $_SESSION["usuario_nome"] = $usuario["nome"];

    $_SESSION["usuario_tipo"] = $usuario["tipo"];

    // Entrar no painel principal
    header("Location: index.php");

    exit;

} else {

    // Caso os dados estejam incorretos
    echo "<h2>Login inválido!</h2>";

    echo "<p>E-mail ou senha incorretos.</p>";

    echo '<a href="login.php">Tentar novamente</a>';

}

?>