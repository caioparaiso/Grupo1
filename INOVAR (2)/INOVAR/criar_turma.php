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

// Obter os dados do formulário
$nome_turma = $conn->real_escape_string($_POST['nome']);
$ano_inicio = (int)$_POST['ano_inicio'];
$ano_fim = (int)$_POST['ano_fim'];
$curso = $conn->real_escape_string($_POST['curso']);
$professor = $conn->real_escape_string($_POST['professor']);

// Inserir os dados na tabela 'turmas'
$sql_turmas = "INSERT INTO turmas (nome, inicio, fim, curso, professor) VALUES ('$nome_turma', $ano_inicio, $ano_fim, '$curso', '$professor')";

if ($conn->query($sql_turmas) === TRUE) {
    // Obter o ID da turma recém-criada
    $turma_id = $conn->insert_id;

    // Criar a tabela com o nome da turma
    $sql = "CREATE TABLE IF NOT EXISTS `$nome_turma` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        numero INT(11) NOT NULL,
        horas INT(11) NOT NULL,
        professor VARCHAR(100) NOT NULL,
        concluida BOOLEAN DEFAULT FALSE
    )";

    $nome_turma_notas = $nome_turma . "_notas";

    $sql_notas = "CREATE TABLE `$nome_turma_notas` (
        `nome` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
        `0754` INT(2) NULL DEFAULT NULL,
        `0769` INT(2) NULL DEFAULT NULL,
        `0770` INT(2) NULL DEFAULT NULL,
        `0771` INT(2) NULL DEFAULT NULL,
        `0772` INT(2) NULL DEFAULT NULL,
        `0773` INT(2) NULL DEFAULT NULL,
        `0774` INT(2) NULL DEFAULT NULL,
        `0775` INT(2) NULL DEFAULT NULL,
        `0776` INT(2) NULL DEFAULT NULL,
        `0778` INT(2) NULL DEFAULT NULL,
        `0780` INT(2) NULL DEFAULT NULL,
        `0781` INT(2) NULL DEFAULT NULL,
        `0782` INT(2) NULL DEFAULT NULL,
        `0783` INT(2) NULL DEFAULT NULL,
        `0784` INT(2) NULL DEFAULT NULL,
        `0785` INT(2) NULL DEFAULT NULL,
        `0789` INT(2) NULL DEFAULT NULL,
        `0779` INT(2) NULL DEFAULT NULL,
        `0786` INT(2) NULL DEFAULT NULL,
        `0787` INT(2) NULL DEFAULT NULL,
        `0788` INT(2) NULL DEFAULT NULL,
        `0791` INT(2) NULL DEFAULT NULL,
        `0792` INT(2) NULL DEFAULT NULL,
        `0793` INT(2) NULL DEFAULT NULL,
        `10791` INT(2) NULL DEFAULT NULL
    )";

    
    $nome_turma_horario = $nome_turma . "_horario";

    $sql_horario = "CREATE TABLE `$nome_turma_horario` (
        `bloco` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
        `segunda` INT(11) NULL DEFAULT NULL,
        `s1` INT(11) NULL DEFAULT NULL,
        `terça` INT(11) NULL DEFAULT NULL,
        `s2` INT(11) NULL DEFAULT NULL,
        `quarta` INT(11) NULL DEFAULT NULL,
        `s3` INT(11) NULL DEFAULT NULL,
        `quinta` INT(11) NULL DEFAULT NULL,
        `s4` INT(11) NULL DEFAULT NULL,
        `sexta` INT(11) NULL DEFAULT NULL,
        `s5` INT(11) NULL DEFAULT NULL
    )";

    $sql_horario_inserir = "INSERT INTO `$nome_turma_horario` (`bloco`, `segunda`, `s1`, `terça`, `s2`, `quarta`, `s3`, `quinta`, `s4`, `sexta`, `s5`) VALUES
	('b1', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	('b2', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	('b3', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	('b4', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);";



    if ($conn->query($sql) === TRUE && $conn->query($sql_notas) === TRUE && $conn->query($sql_horario) === TRUE && $conn->query($sql_horario_inserir) === TRUE) {
        // Redirecionar para turmas_secretaria.php após a criação bem-sucedida
        header("Location: turmas_secretaria.php?success=1");
        exit();
    } else {
        echo "Erro ao criar tabela: " . $conn->error;
    }



} else {
    echo "Erro ao inserir na tabela 'turmas': " . $conn->error;
}

$conn->close();
?>