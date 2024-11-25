<?php
session_start();

// Verificar se o usuário está logado e se é professor
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'professor') {
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

// Preparar a consulta para pegar todas as turmas
$result = $conn->query("SELECT id, nome FROM turmas");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas</title>
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
        .table th {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-info {
            background-color: #17a2b8;
            color: #ffffff;
        }
        .btn-info:hover {
            background-color: #138496;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Exibir nome do usuário e link para o perfil no canto superior direito -->
        <div class="user-info">
            <a href="perfil.php" style="text-decoration: none; color: inherit;">
                <i class="fas fa-user"></i> <?php echo $_SESSION['usuario']; ?>
            </a>
        </div>

        <h1>Turmas</h1>
        
        <!-- Contêiner para a tabela de turmas -->
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome da Turma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['nome']; ?></td>
                                <td>
                                    <a href="turma_detalhes.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-info-circle"></i> Detalhes
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">Nenhuma turma encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Botão Voltar Estilizado -->
        <div class="text-center mt-4">
            <a href="professor.php" class="btn-voltar">← Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
