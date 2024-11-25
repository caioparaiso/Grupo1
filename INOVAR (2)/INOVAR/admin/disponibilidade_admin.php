<?php
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola'; // Nome da base de dados
$user = 'root'; // Usuário do MySQL
$pass = ''; // Senha do MySQL (se houver)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dia_semana = $_POST['dia_semana'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    // Atualiza o bloqueio no banco de dados
    $stmt = $conn->prepare("UPDATE bloqueios SET dia_semana = ?, hora_inicio = ?, hora_fim = ? WHERE id = 1");
    $stmt->bind_param("sss", $dia_semana, $hora_inicio, $hora_fim);

    if ($stmt->execute()) {
        $mensagem = "Bloqueio atualizado com sucesso!";
    } else {
        $erro = "Erro ao atualizar o bloqueio: " . $conn->error;
    }
}

// Recupera os dados do bloqueio atual
$result = $conn->query("SELECT dia_semana, hora_inicio, hora_fim FROM bloqueios WHERE id = 1");
$bloqueio = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Bloqueio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Alterar Bloqueio</h2>
    <?php if (isset($mensagem)): ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="dia_semana" class="form-label">Dia da Semana</label>
            <select class="form-select" name="dia_semana" id="dia_semana" required>
                <option value="segunda" <?= $bloqueio['dia_semana'] === 'segunda' ? 'selected' : '' ?>>Segunda-feira</option>
                <option value="terca" <?= $bloqueio['dia_semana'] === 'terca' ? 'selected' : '' ?>>Terça-feira</option>
                <option value="quarta" <?= $bloqueio['dia_semana'] === 'quarta' ? 'selected' : '' ?>>Quarta-feira</option>
                <option value="quinta" <?= $bloqueio['dia_semana'] === 'quinta' ? 'selected' : '' ?>>Quinta-feira</option>
                <option value="sexta" <?= $bloqueio['dia_semana'] === 'sexta' ? 'selected' : '' ?>>Sexta-feira</option>
                <option value="sabado" <?= $bloqueio['dia_semana'] === 'sabado' ? 'selected' : '' ?>>Sábado</option>
                <option value="domingo" <?= $bloqueio['dia_semana'] === 'domingo' ? 'selected' : '' ?>>Domingo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Início</label>
            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" value="<?= $bloqueio['hora_inicio'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="hora_fim" class="form-label">Hora de Fim</label>
            <input type="time" class="form-control" name="hora_fim" id="hora_fim" value="<?= $bloqueio['hora_fim'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Atualizar Bloqueio</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
