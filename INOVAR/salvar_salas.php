<?php
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$turmaNome = $_GET['turma'];
$tabelaHorario = $turmaNome . '_horario';

// Verificar se há salas no POST
if (isset($_POST['salas']) && is_array($_POST['salas'])) {
    foreach ($_POST['salas'] as $id => $salaDias) {
        foreach ($salaDias as $dia => $sala) {
            // Ignorar campos vazios
            if ($sala != "") {
                $sql = "UPDATE $tabelaHorario SET $dia = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $sala, $id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    echo "Salas atualizadas com sucesso!";
} else {
    echo "Nenhuma alteração feita.";
}

$conn->close();
?>
