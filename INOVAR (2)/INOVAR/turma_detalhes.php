<?php
session_start();

// Verificar se o usuário está logado e se é professor
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'professor') {
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

// Verificar se o ID da turma foi passado
if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];

    // Preparar a consulta para pegar os detalhes da turma
    $stmt = $conn->prepare("SELECT nome, inicio, curso, professor, fim FROM turmas WHERE id = ?");
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se a turma foi encontrada
    if ($result->num_rows > 0) {
        $turma = $result->fetch_assoc();
    } else {
        die("Turma não encontrada.");
    }

    // Definir o nome da tabela a partir do nome da turma
    $nome_tabela_ufcd = $turma['nome'];

    // Preparar a consulta para pegar as UFCDs associadas ao professor logado
    $stmt_ufcd = $conn->prepare("SELECT numero, horas, concluida, professor FROM `$nome_tabela_ufcd` WHERE professor = ?");
    $stmt_ufcd->bind_param("s", $_SESSION['usuario']);
    $stmt_ufcd->execute();
    $ufcd_result = $stmt_ufcd->get_result();

} else {
    die("ID da turma não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .ufcd-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .ufcd-box {
            flex: 1 1 calc(16.66% - 15px); /* Tamanho da caixa para caber 6 por linha */
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .ufcd-title {
            font-weight: bold;
            color: #007bff;
        }
        .progress {
            height: 1.2rem;
            margin-top: 10px;
        }
        .progress-text {
            font-size: 0.9rem;
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Turma: <?php echo htmlspecialchars($turma['nome']); ?></h1>
        <ul class="list-group mb-4">
            <li class="list-group-item">Início: <?php echo htmlspecialchars($turma['inicio']); ?> | Fim: <?php echo htmlspecialchars($turma['fim']); ?></li>
            <li class="list-group-item">Curso: <?php echo htmlspecialchars($turma['curso']); ?></li>
            <li class="list-group-item">Responsável Pedagógico: <?php echo htmlspecialchars($turma['professor']); ?></li>
        </ul>

        <h3 class="mb-3">UFCDs Associadas</h3>
        <div class="ufcd-container">
            <?php if ($ufcd_result->num_rows > 0): ?>
                <?php while ($ufcd = $ufcd_result->fetch_assoc()): ?>
                    <div class="ufcd-box">
                        <div class="ufcd-title">UFCD <?php echo htmlspecialchars($ufcd['numero']); ?></div>
                        <div>Horas Totais: <?php echo htmlspecialchars($ufcd['horas']); ?></div>
                        <div>Horas Concluídas: <?php echo htmlspecialchars($ufcd['concluida']); ?></div>
                        <div class="progress mt-2">
                            <?php 
                                // Calcular a porcentagem de conclusão
                                $horas_totais = $ufcd['horas'];
                                $horas_concluidas = $ufcd['concluida'];
                                $porcentagem = $horas_totais > 0 ? ($horas_concluidas / $horas_totais) * 100 : 0;
                            ?>
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentagem; ?>%;" aria-valuenow="<?php echo $porcentagem; ?>" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-text"><?php echo round($porcentagem) . '%'; ?></span>
                            </div>
                        </div>
                        <div class="mt-2">Professor: <?php echo htmlspecialchars($ufcd['professor']); ?></div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma UFCD associada ao professor logado.</p>
            <?php endif; ?>
        </div>

        <a href="turmas.php" class="btn btn-secondary mt-4">Voltar</a>
    </div>
</body>
</html>
