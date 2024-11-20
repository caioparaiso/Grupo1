<?php
// Conectar à base de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turma = $_GET['turma'];
    
    // Iterar sobre os dados recebidos e atualizar a tabela correspondente
    foreach ($_POST as $key => $value) {
        // Identificar o bloco e a coluna
        list($bloco, $coluna) = explode('_', $key, 2);

        // Preparar a consulta de atualização
        if (strpos($coluna, 'ufcd') !== false) {
            $coluna_type = 'ufcd';
        } else {
            $coluna_type = 'sala';
        }

        // Atualizar a tabela
        $stmt = $conn->prepare("UPDATE `{$turma}_horario` SET $coluna = ? WHERE bloco = ?");
        $stmt->bind_param("ss", $value, $bloco);
        $stmt->execute();
    }

    echo "Horários atualizados com sucesso!";
} else {
    echo "Dados não enviados corretamente!";
}

$conn->close();
?>
