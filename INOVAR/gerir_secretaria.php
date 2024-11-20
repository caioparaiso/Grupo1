<?php
session_start();

// Verifica se o usuário está logado e é do tipo secretaria ou admin
if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] !== 'secretaria' && $_SESSION['tipo'] !== 'admin')) {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

// Conectar ao banco de dados
$host = 'localhost';
$db = 'escola'; // Nome da base de dados
$user = 'root'; // Usuário do MySQL
$pass = ''; // Senha do MySQL (se houver)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultar os secretariaes da tabela usuarios onde tipo é igual a 'secretaria'
$sql = "SELECT id, nome, email, nif, avatar FROM usuarios WHERE tipo = 'secretaria'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir secretaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('imagemjpg.jpg'); /* Insira o caminho da sua imagem */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        .secretaria-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            cursor: pointer;
        }
        .secretaria-card:hover {
            transform: scale(1.05);
        }
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestão de secretariaes</h1>
    <!-- Botão para abrir o modal de criação -->
    <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#secretariaModal" onclick="resetModal()">Adicionar Novo secretaria</button>
    
    <div class="row row-cols-1 row-cols-md-5 g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                    <!-- Card do secretaria com data-id para identificar o secretaria no modal -->
                    <div class="secretaria-card" data-bs-toggle="modal" data-bs-target="#secretariaModal"
                         data-id="<?php echo $row['id']; ?>" 
                         data-nome="<?php echo htmlspecialchars($row['nome']); ?>" 
                         data-email="<?php echo htmlspecialchars($row['email']); ?>" 
                         data-nif="<?php echo htmlspecialchars($row['nif']); ?>" 
                         data-avatar="<?php echo htmlspecialchars($row['avatar']); ?>">
                        
                        <img src="<?php echo htmlspecialchars($row['avatar']); ?>" alt="Avatar de <?php echo htmlspecialchars($row['nome']); ?>" class="avatar">
                        <h5><?php echo htmlspecialchars($row['nome']); ?></h5>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Nenhum secretaria encontrado.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para exibir, editar e remover secretariaes -->
<div class="modal fade" id="secretariaModal" tabindex="-1" aria-labelledby="secretariaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="secretariaModalLabel">Detalhes do secretaria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="" alt="Avatar" class="avatar mb-3" id="modalAvatar">
                    <input type="hidden" id="modalsecretariaId">
                    <div class="mb-3">
                        <label for="modalNome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="modalNome">
                    </div>
                    <div class="mb-3">
                        <label for="modalEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modalEmail">
                    </div>
                    <div class="mb-3">
                        <label for="modalNIF" class="form-label">NIF</label>
                        <input type="text" class="form-control" id="modalNIF">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Botão de salvar alterações (para criar e editar) -->
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Salvar Alterações</button>
                <!-- Botão de remover secretaria -->
                <button type="button" class="btn btn-danger" id="deletesecretariaBtn">Remover secretaria</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    // Função para abrir o modal e carregar os dados do secretaria
    document.addEventListener('DOMContentLoaded', function() {
        const secretariaModal = document.getElementById('secretariaModal');
        
        secretariaModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const isNew = !button.getAttribute('data-id');
            resetModal();
            
            if (!isNew) {
                // Caso seja edição, carrega os dados
                document.getElementById('modalsecretariaId').value = button.getAttribute('data-id');
                document.getElementById('modalNome').value = button.getAttribute('data-nome');
                document.getElementById('modalEmail').value = button.getAttribute('data-email');
                document.getElementById('modalNIF').value = button.getAttribute('data-nif');
                document.getElementById('modalAvatar').src = button.getAttribute('data-avatar') || 'default-avatar.jpg';
            }
        });
        
        // Função para criar ou atualizar o secretaria
        document.getElementById('saveChangesBtn').addEventListener('click', function () {
            const id = document.getElementById('modalsecretariaId').value;
            const nome = document.getElementById('modalNome').value;
            const email = document.getElementById('modalEmail').value;
            const nif = document.getElementById('modalNIF').value;
            const url = id ? 'atualizar_secretaria.php' : 'criar_secretaria.php';

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, nome, email, nif })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            });
        });

        // Função para remover secretaria
        document.getElementById('deletesecretariaBtn').addEventListener('click', function () {
            const id = document.getElementById('modalsecretariaId').value;

            fetch('remover_secretaria.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            });
        });

        // Função para resetar o modal (usada para criar novo secretaria)
        function resetModal() {
            document.getElementById('modalsecretariaId').value = '';
            document.getElementById('modalNome').value = '';
            document.getElementById('modalEmail').value = '';
            document.getElementById('modalNIF').value = '';
            document.getElementById('modalAvatar').src = 'default-avatar.jpg';
        }
    });
</script>

    <div class="text-center mt-4">
        <a href="javascript:history.back()" class="btn-voltar">← Voltar</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
