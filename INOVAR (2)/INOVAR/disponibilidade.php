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

// Buscar bloqueios definidos na tabela bloqueios
$bloqueios = [];
$sql_bloqueios = "SELECT dia_semana, hora_inicio, hora_fim FROM bloqueios";
$result_bloqueios = $conn->query($sql_bloqueios);

if ($result_bloqueios->num_rows > 0) {
    while ($row = $result_bloqueios->fetch_assoc()) {
        $bloqueios[] = $row;
    }
}
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
        .btn-disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>
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
                "1" => "08:00:00",
                "2" => "11:00:00",
                "3" => "14:00:00",
                "4" => "17:00:00"
            ];
            $fim_blocos = [
                "1" => "11:00:00",
                "2" => "14:00:00",
                "3" => "17:00:00",
                "4" => "20:00:00"
            ];

            // Dias da semana com prefixo para os blocos
            $dias = ["2b", "3b", "4b", "5b", "6b"];
            $dias_semana = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta"];

            // Verificar bloqueios para cada horário e dia
            function is_bloqueado($dia, $hora_inicio, $hora_fim, $bloqueios)
            {
                foreach ($bloqueios as $bloqueio) {
                    if (strtolower($bloqueio['dia_semana']) === strtolower($dia)) {
                        if (
                            $hora_inicio >= $bloqueio['hora_inicio'] &&
                            $hora_fim <= $bloqueio['hora_fim']
                        ) {
                            return true;
                        }
                    }
                }
                return false;
            }

            // Exibir as linhas para cada bloco de horário
            foreach ($blocos as $bloco => $hora_inicio) {
                echo "<tr>";
                echo "<td class='table-secondary'>" . substr($hora_inicio, 0, 5) . "-" . substr($fim_blocos[$bloco], 0, 5) . "</td>";

                // Exibir cada coluna (um dia da semana)
                foreach ($dias as $index => $dia) {
                    $coluna = $dia . $bloco;
                    $valor = $disponibilidade[$coluna] ?? 0;
                    $status = $valor ? 'Disponível' : 'Indisponível';
                    $nova_disponibilidade = $valor ? 0 : 1;

                    // Verificar se o horário está bloqueado
                    $dia_semana = $dias_semana[$index];
                    $hora_fim = $fim_blocos[$bloco];
                    $bloqueado = is_bloqueado($dia_semana, $hora_inicio, $hora_fim, $bloqueios);

                    echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='dia' value='$coluna'>
                                <input type='hidden' name='valor' value='$nova_disponibilidade'>
                                <button type='submit' class='btn btn-" . ($valor ? 'success' : 'danger') . " " . ($bloqueado ? 'btn-disabled' : '') . "' " . ($bloqueado ? 'disabled' : '') . ">
                                    " . ($bloqueado ? 'Bloqueado' : $status) . "
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
    <div class="text-center mt-4">
        <a href="professor.php" class="btn btn-primary">Voltar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
