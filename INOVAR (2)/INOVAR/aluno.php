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

// Buscar informações da turma
$stmt_turma = $conn->prepare("SELECT nome, curso, inicio, fim, professor FROM turmas WHERE nome = ?");
$stmt_turma->bind_param("s", $turma_id);
$stmt_turma->execute();
$result_turma = $stmt_turma->get_result();
$turma = $result_turma->fetch_assoc();

// Buscar o nome do professor usando o ID obtido na tabela turmas
$professor_id = $turma['professor'];
$stmt_professor = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt_professor->bind_param("i", $professor_id);
$stmt_professor->execute();
$result_professor = $stmt_professor->get_result();
$professor = $result_professor->fetch_assoc();
$professor_nome = $professor ? $professor['nome'] : "Não encontrado";

// Buscar horários da turma
$tabela_horario = "{$turma['nome']}_horario"; // Nome da tabela com base na turma
$query_horario = "SELECT * FROM $tabela_horario";
$result_horario = $conn->query($query_horario);

if ($result_horario->num_rows > 0) {
    $horario = $result_horario->fetch_assoc();
} else {
    $horario = []; // Horário não encontrado, manter vazio
}

// Carregar salas disponíveis
$query_salas = "SELECT id_sala, nome, local FROM sala";
$result_salas = $conn->query($query_salas);

$salas_principais = [];
$salas_secundarias = [];
$salas = [];
if ($result_salas->num_rows > 0) {
    while ($sala = $result_salas->fetch_assoc()) {
        $salas[$sala['id_sala']] = $sala;
        if ($sala['local'] === 'principal') {
            $salas_principais[] = $sala;
        } else if ($sala['local'] === 'secundaria') {
            $salas_secundarias[] = $sala;
        }
    }
}
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
            height: 70px;
            width: auto;
            margin-bottom: 2px;
        }
        .table {
            margin-top: 20px;
            font-size: 14px;
            background: #fff;
            border: 1px solid #007bff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #007bff;
        }
        .table .table-dark {
            background-color: #007bff;
            color: #ffffff;
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
                <div class="user-info">
                    <a href="perfil.php">
                        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar do Aluno">
                    </a>
                    <span><?php echo htmlspecialchars($nome); ?></span>
                    <a href="../INOVAR/logout.php" class="logout-icon" title="Sair">
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
                    <p><strong>Professor:</strong> <?php echo htmlspecialchars($professor_nome); ?></p>
                </div>
                <div class="school-info-box">
                    <h3>Informações da Escola</h3>
                    <p><strong>Localização:</strong> R. Eng. Fernando Vicente Mendes nº5A, 1600-880 Lisboa</p>
                    <p><strong>Telefone:</strong> 215 850 959</p>
                    <p><strong>Horário:</strong> 8:00 - 20:00</p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Horário</th>
                                <th colspan="2" class="text-center">Segunda</th>
                                <th colspan="2" class="text-center">Terça</th>
                                <th colspan="2" class="text-center">Quarta</th>
                                <th colspan="2" class="text-center">Quinta</th>
                                <th colspan="2" class="text-center">Sexta</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>UFCD</th>
                                <th>Sala</th>
                                <th>UFCD</th>
                                <th>Sala</th>
                                <th>UFCD</th>
                                <th>Sala</th>
                                <th>UFCD</th>
                                <th>Sala</th>
                                <th>UFCD</th>
                                <th>Sala</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $blocos = [
                                'b1' => '8:00 - 11:00',
                                'b2' => '11:00 - 14:00',
                                'b3' => '14:00 - 17:00',
                                'b4' => '17:00 - 20:00'
                            ];
                            $dias = ['seg', 'ter', 'qua', 'qui', 'sex'];

                            foreach ($blocos as $bloco => $horario_desc) {
                                echo "<tr>";
                                echo "<td class='text-center'><strong>$horario_desc</strong></td>";
                                foreach ($dias as $dia) {
                                    $ufcd_col = "{$bloco}_{$dia}_ufcd";
                                    $sala_col = "{$bloco}_{$dia}_sala";

                                    // UFCD
                                    $ufcd = isset($horario[$ufcd_col]) ? htmlspecialchars($horario[$ufcd_col]) : "N/A";

                                    // Sala
                                    $sala_id = isset($horario[$sala_col]) ? $horario[$sala_col] : null;
                                    $sala = $sala_id && isset($salas[$sala_id]) ? htmlspecialchars($salas[$sala_id]['nome']) : "N/A";

                                    echo "<td>$ufcd</td>";
                                    echo "<td>$sala</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Exibir salas principais e secundárias -->
                    <div>
                        <h5>Salas no Local Principal</h5>
                        <ul>
                            <?php foreach ($salas_principais as $sala): ?>
                                <li><?php echo htmlspecialchars($sala['nome']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div>
                        <h5>Salas no Local Secundário</h5>
                        <ul>
                            <?php foreach ($salas_secundarias as $sala): ?>
                                <li><?php echo htmlspecialchars($sala['nome']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

