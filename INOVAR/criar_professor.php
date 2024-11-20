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
$nome = $data['nome'];
$email = $data['email'];
$nif = $data['nif'];

$sql = "INSERT INTO usuarios (nome, senha, email, nif, tipo) VALUES (?, '1234', ?, ?, 'professor')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $nif);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Professor criado com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao criar professor']);
}

$stmt->close();
$conn->close();
