<?php
session_start();

// Verificar se o usuário está logado e se é da secretaria
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'secretaria') {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

// Verificar se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar cursos da tabela "curso"
$sql = "SELECT nome FROM curso";
$result = $conn->query($sql);
$cursos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cursos[] = $row['nome'];
    }
}

// Função para manipular o upload de arquivos
function obterConteudoArquivo($inputNome) {
    if (isset($_FILES[$inputNome]) && $_FILES[$inputNome]['error'] === UPLOAD_ERR_OK) {
        return file_get_contents($_FILES[$inputNome]['tmp_name']);
    }
    return null; // Retornar null se o arquivo não foi enviado
}

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o campo "curso" foi preenchido
    if (empty($_POST['curso'])) {
        echo "<p>O campo 'Curso' é obrigatório.</p>";
    } else {
        // Obter os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $data_nascimento = $_POST['data_nascimento'];
        $curso = $_POST['curso']; // Novo campo de curso

        // Obter o conteúdo dos arquivos enviados (se houver)
        $documento_identificacao = obterConteudoArquivo('documento_identificacao');
        $certificado_habilitacoes = obterConteudoArquivo('certificado_habilitacoes');
        $boletim_vacinas = obterConteudoArquivo('boletim_vacinas');
        $foto1 = obterConteudoArquivo('foto1');
        $foto2 = obterConteudoArquivo('foto2');
        $comprovativo_iban = obterConteudoArquivo('comprovativo_iban');
        $atestado_residencia = obterConteudoArquivo('atestado_residencia');
        $declaracao_centro_emprego = obterConteudoArquivo('declaracao_centro_emprego');

        // Preparar a consulta de inserção, tratando arquivos nulos
        $sql = "INSERT INTO candidaturas (nome, email, telefone, data_nascimento, curso, documento_identificacao, certificado_habilitacoes, boletim_vacinas, foto1, foto2, comprovativo_iban, atestado_residencia, declaracao_centro_emprego)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        
        // Verificar se algum arquivo é nulo e substituí-lo por NULL no banco de dados
        $documento_identificacao = $documento_identificacao ?: null;
        $certificado_habilitacoes = $certificado_habilitacoes ?: null;
        $boletim_vacinas = $boletim_vacinas ?: null;
        $foto1 = $foto1 ?: null;
        $foto2 = $foto2 ?: null;
        $comprovativo_iban = $comprovativo_iban ?: null;
        $atestado_residencia = $atestado_residencia ?: null;
        $declaracao_centro_emprego = $declaracao_centro_emprego ?: null;

        // Agora a consulta SQL está incluindo o valor do curso
        $stmt->bind_param("ssssbbbbbbbbb", 
            $nome, 
            $email, 
            $telefone, 
            $data_nascimento, 
            $curso, // Inserir o curso aqui
            $documento_identificacao, 
            $certificado_habilitacoes, 
            $boletim_vacinas, 
            $foto1, 
            $foto2, 
            $comprovativo_iban, 
            $atestado_residencia, 
            $declaracao_centro_emprego
        );
        $stmt->close();
        $conn->close();
    }
} else {
}
?>

<!-- HTML do formulário -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Candidatura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            background-image: url('288fcce4-a3c6-4c51-9d4d-4e1b88817c3c.jpg'); /* Caminho para a imagem */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 700px;
            margin-top: 5%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: bold;
            text-align: center;
        }
        label {
            font-weight: 600;
            color: #555;
        }
        .form-control {
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            font-weight: bold;
            transition: background-color 0.3s;
            width: 100%;
            padding: 15px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .file-upload-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .file-upload-group .mb-3 {
            width: 48%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulário de Candidatura</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="form-group">
                <label for="curso" class="form-label">Curso</label>
                <select class="form-control" id="curso" name="curso" required>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?= $curso ?>"><?= $curso ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <h3>Documentos de Identificação</h3>
            <div class="file-upload-group">
                <div class="mb-3">
                    <label for="documento_identificacao" class="form-label">Documento de Identificação</label>
                    <input type="file" class="form-control" id="documento_identificacao" name="documento_identificacao">
                </div>
                <div class="mb-3">
                    <label for="certificado_habilitacoes" class="form-label">Certificado de Habilitações</label>
                    <input type="file" class="form-control" id="certificado_habilitacoes" name="certificado_habilitacoes">
                </div>
            </div>

            <h3>Outros Documentos</h3>
            <div class="file-upload-group">
                <div class="mb-3">
                    <label for="foto1" class="form-label">Fotografia 1</label>
                    <input type="file" class="form-control" id="foto1" name="foto1">
                </div>
                <div class="mb-3">
                    <label for="foto2" class="form-label">Fotografia 2</label>
                    <input type="file" class="form-control" id="foto2" name="foto2">
                </div>
                <div class="mb-3">
                    <label for="boletim_vacinas" class="form-label">Boletim de Vacinas</label>
                    <input type="file" class="form-control" id="boletim_vacinas" name="boletim_vacinas">
                </div>
                <div class="mb-3">
                    <label for="comprovativo_iban" class="form-label">Comprovativo do IBAN</label>
                    <input type="file" class="form-control" id="comprovativo_iban" name="comprovativo_iban">
                </div>
                <div class="mb-3">
                    <label for="atestado_residencia" class="form-label">Atestado de Residência</label>
                    <input type="file" class="form-control" id="atestado_residencia" name="atestado_residencia">
                </div>
                <div class="mb-3">
                    <label for="declaracao_centro_emprego" class="form-label">Declaração do Centro de Emprego</label>
                    <input type="file" class="form-control" id="declaracao_centro_emprego" name="declaracao_centro_emprego">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submeter Candidatura</button>
        </form>
    </div>
</body>
</html>
