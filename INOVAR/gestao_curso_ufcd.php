<?php
session_start();

// Conectar ao banco de dados
$host = 'localhost';
$db = 'escola'; 
$user = 'root'; 
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter todos os cursos
$cursos_result = $conn->query("SELECT id_curso, nome FROM curso");

if (!$cursos_result) {
    die("Erro na consulta: " . $conn->error);
}

$cursos = [];
while ($row = $cursos_result->fetch_assoc()) {
    $cursos[] = $row;
}

// Obter todas as UFCDs
$ufcds_result = $conn->query("SELECT ufcd, nome FROM ufcds");
if (!$ufcds_result) {
    die("Erro na consulta: " . $conn->error);
}

$ufcds = [];
while ($row = $ufcds_result->fetch_assoc()) {
    $ufcds[] = $row;
}

// Obter UFCDs associadas a um curso selecionado
$curso_selecionado_id = isset($_GET['curso_id']) ? (int)$_GET['curso_id'] : $cursos[0]['id_curso'];
$ufcds_curso_result = $conn->prepare("SELECT ufcd.id, ufcd.nome FROM ufcd 
    INNER JOIN curso_ufcd ON ufcd.id = curso_ufcd.ufcd_id WHERE curso_ufcd.curso_id = ?");
$ufcds_curso_result->bind_param("i", $curso_selecionado_id);
$ufcds_curso_result->execute();
$ufcds_curso = $ufcds_curso_result->get_result();

// Verificar se os dados foram enviados via POST
if (isset($_POST['action'])) {
    $curso_id = $_POST['curso_id']; 
    $ufcd_id = $_POST['ufcd_id'];    
    $action = $_POST['action'];      

    if (empty($curso_id) || empty($ufcd_id) || empty($action)) {
        echo "Erro: Alguns valores estão vazios.";
    } else {
        if ($action == "adicionar") {
            $stmt = $conn->prepare("INSERT INTO curso_ufcd (curso_id, ufcd_id) VALUES (?, ?)");
            $stmt->bind_param("is", $curso_id, $ufcd_id); 

            if ($stmt->execute()) {
                echo "UFCD associada ao curso com sucesso!";
            } else {
                echo "Erro ao associar a UFCD: " . $stmt->error;
            }

            $stmt->close();
        }
        elseif ($action == "remover") {
            $stmt = $conn->prepare("DELETE FROM curso_ufcd WHERE curso_id = ? AND ufcd_id = ?");
            $stmt->bind_param("is", $curso_id, $ufcd_id); 

            if ($stmt->execute()) {
                echo "UFCD removida do curso com sucesso!";
            } else {
                echo "Erro ao remover a UFCD: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>

<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Curso-UFCD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos para imagem de fundo */
        body {
            background-image: url('imagemjpg.jpg'); /* Insira o caminho da sua imagem */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #333;
        }
        /* Estilos do botão Voltar */
        .btn-voltar {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }
        .btn-voltar:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
            text-decoration: none;
        }

        .ufcd-box {
            width: 80px;
            height: 50px;
            margin: 5px;
            font-size: 14px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid #007bff;
            background-color: #f8f9fa;
            color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .ufcd-box:hover {
            background-color: #007bff;
            color: white;
        }
        .ufcd-box.btn-selected {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .ufcds-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Botão de Voltar -->
    <div class="text-center mt-4">
        <a href="javascript:history.back()" class="btn-voltar">← Voltar</a>
    </div>

    <h1>Gestão de UFCDs</h1>

    <!-- Selecionar Curso -->
    <form method="GET" class="mb-3">
        <label for="curso_id" class="form-label">Selecione o Curso</label>
        <select name="curso_id" id="curso_id" class="form-select" onchange="this.form.submit()">
            <?php foreach ($cursos as $curso): ?>
                <option value="<?php echo $curso['id_curso']; ?>" <?php echo ($curso['id_curso'] == $curso_selecionado_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($curso['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <table class="table table-striped">
        <tbody>
        <?php while ($ufcd = $ufcds_curso->fetch_assoc()): ?>
            <tr>
                <td><?php echo $ufcd['id']; ?></td>
                <td><?php echo htmlspecialchars($ufcd['nome']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="curso_id" value="<?php echo $curso_selecionado_id; ?>">
                        <input type="hidden" name="ufcd_id" value="<?php echo $ufcd['id']; ?>">
                        <button type="submit" name="remover_ufcd" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover esta UFCD?')">Remover</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Exibir UFCDs disponíveis como caixas -->
    <h3>Adicionar UFCD ao Curso</h3>
    <div class="ufcds-container" id="ufcds-container">
        <?php foreach ($ufcds as $ufcd): ?>
            <?php
                $selected = false;
                $selected_query = $conn->prepare("SELECT * FROM curso_ufcd WHERE curso_id = ? AND ufcd_id = ?");
                $selected_query->bind_param("ii", $curso_selecionado_id, $ufcd['ufcd']);
                $selected_query->execute();
                $selected_result = $selected_query->get_result();
                if ($selected_result->num_rows > 0) {
                    $selected = true;
                }
            ?>
            <div class="ufcd-box <?php echo $selected ? 'btn-selected' : ''; ?>" data-ufcd-id="<?php echo $ufcd['ufcd']; ?>" data-curso-id="<?php echo $curso_selecionado_id; ?>">
                <?php echo $ufcd['ufcd']; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".ufcd-box").click(function() {
            var box = $(this);
            var curso_id = box.data('curso-id'); 
            var ufcd_id = box.data('ufcd-id');
            var isSelected = box.hasClass("btn-selected"); 

            box.toggleClass("btn-selected");

            $.ajax({
                type: "POST",
                url: "",  
                data: {
                    curso_id: curso_id,
                    ufcd_id: ufcd_id,
                    action: isSelected ? "remover" : "adicionar"  
                },
                success: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>
</body>
</html>

<?php
$conn->close();
?>

