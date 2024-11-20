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

if (!isset($_SESSION['usuario'])) {
    header("Location: index_alunos.php");
    exit();
}

$nome = $_SESSION['usuario'];
$stmt = $conn->prepare("SELECT id, avatar, turma FROM alunos WHERE nome = ? LIMIT 1");
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index_alunos.php");
    exit();
}

$aluno = $result->fetch_assoc();
$avatar = $aluno['avatar'];
$turma_id = $aluno['turma'];

$stmt_turma = $conn->prepare("SELECT nome, curso, inicio, fim, professor FROM turmas WHERE nome = ?");
$stmt_turma->bind_param("s", $turma_id);
$stmt_turma->execute();
$result_turma = $stmt_turma->get_result();
$turma = $result_turma->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
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
        .turma-info-box, .school-info-box {
            margin-top: 20px;
            padding: 20px;
            max-width: 350px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            color: #333;
        }
        .turma-info-box h3, .school-info-box h3 {
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
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
                        <a class="nav-link" href="notas.php?turma=<?php echo urlencode($turma['nome']); ?>">Minhas Notas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modulos_aluno.php">Módulos</a>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="turma-info-box">
                    <h3>Informações da Turma</h3>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($turma['nome']); ?></p>
                    <p><strong>Curso:</strong> <?php echo htmlspecialchars($turma['curso']); ?></p>
                    <p><strong>Início:</strong> <?php echo htmlspecialchars($turma['inicio']); ?></p>
                    <p><strong>Fim:</strong> <?php echo htmlspecialchars($turma['fim']); ?></p>
                    <p><strong>Professor:</strong> <?php echo htmlspecialchars($turma['professor']); ?></p>
                </div>
                <div class="school-info-box">
                    <h3>Informações da Escola</h3>
                    <p><strong>Localização:</strong> R. Eng. Fernando Vicente Mendes nº5A, 1600-880 Lisboa</p>
                    <p><strong>Telefone:</strong> 215 850 959</p>
                    <p><strong>Horário:</strong> 8:00 - 20:00</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
