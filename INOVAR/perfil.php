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

// Preparar a consulta para pegar as informações do usuário
$stmt = $conn->prepare("SELECT id, nome, email, nif, tipo, senha FROM usuarios WHERE nome = ? LIMIT 1");
$stmt->bind_param("s", $_SESSION['usuario']);
$stmt->execute();
$result = $stmt->get_result();

$user_info = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
        .password-container {
            display: flex;
            align-items: center; /* Centraliza verticalmente */
        }
        .password-container input {
            flex: 1; /* Faz o campo de senha ocupar o espaço disponível */
            margin-right: 10px; /* Espaçamento entre o input e o botão */
        }
        .btn-grey {
            background-color: #6c757d; /* Cor cinza */
            color: white; /* Texto branco */
        }
        .btn-yellow {
            background-color: #ffc107; /* Cor amarela */
            color: black; /* Texto preto */
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.innerHTML = "👁";
            } else {
                passwordField.type = "password";
                toggleButton.innerHTML = "👁";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <p><strong>Nome:</strong> <?php echo $user_info['nome']; ?></p>
        <div class="password-container">
            <label for="password" class="form-label"><strong>Senha:</strong></label>
            <input type="password" id="password" value="<?php echo $user_info['senha']; ?>" readonly class="form-control" aria-label="Senha">
            <button id="togglePassword" class="btn btn-grey" onclick="togglePassword()">👁</button>
            <a href="mudar_senha.php" class="btn btn-yellow">Mudar Senha</a> <!-- Botão para mudar senha -->
        </div>
        <p><strong>Email:</strong> <?php echo $user_info['email']; ?></p>
        <p><strong>NIF:</strong> <?php echo $user_info['nif']; ?></p>
        <a href="javascript:history.back()" class="btn-voltar">← Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
