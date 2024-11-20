<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola'; // Nome da base de dados
$user = 'root'; // Usuário do MySQL
$pass = ''; // Senha do MySQL (se houver)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Mensagens de feedback
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Consultar a senha atual do usuário
    $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE nome = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION['usuario']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info = $result->fetch_assoc();

    // Verificar se a senha atual está correta
    if ($user_info && $current_password === $user_info['senha']) {
        if ($new_password === $confirm_password) {
            // Atualizar a senha no banco de dados
            $update_stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE nome = ?");
            $update_stmt->bind_param("ss", $new_password, $_SESSION['usuario']);
            if ($update_stmt->execute()) {
                $message = "Senha alterada com sucesso!";
            } else {
                $error = "Erro ao atualizar a senha. Tente novamente.";
            }
        } else {
            $error = "A nova senha e a confirmação não correspondem.";
        }
    } else {
        $error = "A senha atual está incorreta."; // Mensagem quando a senha não é verificada
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Cor de fundo clara */
        }
        .container {
            background-color: white; /* Fundo branco para o container */
            border-radius: 8px; /* Bordas arredondadas */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Sombra para efeito de profundidade */
            padding: 30px; /* Espaçamento interno */
            margin-top: 50px; /* Espaçamento acima do container */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Mudar Senha</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="current_password" class="form-label">Senha Atual</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nova Senha</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Alterar Senha</button>
            <a href="perfil.php" class="btn btn-secondary">Voltar ao Perfil</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
