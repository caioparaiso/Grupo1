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

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: index_alunos.php");
    exit();
}

// Verificar se o número da UFCD foi passado como parâmetro
if (!isset($_GET['numero'])) {
    echo "UFCD não especificada.";
    exit();
}

$numero = $_GET['numero'];
$nome_aluno = $_SESSION['usuario'];

// Buscar a turma do aluno na base de dados
$stmt_turma = $conn->prepare("SELECT turma FROM alunos WHERE nome = ? LIMIT 1");
$stmt_turma->bind_param("s", $nome_aluno);
$stmt_turma->execute();
$result_turma = $stmt_turma->get_result();

if ($result_turma->num_rows === 0) {
    echo "Turma não encontrada.";
    exit();
}

$aluno = $result_turma->fetch_assoc();
$turma_id = $aluno['turma'];

// Buscar detalhes da UFCD na base de dados com base na turma do aluno
$stmt = $conn->prepare("SELECT numero, professor, horas, concluida, tipo FROM " . $turma_id . " WHERE numero = ? LIMIT 1");
$stmt->bind_param("s", $numero);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "UFCD não encontrada.";
    exit();
}

$ufcd = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da UFCD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .ufcd-details {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .ufcd-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .ufcd-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .description {
            margin-top: 15px;
        }
        .description-title {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="ufcd-details">
            <div class="ufcd-title">UFCD: <?php echo htmlspecialchars($ufcd['numero']); ?></div>
            <div class="ufcd-info">
                <p><strong>Professor:</strong> <?php echo htmlspecialchars($ufcd['professor']); ?></p>
                <p><strong>Horas:</strong> <?php echo htmlspecialchars($ufcd['horas']); ?></p>
                <p><strong>Horas Concluídas:</strong> <?php echo htmlspecialchars($ufcd['concluida']); ?></p>
                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($ufcd['tipo']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt_turma->close();
$stmt->close();
$conn->close();
?>
