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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Turma</title>
    <link rel="shortcut icon" href="escola_logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilo da página */
        body {
            background-image: url('imagemjpg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #343a40;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h1 {
            color: #007bff;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .user-info {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center;
            color: #343a40;
            font-weight: bold;
        }
        .user-info i {
            margin-right: 5px;
        }
        .btn-voltar {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-voltar:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
            text-decoration: none;
        }
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        
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
            <button type="submit" class="btn btn-primary btn-block w-100">Ver Horário</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn-voltar">← Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
