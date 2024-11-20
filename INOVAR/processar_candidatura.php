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

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    // Função para manipular o upload de arquivos
    function obterConteudoArquivo($inputNome) {
        if (isset($_FILES[$inputNome]) && $_FILES[$inputNome]['error'] === UPLOAD_ERR_OK) {
            return file_get_contents($_FILES[$inputNome]['tmp_name']);
        }
        return null;
    }

    // Obter o conteúdo dos arquivos enviados
    $documento_identificacao = obterConteudoArquivo('documento_identificacao');
    $certificado_habilitacoes = obterConteudoArquivo('certificado_habilitacoes');
    $boletim_vacinas = obterConteudoArquivo('boletim_vacinas');
    $foto1 = obterConteudoArquivo('foto1');
    $foto2 = obterConteudoArquivo('foto2');
    $comprovativo_iban = obterConteudoArquivo('comprovativo_iban');
    $atestado_residencia = obterConteudoArquivo('atestado_residencia');
    $declaracao_centro_emprego = obterConteudoArquivo('declaracao_centro_emprego');

    // Preparar e executar a inserção no banco de dados
    $sql = "INSERT INTO candidaturas (nome, email, telefone, data_nascimento, documento_identificacao, certificado_habilitacoes, boletim_vacinas, foto1, foto2, comprovativo_iban, atestado_residencia, declaracao_centro_emprego)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssbbbbbbbb", 
        $nome, 
        $email, 
        $telefone, 
        $data_nascimento, 
        $documento_identificacao, 
        $certificado_habilitacoes, 
        $boletim_vacinas, 
        $foto1, 
        $foto2, 
        $comprovativo_iban, 
        $atestado_residencia, 
        $declaracao_centro_emprego
    );

    if ($stmt->execute()) {
        // Exibir mensagem de sucesso com um estilo bonito e ilustrativo
        echo "
        <style>
            body {
                font-family: Arial, sans-serif;
                background-image: url('288fcce4-a3c6-4c51-9d4d-4e1b88817c3c.jpg');
                background-size: cover;
                background-position: center;
                height: 100vh;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .success-message {
                background: rgba(0, 0, 0, 0.6);
                color: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
                font-size: 20px;
                text-align: center;
                max-width: 500px;
                width: 100%;
                transform: translateY(-50%);
            }
            .success-message i {
                font-size: 30px;
                margin-right: 10px;
                color: white;
            }
        </style>
        <div class='success-message'>
            <i>&#10004;</i> <!-- Ícone de check -->
            Candidatura enviada com sucesso!
        </div>";
    } else {
        echo "<p>Erro ao enviar candidatura: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Método inválido. Por favor, envie o formulário corretamente.</p>";
}
?>
