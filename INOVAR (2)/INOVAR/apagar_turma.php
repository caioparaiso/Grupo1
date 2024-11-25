<?php
session_start();

// Verificar se o usuário está logado e se é professor
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'secretaria') {
    header("Location: index.php"); // Redireciona para login se não estiver logado
    exit();
}

// Conectar à base de dados
$host = 'localhost';
$db = 'escola'; // Nome da base de dados
$user = 'root'; // Usuário do MySQL
$pass = ''; // Senha do MySQL (se houver)
$conn = new mysqli($host, $user, $pass, $db);

// Verificar se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter o ID da turma a ser apagada
if (isset($_GET['id'])) {
    $turma_id = (int)$_GET['id'];

    // Obter o nome da tabela da turma a ser apagada
    $result = $conn->query("SELECT nome FROM turmas WHERE id = $turma_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome_turma = $row['nome'];

        // Apagar a tabela da turma
        $sql_drop_table = "DROP TABLE IF EXISTS `$nome_turma`";
        $conn->query($sql_drop_table);

        // Apagar a turma da tabela 'turmas'
        $sql_delete_turma = "DELETE FROM turmas WHERE id = $turma_id";
        if ($conn->query($sql_delete_turma) === TRUE) {
            echo "Turma apagada com sucesso.";
        } else {
            echo "Erro ao apagar a turma: " . $conn->error;
        }
    } else {
        echo "Turma não encontrada.";
    }
} else {
    echo "ID da turma não especificado.";
}

$conn->close();

// Redirecionar de volta para a página de turmas
header("Location: turmas_secretaria.php");
exit();
?>