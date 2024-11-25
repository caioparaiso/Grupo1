<?php
session_start();

// Verifica se o usuário tem permissão
if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] !== 'secretaria' && $_SESSION['tipo'] !== 'admin')) {
    echo json_encode(['success' => false, 'message' => 'Acesso negado']);
    exit();
}

// Conectar ao banco de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

// Verificar a conexão
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados']);
    exit();
}

// Receber e decodificar os dados JSON
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$nome = $data['nome'];
$email = $data['email'];
$nif = $data['nif'];

// Atualizar os dados no banco de dados
$sql = "UPDATE usuarios SET nome = ?, email = ?, nif = ? WHERE id = ? AND tipo = 'professor'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $nome, $email, $nif, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar dados']);
}

// Fechar a conexão
$stmt->close();
$conn->close();
