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

// Verificar se o ID do candidato foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do candidato não fornecido.";
    exit();
}

$id = $_GET['id'];

// Buscar os dados do candidato com base no ID
$sql = "SELECT * FROM candidaturas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Exibir os detalhes do candidato
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Detalhes da Candidatura</h2>";
    echo "<p><strong>Nome:</strong> " . $row['nome'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<p><strong>Telefone:</strong> " . $row['telefone'] . "</p>";
    echo "<p><strong>Data de Nascimento:</strong> " . $row['data_nascimento'] . "</p>";
    echo "<p><strong>Curso:</strong> " . $row['curso'] . "</p>";

    // Exibir arquivos se existirem
    echo "<p><strong>Documentos Enviados:</strong></p>";
    echo "<ul>";

    if ($row['documento_identificacao']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['documento_identificacao']) . "' target='_blank'>Documento de Identificação</a></li>";
    }

    if ($row['certificado_habilitacoes']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['certificado_habilitacoes']) . "' target='_blank'>Certificado de Habilitações</a></li>";
    }

    if ($row['boletim_vacinas']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['boletim_vacinas']) . "' target='_blank'>Boletim de Vacinas</a></li>";
    }

    if ($row['foto1']) {
        echo "<li><a href='data:image/jpeg;base64," . base64_encode($row['foto1']) . "' target='_blank'>Fotografia 1</a></li>";
    }

    if ($row['foto2']) {
        echo "<li><a href='data:image/jpeg;base64," . base64_encode($row['foto2']) . "' target='_blank'>Fotografia 2</a></li>";
    }

    if ($row['comprovativo_iban']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['comprovativo_iban']) . "' target='_blank'>Comprovativo de IBAN</a></li>";
    }

    if ($row['atestado_residencia']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['atestado_residencia']) . "' target='_blank'>Atestado de Residência</a></li>";
    }

    if ($row['declaracao_centro_emprego']) {
        echo "<li><a href='data:application/pdf;base64," . base64_encode($row['declaracao_centro_emprego']) . "' target='_blank'>Declaração do Centro de Emprego</a></li>";
    }

    echo "</ul>";
} else {
    echo "Candidato não encontrado.";
}

$stmt->close();
$conn->close();
?>
