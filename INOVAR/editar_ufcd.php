<?php
session_start();

// Configuração de conexão com o banco de dados
$host = 'localhost';
$dbname = 'escola';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Verificar se o ID da UFCD foi passado via GET
if (isset($_GET['ufcd'])) {
    $ufcd_id = $_GET['ufcd'];

    // Buscar UFCD para edição
    $sql = "SELECT * FROM ufcds WHERE ufcd = :ufcd";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ufcd' => $ufcd_id]);
    $ufcd = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualizar UFCD
if (isset($_POST['update_ufcd'])) {
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

    // Atualizar os dados no banco de dados
    $sql = "UPDATE ufcds SET nome = :nome, horas = :horas, periodo = :periodo, componente = :componente, dominio = :dominio,
            pc = :pc, office = :office, adobe = :adobe, vm = :vm, vscode = :vscode, projetor = :projetor
            WHERE ufcd = :ufcd";
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
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar UFCD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar UFCD</h2>

    <form method="POST">
        <input type="hidden" name="ufcd" value="<?php echo $ufcd['ufcd']; ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $ufcd['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="horas" class="form-label">Horas</label>
            <input type="number" class="form-control" id="horas" name="horas" value="<?php echo $ufcd['horas']; ?>">
        </div>
        <div class="mb-3">
            <label for="periodo" class="form-label">Período</label>
            <input type="number" class="form-control" id="periodo" name="periodo" value="<?php echo $ufcd['periodo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="componente" class="form-label">Componente</label>
            <input type="text" class="form-control" id="componente" name="componente" value="<?php echo $ufcd['componente']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="dominio" class="form-label">Domínio</label>
            <input type="text" class="form-control" id="dominio" name="dominio" value="<?php echo $ufcd['dominio']; ?>">
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="pc" name="pc" <?php echo $ufcd['pc'] ? 'checked' : ''; ?>>
            <label for="pc" class="form-check-label">PC</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="office" name="office" <?php echo $ufcd['office'] ? 'checked' : ''; ?>>
            <label for="office" class="form-check-label">Office</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="adobe" name="adobe" <?php echo $ufcd['adobe'] ? 'checked' : ''; ?>>
            <label for="adobe" class="form-check-label">Adobe</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="vm" name="vm" <?php echo $ufcd['vm'] ? 'checked' : ''; ?>>
            <label for="vm" class="form-check-label">VM</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="vscode" name="vscode" <?php echo $ufcd['vscode'] ? 'checked' : ''; ?>>
            <label for="vscode" class="form-check-label">VS Code</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="projetor" name="projetor" <?php echo $ufcd['projetor'] ? 'checked' : ''; ?>>
            <label for="projetor" class="form-check-label">Projetor</label>
        </div>

        <button type="submit" name="update_ufcd" class="btn btn-primary mt-3">Atualizar UFCD</button>
    </form>
</div>

</body>
</html>
