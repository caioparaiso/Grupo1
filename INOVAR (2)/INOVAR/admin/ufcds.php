<?php
session_start();

// Configuração de conexão com o banco de dados
$host = 'localhost';
$dbname = 'escola'; // Nome do seu banco de dados
$username = 'root'; // Usuário
$password = ''; // Senha

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Adicionar UFCD
if (isset($_POST['add_ufcd'])) {
    $ufcd = $_POST['ufcd'];
    $nome = $_POST['nome'];
    $horas = $_POST['horas'];
    $periodo = $_POST['periodo'];
    $componente = $_POST['componente'];
    $dominio = $_POST['dominio'];
    $pc = isset($_POST['pc']) ? 1 : 0;
    $office = isset($_POST['office']) ? 1 : 0;
    $adobe = isset($_POST['adobe']) ? 1 : 0;
    $vm = isset($_POST['vm']) ? 1 : 0;
    $vscode = isset($_POST['vscode']) ? 1 : 0;
    $projetor = isset($_POST['projetor']) ? 1 : 0;

    $sql = "INSERT INTO ufcds (ufcd, nome, horas, periodo, componente, dominio, pc, office, adobe, vm, vscode, projetor) 
            VALUES (:ufcd, :nome, :horas, :periodo, :componente, :dominio, :pc, :office, :adobe, :vm, :vscode, :projetor)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':ufcd' => $ufcd,
        ':nome' => $nome,
        ':horas' => $horas,
        ':periodo' => $periodo,
        ':componente' => $componente,
        ':dominio' => $dominio,
        ':pc' => $pc,
        ':office' => $office,
        ':adobe' => $adobe,
        ':vm' => $vm,
        ':vscode' => $vscode,
        ':projetor' => $projetor
    ]);
    header("Location: ufcds.php");
    exit;
}

// Deletar UFCD
if (isset($_GET['delete'])) {
    $ufcd = $_GET['delete'];
    $sql = "DELETE FROM ufcds WHERE ufcd = :ufcd";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ufcd' => $ufcd]);
    header("Location: ufcds.php");
    exit;
}

// Buscar UFCDs
$sql = "SELECT * FROM ufcds";
$stmt = $conn->prepare($sql);
$stmt->execute();
$ufcds = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar UFCDs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS para esconder o formulário de adicionar UFCD inicialmente e customizar as caixas -->
    <style>
        #add-ufcd-form {
            display: none;
        }

        .ufcd-box {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .ufcd-box:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .ufcd-title {
            font-size: 18px;
            font-weight: bold;
        }

        .ufcd-actions {
            margin-top: 10px;
        }

        .ufcd-actions a {
            margin-right: 10px;
        }
    </style>
    
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gerenciamento de UFCDs</h2>

    <!-- Botão para exibir o formulário de adicionar UFCD -->
    <button class="btn btn-success mb-3" onclick="toggleForm()">Adicionar UFCD</button>

    <!-- Formulário para adicionar uma nova UFCD -->
    <form id="add-ufcd-form" method="POST" class="mb-4">
        <h4>Adicionar UFCD</h4>
        <div class="mb-3">
            <label for="ufcd" class="form-label">Número UFCD</label>
            <input type="text" class="form-control" id="ufcd" name="ufcd" required>
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="horas" class="form-label">Horas</label>
            <input type="number" class="form-control" id="horas" name="horas">
        </div>
        <div class="mb-3">
            <label for="periodo" class="form-label">Período</label>
            <input type="number" class="form-control" id="periodo" name="periodo" required>
        </div>
        <div class="mb-3">
            <label for="componente" class="form-label">Componente</label>
            <input type="text" class="form-control" id="componente" name="componente" required>
        </div>
        <div class="mb-3">
            <label for="dominio" class="form-label">Domínio</label>
            <input type="text" class="form-control" id="dominio" name="dominio">
        </div>

        <!-- Checkboxes para adicionar softwares e equipamentos -->
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="pc" name="pc">
            <label for="pc" class="form-check-label">PC</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="office" name="office">
            <label for="office" class="form-check-label">Office</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="adobe" name="adobe">
            <label for="adobe" class="form-check-label">Adobe</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="vm" name="vm">
            <label for="vm" class="form-check-label">VM</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="vscode" name="vscode">
            <label for="vscode" class="form-check-label">VS Code</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="projetor" name="projetor">
            <label for="projetor" class="form-check-label">Projetor</label>
        </div>

        <button type="submit" name="add_ufcd" class="btn btn-primary mt-3">Adicionar UFCD</button>
    </form>

    <!-- Exibindo as UFCDs em caixas -->
    <div class="row">
        <?php foreach ($ufcds as $ufcd): ?>
        <div class="col-md-4">
            <div class="ufcd-box">
                <div class="ufcd-title"><?php echo $ufcd['ufcd'] . ' - ' . $ufcd['nome']; ?></div>
                <div class="ufcd-actions">
                    <a href="editar_ufcd.php?ufcd=<?php echo $ufcd['ufcd']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="ufcds.php?delete=<?php echo $ufcd['ufcd']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta UFCD?')">Excluir</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- JavaScript para exibir/ocultar o formulário -->
<script>
    function toggleForm() {
        var form = document.getElementById('add-ufcd-form');
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>

</body>
</html>
