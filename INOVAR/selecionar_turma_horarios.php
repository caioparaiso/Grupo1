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

// Buscar as turmas disponíveis
$query = "SHOW TABLES LIKE '%_horario%'";
$result = $conn->query($query);

$turmas = [];
while ($row = $result->fetch_row()) {
    $turmas[] = str_replace('_horario', '', $row[0]);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Selecionar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Selecionar Turma</h1>
        <form action="horarios.php" method="GET">
            <div class="mb-3">
                <label for="turma" class="form-label">Escolha uma turma</label>
                <select name="turma" id="turma" class="form-control">
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma; ?>"><?php echo $turma; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ver Horário</button>
        </form>
    </div>
</body>
</html>
