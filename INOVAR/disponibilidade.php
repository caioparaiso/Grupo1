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

// Verificar se o cookie formador_id está definido
if (isset($_COOKIE['formador_id'])) {
    $professor_id = $_COOKIE['formador_id'];
} else {
    die("Usuário não autenticado. Por favor, faça login.");
}

// Verificar se há uma atualização de disponibilidade
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dia = $_POST['dia'];
    $valor = $_POST['valor'];

    // Atualizar o valor de disponibilidade para o bloco específico
    $stmt = $conn->prepare("UPDATE disponiblidade SET $dia = ? WHERE professor = ?");
    $stmt->bind_param("ii", $valor, $professor_id);
    $stmt->execute();
    $stmt->close();
}

// Buscar disponibilidade atual para o professor logado
$stmt = $conn->prepare("SELECT * FROM disponiblidade WHERE professor = ?");
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();
$disponibilidade = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Disponibilidade do Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        /* Estilo do cabeçalho */
        .navbar {
            background-color: #4d6f91;
            padding: 15px 0;
        }
        .navbar-nav a {
            color: white;
            margin-right: 20px;
            font-size: 18px;
        }
        .navbar-nav a:hover {
            color: #f8f9fa;
        }
        /* Estilo da seção principal */
        .hero {
            text-align: center;
            padding: 100px 20px;
            background-color: #f8f9fa;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        /* Ajustes de layout */
        .options-container {
            text-align: center;
            margin-top: 30px;
        }
        .option-button {
            width: 200px;
            margin: 15px;
        }
        .user-info {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center; /* Alinha os itens verticalmente */
        }
        .user-info span {
            color: white; /* Define a cor do nome do usuário como branco */
            margin-right: 10px; /* Espaço entre o nome e o ícone */
        }
        .logout-icon {
            color: white; /* Cor do ícone */
            font-size: 24px; /* Tamanho do ícone */
            cursor: pointer; /* Muda o cursor para indicar que é clicável */
            transition: color 0.3s; /* Efeito de transição */
        }
        .logout-icon:hover {
            color: #dc3545; /* Cor do ícone ao passar o mouse */
        }
    </style>
</head>
<body>
    <!-- Navbar com links de navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Nossa Escola</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pagina_inicial.php">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="turmas.php">Turmas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="disponibilidade.php">Disponibilidade</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ícone e nome do usuário no canto superior direito -->
    <div class="user-info">
        <a href="perfil.php" style="text-decoration: none; color: inherit;">
            <span><?php echo $_SESSION['usuario']; ?></span>
        </a>
        <a href="logout.php" class="logout-icon" title="voltar">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

    <div class="container mt-5">
        <h1 class="text-center">Disponibilidade Semanal</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Horário</th>
                        <th>Segunda</th>
                        <th>Terça</th>
                        <th>Quarta</th>
                        <th>Quinta</th>
                        <th>Sexta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Blocos de horário
                    $blocos = [
                        "1" => "08h-11h",
                        "2" => "11h-14h",
                        "3" => "14h-17h",
                        "4" => "17h-20h"
                    ];
                    // Dias da semana com prefixo para os blocos
                    $dias = ["2b", "3b", "4b", "5b", "6b"];

                    // Exibir as linhas para cada bloco de horário
                    foreach ($blocos as $bloco => $horario) {
                        echo "<tr>";
                        echo "<td class='table-secondary'>$horario</td>";

                        // Exibir cada coluna (um dia da semana)
                        foreach ($dias as $dia) {
                            $coluna = $dia . $bloco;
                            $valor = $disponibilidade[$coluna] ?? 0;
                            $status = $valor ? 'Disponível' : 'Indisponível';
                            $nova_disponibilidade = $valor ? 0 : 1;

                            echo "<td>
                                    <form method='post' action=''>
                                        <input type='hidden' name='dia' value='$coluna'>
                                        <input type='hidden' name='valor' value='$nova_disponibilidade'>
                                        <button type='submit' class='btn btn-" . ($valor ? 'success' : 'danger') . "'>
                                            $status
                                        </button>
                                    </form>
                                  </td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Botão de Voltar -->
        <div class="text-center mt-4">
            <a href="professor.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
