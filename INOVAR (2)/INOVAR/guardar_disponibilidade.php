<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
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

// Pegar o nome do usuário logado
$nome_professor = $_SESSION['usuario'];

// Prepara a consulta para buscar o ID do professor
$sql_professor = "SELECT id FROM usuarios WHERE nome = ?";
$stmt_professor = $conn->prepare($sql_professor);
$stmt_professor->bind_param("s", $nome_professor);
$stmt_professor->execute();
$result_professor = $stmt_professor->get_result();

if ($result_professor->num_rows > 0) {
    $row_professor = $result_professor->fetch_assoc();
    $professor_id = $row_professor['id'];
} else {
    die("Professor não encontrado.");
}

// Prepara a consulta para inserir ou atualizar a disponibilidade
$sql = "INSERT INTO disponiblidade (professor, 2b1, 2b2, 2b3, 2b4, 3b1, 3b2, 3b3, 3b4, 4b1, 4b2, 4b3, 4b4, 5b1, 5b2, 5b3, 5b4, 6b1, 6b2, 6b3, 6b4) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
ON DUPLICATE KEY UPDATE 
    2b1 = VALUES(2b1), 2b2 = VALUES(2b2), 2b3 = VALUES(2b3), 2b4 = VALUES(2b4),
    3b1 = VALUES(3b1), 3b2 = VALUES(3b2), 3b3 = VALUES(3b3), 3b4 = VALUES(3b4),
    4b1 = VALUES(4b1), 4b2 = VALUES(4b2), 4b3 = VALUES(4b3), 4b4 = VALUES(4b4),
    5b1 = VALUES(5b1), 5b2 = VALUES(5b2), 5b3 = VALUES(5b3), 5b4 = VALUES(5b4),
    6b1 = VALUES(6b1), 6b2 = VALUES(6b2), 6b3 = VALUES(6b3), 6b4 = VALUES(6b4)";

// Prepara a consulta
$stmt = $conn->prepare($sql);

// Verifica se a preparação da consulta falhou
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Obtém os valores dos botões
$disponibilidade = [
    $_POST['2b1'], $_POST['2b2'], $_POST['2b3'], $_POST['2b4'],
    $_POST['3b1'], $_POST['3b2'], $_POST['3b3'], $_POST['3b4'],
    $_POST['4b1'], $_POST['4b2'], $_POST['4b3'], $_POST['4b4'],
    $_POST['5b1'], $_POST['5b2'], $_POST['5b3'], $_POST['5b4'],
    $_POST['6b1'], $_POST['6b2'], $_POST['6b3'], $_POST['6b4']
];

// Verifica se todos os valores foram definidos
if (count($disponibilidade) == 20) {
    // Adiciona o ID do professor ao array de parâmetros
    array_unshift($disponibilidade, $professor_id); // Adiciona o ID do professor na frente do array

    // Define os tipos de parâmetros para o bind_param
    $params_type = "i" . str_repeat("b", count($disponibilidade) - 1); // 'i' para inteiro do professor_id e 'b' para os valores booleanos

    // Faz o binding dos parâmetros
    $stmt->bind_param($params_type, ...$disponibilidade);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Disponibilidade guardada com sucesso.";
    } else {
        echo "Erro ao guardar disponibilidade: " . $stmt->error;
    }
} else {
    echo "Erro: número de valores de disponibilidade inválido.";
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
