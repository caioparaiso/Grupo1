<?php
session_start();

// Conectar à base de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


// Verificar se o usuário está logado e se é professor
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'professor') {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

$nome = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT avatar FROM usuarios WHERE nome = ? LIMIT 1");
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

$usuario = $result->fetch_assoc();
$avatar = $usuario['avatar'];

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Professor</title>
    <link rel="shortcut icon" href="escola_logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
            padding: 1rem;
        }
        .navbar-brand, .nav-link {
            color: #ffffff;
        }
        .nav-link:hover {
            color: #e0e0e0;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #ffffff;
        }
        .logout-icon {
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s;
            margin-left: 15px;
        }
        .logout-icon:hover {
            color: #dc3545;
        }
        .container {
            padding: 0;
        }
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background-color: white;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo-container img {
            height: 70px; /* Aumente para o tamanho desejado */
            width: auto;  /* Mantém a proporção */
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
        <!-- Navbar Início -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <div class="logo-container">
                <a href="pagina_inicial.php">
                    <img src="./img/logo.png" alt="Logo ITA" />
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="turmas.php">Turmas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="disponibilidade.php">Disponibilidade</a>
                    </li>
                </ul>
                <!-- User Info com Logout -->
                <div class="user-info">
                    <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar do Aluno">
                    <span><?php echo htmlspecialchars($nome); ?></span>
                    <a href="logout.php" class="logout-icon" title="Sair">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
