<?php
// Conectar à base de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o nome da turma foi enviado
if (isset($_GET['turma'])) {
    $turma = $_GET['turma'];
} else {
    die("Nome da turma não especificado.");
}

// Buscar os horários para a turma selecionada
$query = "SELECT * FROM `{$turma}_horario`";
$result = $conn->query($query);

// Caso não haja dados para a turma
if ($result->num_rows == 0) {
    die("Horários não encontrados para a turma.");
}

$row = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Horários da Turma <?php echo htmlspecialchars($turma); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Horário da Turma: <?php echo htmlspecialchars($turma); ?></h1>
        <form id="form-horarios">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Bloco</th>
                        <th>Segunda - UFCD</th>
                        <th>Segunda - Sala</th>
                        <th>Terça - UFCD</th>
                        <th>Terça - Sala</th>
                        <th>Quarta - UFCD</th>
                        <th>Quarta - Sala</th>
                        <th>Quinta - UFCD</th>
                        <th>Quinta - Sala</th>
                        <th>Sexta - UFCD</th>
                        <th>Sexta - Sala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Blocos de horário
                    $blocos = ['b1', 'b2', 'b3', 'b4'];
                    $semana = ['seg', 'ter', 'qua', 'qui', 'sex'];
                    // Exibir as linhas para cada bloco de horário
                    foreach ($blocos as $bloco) {
                        echo "<tr>";
                        echo "<td>$bloco</td>";
                                             
                        for ($dia = 0; $dia <= 4; $dia++) {
                            //$ufcd_col = strtolower(date('D', strtotime("Sunday +$dia days"))) . '_ufcd';
                            //$sala_col = strtolower(date('D', strtotime("Sunday +$dia days"))) . '_sala';
                            $dia_1 = $dia + 1;
                            echo "<td><input type='text' data-id='{$dia_1}' name='{$semana[$dia]}_ufcd' value='' class='form-control'></td>";
                            echo "<td><input type='text' data-id='{$dia_1}' name='{$semana[$dia]}_sala' value='' class='form-control'></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script>
        // AJAX para salvar alterações sem recarregar a página
        $('#form-horarios').submit(function(event) {
            event.preventDefault(); // Evitar o envio padrão do formulário

            // Enviar os dados via AJAX
            $.ajax({
                url: 'salvar_horarios.php', // O script para salvar no banco de dados
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Horários atualizados com sucesso!');
                },
                error: function() {
                    alert('Erro ao atualizar os horários!');
                }
            });
        });
    </script>
</body>
</html>
