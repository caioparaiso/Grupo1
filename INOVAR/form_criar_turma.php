<?php
session_start();

// Verificar se o usuário está logado e se é secretaria
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'secretaria') {
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

// Preparar a consulta para pegar todos os professores
$professoresResult = $conn->query("SELECT id, nome FROM usuarios WHERE tipo = 'professor'");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Fundo claro */
            color: #343a40; /* Texto escuro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff; /* Fundo branco para o container */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Sombra leve */
            max-width: 600px;
        }
        h1 {
            color: #007bff; /* Título azul */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #28a745; /* Verde */
            border-color: #28a745;
            transition: all 0.3s;
            color: #ffffff; /* Texto branco */
            font-weight: bold;
        }
        .btn-success:hover {
            background-color: #218838; /* Verde mais escuro no hover */
        }
        .btn-secondary {
            margin-top: 10px;
        }
        label {
            font-weight: bold; /* Negrito para rótulos */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Criar Nova Turma</h1>
        <form action="criar_turma.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Turma</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="ano_inicio" class="form-label">Ano de Início</label>
                <input type="number" class="form-control" id="ano_inicio" name="ano_inicio" required>
            </div>
            <div class="mb-3">
                <label for="ano_fim" class="form-label">Ano de Fim</label>
                <input type="number" class="form-control" id="ano_fim" name="ano_fim" required>
            </div>
            <div class="mb-3">
                <label for="curso" class="form-label">Nome do Curso</label>
                <input type="text" class="form-control" id="curso" name="curso" required>
            </div>
            <div class="mb-3">
                <label for="professor" class="form-label">Professor Responsável</label>
                <select class="form-control" id="professor" name="professor" required>
                    <option value="">Selecione um professor</option>
                    <?php if ($professoresResult->num_rows > 0): ?>
                        <?php while ($professor = $professoresResult->fetch_assoc()): ?>
                            <option value="<?php echo $professor['id']; ?>"><?php echo $professor['nome']; ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">Nenhum professor encontrado.</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Criar
                </button>
                <a href="secretaria.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Fechar a conexão ao banco de dados
?>
