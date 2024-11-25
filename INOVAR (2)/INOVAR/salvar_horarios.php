<?php
// Conectar ao banco de dados
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter os dados do formulário via POST
$data = $_POST;

// Verificar se o nome da turma foi enviado via GET
if (isset($_GET['turma'])) {
    $turma = $_GET['turma'];
    $tabela = "{$turma}_horario"; // Nome da tabela de acordo com a turma
} else {
    die("Nome da turma não especificado.");
}

// Montar a consulta de atualização
$sets = [];
foreach ($data as $coluna => $valor) {
    // Verificar se o valor não é vazio
    if ($valor !== '') {
        $sets[] = "`$coluna` = '" . $conn->real_escape_string($valor) . "'";
    }
}

// Garantir que a tabela de horários existe
if (empty($sets)) {
    die("Nenhuma alteração foi feita.");
}

// Gerar o SQL de atualização
$sql = "UPDATE `$tabela` SET " . implode(", ", $sets) . " LIMIT 1"; // Limite de 1 pois a tabela tem uma linha por turma

// Executar a atualização
if ($conn->query($sql) === TRUE) {
    echo "Horários atualizados com sucesso!";
} else {
    echo "Erro ao atualizar os horários: " . $conn->error;
}

$conn->close();
?>
