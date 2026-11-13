<?php
require_once __DIR__ . '/../config/sessao.php';
verificarLogin();
// Conectar ao banco de dados
require_once "../config/conexao.php";

// Receber os dados do formulário
$nome = trim($_POST["nome"] ?? "");

$email = trim($_POST["email"] ?? "");

$senha = $_POST["senha"] ?? "";

$tipoSolicitado = $_POST["tipo"] ?? "funcionario";
// Somente um administrador pode criar outro administrador.
$tipo = (($_SESSION["usuario_tipo"] ?? "") === "administrador" && $tipoSolicitado === "administrador")
    ? "administrador"
    : "funcionario";

// Tipos de usuário permitidos
$tiposPermitidos = [
    "funcionario",
    "administrador"
];

// Validar os campos
if (
    $nome === "" ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($senha) < 8 ||
    !in_array($tipo, $tiposPermitidos, true)
) {
    die("Erro: verifique os dados informados.");
}

// Verificar se o e-mail já está cadastrado
$sqlVerificar = "SELECT id FROM usuarios WHERE email = :email";

$consulta = $conexao->prepare($sqlVerificar);

$consulta->execute([
    ":email" => $email
]);

if ($consulta->fetch()) {
    die("Erro: este e-mail já está cadastrado.");
}

// Proteger a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Preparar o cadastro
$sql = "INSERT INTO usuarios (nome, email, senha, tipo)
        VALUES (:nome, :email, :senha, :tipo)";

$comando = $conexao->prepare($sql);

// Executar o cadastro
$comando->execute([

    ":nome" => $nome,

    ":email" => $email,

    ":senha" => $senhaHash,

    ":tipo" => $tipo

]);

// Mostrar confirmação
echo "<h2>Usuário cadastrado com sucesso!</h2>";

echo "<p>Nome: " . htmlspecialchars($nome) . "</p>";

echo "<p>E-mail: " . htmlspecialchars($email) . "</p>";

echo '<a href="cadastrar.php">Cadastrar outro usuário</a>';

echo "<br><br>";

echo '<a href="../index.php">Voltar ao início</a>';

?>