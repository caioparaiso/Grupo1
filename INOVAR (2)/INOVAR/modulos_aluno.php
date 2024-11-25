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
$aluno_id = $aluno['id'];
$turma_id = $aluno['turma'];

// Buscar UFCDs associadas à turma
$search = isset($_POST['search']) ? $_POST['search'] : '';

$stmt_ufcds = $conn->prepare("SELECT ufcd, professor, concluida FROM " . $turma_id . " WHERE ufcd LIKE ?");
$search_param = "%$search%";
$stmt_ufcds->bind_param("s", $search_param);
$stmt_ufcds->execute();
$result_ufcds = $stmt_ufcds->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
            padding: 1rem 1rem;
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
        .container {
            padding-left: 0;
            padding-right: 0;
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
            height: 25px;
            margin-bottom: 2px;
        }
        .ufcd-box {
            margin: 10px;
            padding: 15px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-align: center;
        }
        .ufcd-box:hover {
            background-color: #f0f0f0;
        }
        .ufcd-details {
            margin-top: 5px;
            font-size: 14px;
            color: #6c757d;
        }
        .ufcd-title {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <div class="logo-container">
                <a href="pagina_inicial.php">
                    <img src="https://ita.co.pt/wp-content/uploads/2023/05/logo_sem-fundo.png" alt="Logo ITA" />
                    <img src="https://academia-software.com/wp-content/uploads/2024/05/logo-academia.svg" alt="Logo Academia" />
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="modulos_aluno.php">Módulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modulos_aluno.php">Faltas</a>
                    </li>
                </ul>
                <div class="user-info">
                    <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar do Aluno">
                    <span><?php echo htmlspecialchars($nome); ?></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>UFCDs da Turma</h2>
        <form method="POST" class="mb-4 d-flex align-items-center">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar UFCD" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary ms-2">Pesquisar</button>
        </form>

        <div class="row">
            <?php while ($ufcd = $result_ufcds->fetch_assoc()): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="ufcd-box" onclick="window.location.href='ufcd_info.php?ufcd=<?php echo urlencode($ufcd['ufcd']); ?>'">
                        <div class="ufcd-title"><?php echo htmlspecialchars($ufcd['ufcd']); ?></div>
                        <div class="ufcd-details">
                            <p>Professor: <?php echo htmlspecialchars($ufcd['professor']); ?></p>
                            <p>Concluída: <?php echo htmlspecialchars($ufcd['concluida']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
