<?php
session_start();

// Configuração de conexão com o banco de dados
$host = 'localhost';
$dbname = 'escola';
$username = 'root';
$password = '';

try {
    // Conectar ao banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

// Inserir uma nova sala
if (isset($_POST['add_sala'])) {
    $nome = $_POST['nome'];
    $pc = isset($_POST['pc']) ? 1 : 0;
    $office = isset($_POST['office']) ? 1 : 0;
    $adobe = isset($_POST['adobe']) ? 1 : 0;
    $vm = isset($_POST['VM']) ? 1 : 0;
    $vscode = isset($_POST['VSCODE']) ? 1 : 0;
    $projetor = isset($_POST['projetor']) ? 1 : 0;

    $sql = "INSERT INTO sala (nome, pc, office, adobe, VM, VSCODE, projetor) VALUES (:nome, :pc, :office, :adobe, :vm, :vscode, :projetor)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':pc', $pc);
    $stmt->bindParam(':office', $office);
    $stmt->bindParam(':adobe', $adobe);
    $stmt->bindParam(':vm', $vm);
    $stmt->bindParam(':vscode', $vscode);
    $stmt->bindParam(':projetor', $projetor);
    $stmt->execute();
    header("Location: salas.php");
}

// Editar uma sala
if (isset($_POST['edit_sala'])) {
    $id_sala = $_POST['id_sala'];
    $nome = $_POST['nome'];
    $pc = isset($_POST['pc']) ? 1 : 0;
    $office = isset($_POST['office']) ? 1 : 0;
    $adobe = isset($_POST['adobe']) ? 1 : 0;
    $vm = isset($_POST['VM']) ? 1 : 0;
    $vscode = isset($_POST['VSCODE']) ? 1 : 0;
    $projetor = isset($_POST['projetor']) ? 1 : 0;

    $sql = "UPDATE sala SET nome = :nome, pc = :pc, office = :office, adobe = :adobe, VM = :vm, VSCODE = :vscode, projetor = :projetor WHERE id_sala = :id_sala";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_sala', $id_sala);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':pc', $pc);
    $stmt->bindParam(':office', $office);
    $stmt->bindParam(':adobe', $adobe);
    $stmt->bindParam(':vm', $vm);
    $stmt->bindParam(':vscode', $vscode);
    $stmt->bindParam(':projetor', $projetor);
    $stmt->execute();
    header("Location: salas.php");
}

// Deletar uma sala
if (isset($_GET['delete'])) {
    $id_sala = $_GET['delete'];
    $sql = "DELETE FROM sala WHERE id_sala = :id_sala";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_sala', $id_sala);
    $stmt->execute();
    header("Location: salas.php");
}

// Listar todas as salas
$sql = "SELECT * FROM sala";
$stmt = $conn->prepare($sql);
$stmt->execute();
$salas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Salas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleForm() {
            const formContainer = document.getElementById('formContainer');
            formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gerenciamento de Salas</h2>
    <div id="formContainer" style="display: none;">
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Sala</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="pc" class="form-label">PC</label>
                <input type="checkbox" name="pc" id="pc">
            </div>
            <div class="mb-3">
                <label for="office" class="form-label">Office</label>
                <input type="checkbox" name="office" id="office">
            </div>
            <div class="mb-3">
                <label for="adobe" class="form-label">Adobe</label>
                <input type="checkbox" name="adobe" id="adobe">
            </div>
            <div class="mb-3">
                <label for="VM" class="form-label">VM</label>
                <input type="checkbox" name="VM" id="VM">
            </div>
            <div class="mb-3">
                <label for="VSCODE" class="form-label">VSCODE</label>
                <input type="checkbox" name="VSCODE" id="VSCODE">
            </div>
            <div class="mb-3">
                <label for="projetor" class="form-label">Projetor</label>
                <input type="checkbox" name="projetor" id="projetor">
            </div>
            <button type="submit" name="add_sala" class="btn btn-success">Adicionar Sala</button>
            <button type="button" class="btn btn-secondary" onclick="toggleForm()">Cancelar</button>
        </form>
    </div>

    <hr>

    <button class="btn btn-primary mb-3" onclick="toggleForm()">Criar Sala</button>
    <h3 class="mb-3">Salas</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>PC</th>
                <th>Office</th>
                <th>Adobe</th>
                <th>VM</th>
                <th>VSCODE</th>
                <th>Projetor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
                <tr>
                    <td>Sala <?php echo $sala['nome']; ?></td>
                    <td><?php echo $sala['pc'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $sala['office'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $sala['adobe'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $sala['VM'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $sala['VSCODE'] ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $sala['projetor'] ? 'Sim' : 'Não'; ?></td>
                    <td>
                        <a href="editar_sala.php?id_sala=<?php echo $sala['id_sala']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?delete=<?php echo $sala['id_sala']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover?')">Remover</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
