<?php
session_start();

// Verificar se o usuário está logado e se é da secretaria
// Verifica se o usuário está logado e é do tipo secretaria ou admin
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

// Buscar os candidatos na tabela "candidaturas"
$result = $conn->query("SELECT id, nome, curso, email FROM candidaturas");

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidaturas Recebidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('288fcce4-a3c6-4c51-9d4d-4e1b88817c3c.jpg'); /* Caminho da imagem */
            background-size: cover; /* A imagem vai cobrir toda a tela */
            background-position: center; /* Centraliza a imagem */
            background-attachment: fixed; /* A imagem ficará fixa enquanto rola */
            color: #343a40; /* Cor do texto */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            height: 100vh; /* Define que o fundo vai ocupar 100% da altura da tela */
        }

        .container {
            background-color: #ffffff; /* Fundo branco para o container */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Sombra leve */
            max-width: 800px;
        }
        h1 {
            color: #007bff; /* Título azul */
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .table th {
            background-color: #007bff; /* Cabeçalho azul */
            color: #ffffff; /* Texto branco no cabeçalho */
        }
        .table td, .table th {
            border-color: #dee2e6; /* Cor da borda */
        }
        .btn-primary {
            background-color: #007bff; /* Azul */
            border-color: #007bff;
            transition: all 0.3s;
            color: #ffffff; /* Texto branco */
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Azul mais escuro no hover */
        }
        .btn-info {
            background-color: #17a2b8; /* Azul claro */
            color: #ffffff;
        }
        .btn-info:hover {
            background-color: #138496; /* Azul mais escuro no hover */
        }
        .btn-danger {
            background-color: #dc3545; /* Vermelho */
            color: #ffffff;
        }
        .btn-danger:hover {
            background-color: #c82333; /* Vermelho mais escuro no hover */
        }
        .user-info {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            align-items: center;
            color: #343a40; /* Texto escuro */
            font-weight: bold;
        }
        .user-info i {
            margin-right: 5px;
        }
        a:hover {
            text-decoration: none;
        }
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <a href="perfil.php" style="text-decoration: none; color: inherit;">
                <i class="fas fa-user"></i> <?php echo $_SESSION['usuario']; ?>
            </a>
        </div>
        
        <h1>Candidaturas Recebidas</h1>

        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Curso</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['nome']; ?></td>
                                <td><?php echo $row['curso']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a href="candidatura_detalhes.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-info-circle"></i> Detalhes
                                    </a>
                                    <a href="apagar_candidatura.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar esta candidatura?');">
                                        <i class="fas fa-trash-alt"></i> Apagar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma candidatura encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="secretaria.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
