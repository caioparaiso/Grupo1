<?php
session_start();

// Configuração de conexão com o banco de dados
$host = 'localhost';
$dbname = 'escola'; // Nome do seu banco de dados
$username = 'root'; // Usuário
$password = ''; // Senha

try {
    // Conectar ao banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

// Buscar dados da sala para editar
if (isset($_GET['id_sala'])) {
    $id_sala = $_GET['id_sala'];
    $sql = "SELECT * FROM sala WHERE id_sala = :id_sala";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_sala', $id_sala);
    $stmt->execute();
    $sala = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Se a sala não existir
    if (!$sala) {
        echo "Sala não encontrada.";
        exit;
    }
}

// Editar dados da sala
if (isset($_POST['edit_sala'])) {
    $nome = $_POST['nome'];
    $pc = isset($_POST['pc']) ? 1 : 0;
    $office = isset($_POST['office']) ? 1 : 0;
    $adobe = isset($_POST['adobe']) ? 1 : 0;
    $vm = isset($_POST['VM']) ? 1 : 0;
    $vscode = isset($_POST['VSCODE']) ? 1 : 0;
    $projetor = isset($_POST['projetor']) ? 1 : 0;

    $sql = "UPDATE sala SET nome = :nome, pc = :pc, office = :office, adobe = :adobe, VM = :vm, VSCODE = :vscode, projetor = :projetor WHERE id_sala = :id_sala";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_sala', $_POST['id_sala']);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':pc', $pc);
    $stmt->bindParam(':office', $office);
    $stmt->bindParam(':adobe', $adobe);
    $stmt->bindParam(':vm', $vm);
    $stmt->bindParam(':vscode', $vscode);
    $stmt->bindParam(':projetor', $projetor);
    $stmt->execute();

    // Redirecionar após salvar
    header("Location: salas.php");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Sala</h2>

    <!-- Formulário de Edição de Sala -->
    <form method="POST">
        <input type="hidden" name="id_sala" value="<?php echo $sala['id_sala']; ?>">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Sala</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $sala['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="pc" class="form-label">PC</label>
            <input type="checkbox" name="pc" id="pc" <?php echo $sala['pc'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="office" class="form-label">Office</label>
            <input type="checkbox" name="office" id="office" <?php echo $sala['office'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="adobe" class="form-label">Adobe</label>
            <input type="checkbox" name="adobe" id="adobe" <?php echo $sala['adobe'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="VM" class="form-label">VM</label>
            <input type="checkbox" name="VM" id="VM" <?php echo $sala['VM'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="VSCODE" class="form-label">VSCODE</label>
            <input type="checkbox" name="VSCODE" id="VSCODE" <?php echo $sala['VSCODE'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="projetor" class="form-label">Projetor</label>
            <input type="checkbox" name="projetor" id="projetor" <?php echo $sala['projetor'] ? 'checked' : ''; ?>>
        </div>
        <button type="submit" name="edit_sala" class="btn btn-success">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
