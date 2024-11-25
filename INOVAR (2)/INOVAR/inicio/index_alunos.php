<?php
session_start();

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

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome']) && isset($_POST['senha'])) {
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        // Preparar a consulta
        $stmt = $conn->prepare("SELECT id, nome, senha FROM alunos WHERE nome = ? LIMIT 1");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($senha === $user['senha']) {
                $_SESSION['usuario'] = $user['nome'];
                $_SESSION['id'] = $user['id'];
                // Define a variável para redirecionamento em caso de sucesso
                $redirectTo = "../aluno.php";
            } else {
                $erro = "Senha inválida!";
            }
        } else {
            $erro = "Usuário não encontrado!";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('../288fcce4-a3c6-4c51-9d4d-4e1b88817c3c.jpg');
            background-size: cover;
            background-position: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.2s ease-in-out;
            position: relative;
        }
        .container h2 {
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 170px;
            margin: 0 15px;
            transition: transform 0.3s ease;
        }
        .logo-container img:hover {
            transform: scale(1.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .home-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 1.5rem;
            color: #007bff;
            text-decoration: none;
        }
        .home-icon:hover {
            color: #0056b3;
        }
        .toggle-password {
            cursor: pointer;
            font-size: 0.9rem;
        }

        /* Estilos para o gif de carregamento */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .loading-overlay img {
            width: 80px;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('senha');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar';
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '<i class="fas fa-eye"></i> Mostrar';
            }
        }

        function mostrarCarregamento() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
</head>
<body>
    <!-- Gif de carregamento -->
    <div id="loading" class="loading-overlay" style="display: none;">
        <img src="../img/logo.gif" alt="Carregando...">
    </div>

    <div class="container">
        <!-- Ícone da Casa -->
        <a href="pagina_inicial.php" class="home-icon" title="Página Inicial">
            <i class="fas fa-home"></i>
        </a>

        <div class="logo-container">
            <img src="../img/logo.png" alt="Logo ITA">
        </div>
        <h2>Login - Alunos</h2>
        <form action="index_alunos.php" method="POST" onsubmit="mostrarCarregamento();">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="senha" id="senha" required>
                    <button type="button" class="btn btn-outline-secondary toggle-password" id="togglePassword" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i> Mostrar
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <!-- Redirecionamento automático após login bem-sucedido -->
        <?php if (isset($redirectTo)): ?>
            <script>
                mostrarCarregamento();
                setTimeout(function() {
                    window.location.href = '<?php echo $redirectTo; ?>';
                }, 500);
            </script>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
