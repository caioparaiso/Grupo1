<?php
session_start();

// Verificar se o usuário está logado e se é secretaria
if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] !== 'secretaria' && $_SESSION['tipo'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID da turma foi passado
if (isset($_GET['id'])) {
    $turma_id = $_GET['id'];

    // Preparar a consulta para pegar os detalhes da turma
    $stmt = $conn->prepare("SELECT nome, inicio, curso, professor, fim FROM turmas WHERE id = ?");
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $turma = $result->fetch_assoc();
    } else {
        die("Turma não encontrada.");
    }

    $nome_tabela_ufcd = $turma['nome'];

    // Consulta para pegar os alunos da turma
    $stmt_alunos = $conn->prepare("SELECT id, nome, avatar FROM alunos WHERE turma = (SELECT nome FROM turmas WHERE id = ?)");
    $stmt_alunos->bind_param("i", $turma_id);
    $stmt_alunos->execute();
    $alunos_result = $stmt_alunos->get_result();

    // Adicionar Aluno
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_aluno'])) {
        $nome = $_POST['nome'];
        $turma = $_POST['turma'];
        $nif = $_POST['nif'];
        $nascimento = $_POST['nascimento'];
        $nacionalidade = $_POST['nacionalidade'];
        $email = $_POST['email'];
        $morada = $_POST['morada'];

        $stmt_insert_aluno = $conn->prepare("INSERT INTO alunos (nome, turma, nif, nascimento, nacionalidade, email, morada) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert_aluno->bind_param("sssssss", $nome, $turma, $nif, $nascimento, $nacionalidade, $email, $morada);

        if ($stmt_insert_aluno->execute()) {
            echo "<div class='alert alert-success'>Aluno adicionado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao adicionar aluno: " . $conn->error . "</div>";
        }
    }

    // Remover Aluno
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_aluno'])) {
        $aluno_id = $_POST['aluno_id'];

        $stmt_delete_aluno = $conn->prepare("DELETE FROM alunos WHERE id = ?");
        $stmt_delete_aluno->bind_param("i", $aluno_id);

        if ($stmt_delete_aluno->execute()) {
            echo "<div class='alert alert-success'>Aluno removido com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao remover aluno: " . $conn->error . "</div>";
        }
    }
} else {
    die("ID da turma não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .user-info {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center;
        }
        .user-info i {
            margin-right: 5px;
        }
        .aluno-card {
            width: 150px;
            margin: 10px;
            text-align: center;
        }
        .aluno-avatar {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }
        .add-aluno-form {
            display: none;
        }
        .add-icon {
            cursor: pointer;
            font-size: 24px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detalhes da Turma: <span class="text-primary"><?php echo htmlspecialchars($turma['nome']); ?></span></h1>
        <ul class="list-group">
            <li class="list-group-item">Início: <?php echo htmlspecialchars($turma['inicio']); ?> | Fim: <?php echo htmlspecialchars($turma['fim']); ?></li>
            <li class="list-group-item">Curso: <?php echo htmlspecialchars($turma['curso']); ?></li>
            <li class="list-group-item">Responsável Pedagógico: <?php echo htmlspecialchars($turma['professor']); ?></li>
        </ul>

        <h3 class="mt-4">Alunos da Turma</h3>
        <div class="row">
            <?php if ($alunos_result->num_rows > 0): ?>
                <?php while ($aluno = $alunos_result->fetch_assoc()): ?>
                    <div class="col-3 aluno-card">
                        <img src="<?php echo htmlspecialchars($aluno['avatar']); ?>" alt="Avatar" class="aluno-avatar">
                        <h5><?php echo htmlspecialchars($aluno['nome']); ?></h5>
                        <form method="POST" class="mt-2">
                            <input type="hidden" name="aluno_id" value="<?php echo htmlspecialchars($aluno['id']); ?>">
                            <button type="submit" name="remove_aluno" class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Não há alunos cadastrados nesta turma.</p>
            <?php endif; ?>
        </div>

        <!-- Adicionar Aluno -->
        <h3 class="mt-4">Adicionar Aluno</h3>
        <button class="btn btn-primary" onclick="document.querySelector('.add-aluno-form').style.display = 'block';">Adicionar Aluno</button>

        <!-- Formulário de Adicionar Aluno -->
        <form class="add-aluno-form mt-3" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="nif" class="form-label">NIF</label>
                <input type="text" class="form-control" id="nif" name="nif" required>
            </div>
            <div class="mb-3">
                <label for="nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="nascimento" name="nascimento" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidade" class="form-label">Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="morada" class="form-label">Morada</label>
                <input type="text" class="form-control" id="morada" name="morada" required>
            </div>
            <input type="hidden" name="turma" value="<?php echo htmlspecialchars($turma['nome']); ?>">
            <button type="submit" name="add_aluno" class="btn btn-success">Adicionar Aluno</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
