<?php
session_start();

if (!isset($_SESSION['usuario']) || ($_SESSION['tipo'] !== 'secretaria' && $_SESSION['tipo'] !== 'admin')) {
    echo json_encode(['success' => false, 'message' => 'Acesso negado']);
    exit();
}

$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$sql = "DELETE FROM usuarios WHERE id = ? AND tipo = 'professor'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Professor removido com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover professor']);
}

$stmt->close();
$conn->close();
