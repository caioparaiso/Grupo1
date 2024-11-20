<?php
session_start();

// Verificar se o usuário está logado e se é secretaria
if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] !== 'secretaria' && $_SESSION['tipo'] !== 'admin')) {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola'; // Nome da base de dados
$user = 'root'; // Usuário do MySQL
$pass = ''; // Senha do MySQL (se houver)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar se a conexão falhou
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

    // Verificar se a turma foi encontrada
    if ($result->num_rows > 0) {
        $turma = $result->fetch_assoc();
    } else {
        die("Turma não encontrada.");
    }

    // Definir o nome da tabela a partir do nome da turma
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

        // Inserir o novo aluno na tabela
        $stmt_insert_aluno = $conn->prepare("INSERT INTO alunos (nome, turma, nif, nascimento, nacionalidade, email, morada) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert_aluno->bind_param("sssssss", $nome, $turma, $nif, $nascimento, $nacionalidade, $email, $morada);

        if ($stmt_insert_aluno->execute()) {
            echo "<div class='alert alert-success'>Aluno adicionado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao adicionar aluno: " . $conn->error . "</div>";
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
    <link rel="shortcut icon" href="escola_logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos para o layout */
        .user-info {
            position: absolute;
            top: 15px; /* Distância do topo */
            right: 15px; /* Distância da direita */
            display: flex;
            align-items: center;
        }
        .user-info i {
            margin-right: 5px; /* Espaçamento entre o ícone e o nome */
        }
        .aluno-card {
            width: 150px; /* Largura do cartão */
            margin: 10px; /* Margem entre os cartões */
            text-align: center; /* Centraliza o texto */
        }
        .aluno-avatar {
            width: 100%; /* Largura do avatar */
            height: auto; /* Altura automática para manter a proporção */
            border-radius: 50%; /* Torna o avatar redondo */
        }
        .add-aluno-form {
            display: none; /* Oculta o formulário inicialmente */
        }
        .add-icon {
            cursor: pointer;
            font-size: 24px;
            color: #007bff;
        }
        /* Estilos futuristas */
        body {
            background-color: #ffffff;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .table {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #007bff;
            color: #333;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 1);
            border: 1px solid #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
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
                    </div>
                    <?php endwhile; ?>
            <?php else: ?>
                <p>Não há alunos cadastrados nesta turma.</p>
            <?php endif; ?>
        </div>

        <h3 class="mt-4">Adicionar Aluno</h3>
        <i class="fas fa-plus add-icon" onclick="document.querySelector('.add-aluno-form').style.display = 'block';"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>

