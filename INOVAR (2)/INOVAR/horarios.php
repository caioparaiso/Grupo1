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

// Verificar se o nome da turma foi enviado
if (isset($_GET['turma'])) {
    $turma = $_GET['turma'];
    $tabela = "{$turma}_horario"; // Nome da tabela com base na turma
} else {
    die("Nome da turma não especificado.");
}

// Buscar os dados de horários para a turma selecionada
$query = "SELECT * FROM `$tabela` LIMIT 1";
$result = $conn->query($query);

// Caso não haja dados para a turma
if ($result->num_rows == 0) {
    die("Horários não encontrados para a turma.");
}

// Carregar a linha existente
$row = $result->fetch_assoc();

// Buscar os nomes das salas e seus IDs na tabela 'sala' com a coluna 'local'
$query_salas = "SELECT id_sala, nome, local FROM sala";
$result_salas = $conn->query($query_salas);

// Armazenar as salas em um array para facilitar o uso no formulário
$salas = [];
if ($result_salas->num_rows > 0) {
    while ($sala = $result_salas->fetch_assoc()) {
        $salas[] = $sala; // Armazenar o ID, nome e local da sala
    }
}

// Buscar as UFCDs
$query_ufcds = "SELECT ufcd, professor FROM $turma";
$result_ufcds = $conn->query($query_ufcds);

// Armazenar as UFCDs em um array
$ufcds = [];
if ($result_ufcds->num_rows > 0) {
    while ($ufcd = $result_ufcds->fetch_assoc()) {
        $ufcds[] = $ufcd; // Armazenar a UFCD
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Horários da Turma <?php echo htmlspecialchars($turma); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        table th, table td, h1 {
            text-align: center; /* Centralizar o conteúdo das células */
        }

        /* Aumentando a largura da coluna Bloco */
        .bloco-col {
            width: 150px; /* Defina o tamanho desejado aqui */
        }

        /* Definindo fundo azul para salas principais e fundo verde para salas secundárias */
        .sala-principal {
            background-color: #007bff; /* Azul */
            color: white; /* Texto branco para contraste */
        }

        .sala-secundaria {
            background-color: #28a745; /* Verde */
            color: white; /* Texto branco para contraste */
        }

        /* Cor de fundo para o professor "Vasco Salada" (rosa claro) */
        .vasco-salada {
            background-color: #FFB6C1; /* Rosa Claro */
            color: black; /* Cor do texto */
        }

        /* Cor de fundo para o professor "Carlos Cruz" (verde escuro) */
        .carlos-cruz {
            background-color: #006400; /* Verde Escuro */
            color: white; /* Cor do texto */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Horário da Turma: <?php echo htmlspecialchars($turma); ?></h1>
        <br></br>
        <form id="form-horarios">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="bloco-col"></th>
                        <th colspan="2">Segunda</th>
                        <th colspan="2">Terça</th>
                        <th colspan="2">Quarta</th>
                        <th colspan="2">Quinta</th>
                        <th colspan="2">Sexta</th>
                    </tr>
                    <tr>
                        <th>Horario</th>
                        <th>UFCD</th>
                        <th>Sala</th>
                        <th>UFCD</th>
                        <th>Sala</th>
                        <th>UFCD</th>
                        <th>Sala</th>
                        <th>UFCD</th>
                        <th>Sala</th>
                        <th>UFCD</th>
                        <th>Sala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Blocos de horário e seus respectivos horários
                    $blocos = [
                        'b1' => '8:00 - 11:00', 
                        'b2' => '11:00 - 14:00', 
                        'b3' => '14:00 - 17:00', 
                        'b4' => '17:00 - 20:00'
                    ];
                    $dias = ['seg', 'ter', 'qua', 'qui', 'sex'];

                    // Exibir as linhas para cada bloco de horário
                    foreach ($blocos as $bloco => $horario) {
                        echo "<tr>";
                        echo "<td class='bloco-col'>$horario</td>";  // Aplicando a classe 'bloco-col' aqui para aumentar a largura
                        
                        // Iterar sobre os dias e preencher com os dados da linha carregada
                        foreach ($dias as $dia) {
                            $ufcd_col = "{$bloco}_{$dia}_ufcd";
                            $sala_col = "{$bloco}_{$dia}_sala";
                            
                            // Verificar qual o nome do professor associado à UFCD e adicionar a classe CSS correspondente
                            $professor = '';
                            foreach ($ufcds as $ufcd) {
                                if ($row[$ufcd_col] == $ufcd['ufcd']) {
                                    $professor = $ufcd['professor'];  // Atribui o nome do professor
                                    break;
                                }
                            }

                            // Adicionar a classe de cor correspondente ao professor
                            $professor_class = '';
                            if ($professor == 'vasco salada') {
                                $professor_class = 'vasco-salada';  // Rosa Claro
                            } elseif ($professor == 'carlos cruz') {
                                $professor_class = 'carlos-cruz';  // Verde Escuro
                            }

                            // Menu suspenso para UFCD (agora com nome da UFCD como valor)
                            echo "<td class='$professor_class'><select name='{$ufcd_col}' class='form-control'>";
                            echo "<option value=''>Selecione a UFCD</option>";
                            foreach ($ufcds as $ufcd) {
                                // Seleciona a opção que corresponde ao nome da UFCD
                                $selected = ($row[$ufcd_col] == $ufcd['ufcd']) ? "selected" : "";
                                echo "<option value='" . htmlspecialchars($ufcd['ufcd']) . "' $selected>" . htmlspecialchars($ufcd['ufcd']) . "</option>";
                            }
                            echo "</select></td>";

                            // Menu suspenso para Sala (agora com ID e nome)
                            echo "<td>";
                            
                            // Adicionar fundo azul ou verde baseado no valor da coluna 'local' da sala
                            $sala_class = ''; // Classe de fundo padrão
                            foreach ($salas as $sala) {
                                if ($row[$sala_col] == $sala['id_sala']) {
                                    if ($sala['local'] == 'principal') {
                                        $sala_class = 'sala-principal'; // Fundo azul
                                    } elseif ($sala['local'] == 'secundaria') {
                                        $sala_class = 'sala-secundaria'; // Fundo verde
                                    }
                                }
                            }
                            
                            // Gerar o select para a sala com a classe CSS aplicada
                            echo "<select name='{$sala_col}' class='form-control $sala_class'>";
                            echo "<option value=''>Selecione a Sala</option>";
                            foreach ($salas as $sala) {
                                // Seleciona a opção que corresponde ao ID da sala
                                $selected = ($row[$sala_col] == $sala['id_sala']) ? "selected" : "";
                                echo "<option value='" . htmlspecialchars($sala['id_sala']) . "' $selected>" . htmlspecialchars($sala['nome']) . "</option>";
                            }
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script>
        // AJAX para salvar alterações sem recarregar a página
        $('#form-horarios').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: 'salvar_horario.php',  // Arquivo PHP que irá salvar as alterações
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Horários atualizados com sucesso!');
                },
                error: function() {
                    alert('Ocorreu um erro ao salvar os horários.');
                }
            });
        });
    </script>
</body>
</html>
