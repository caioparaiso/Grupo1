<?php
$host = 'localhost';
$db = 'escola';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obter o nome da turma da URL
$turmaNome = $_GET['turma'];

// Nome da tabela de horários baseado no nome da turma
$tabelaHorario = $turmaNome . '_horario';

// Consulta para obter o horário da turma
$horarioQuery = "SELECT * FROM $tabelaHorario";
$horarioResult = $conn->query($horarioQuery);

// Consulta para obter todos os números/códigos das salas
$salasQuery = "SELECT id_sala, nome FROM sala";
$salasResult = $conn->query($salasQuery);

// Verificar se há registros de salas
$salas = [];
if ($salasResult->num_rows > 0) {
    while ($sala = $salasResult->fetch_assoc()) {
        $salas[$sala['id_sala']] = $sala['nome'];
    }
}

// Verificar se há registros de horário
if ($horarioResult->num_rows > 0): ?>
    <form action="salvar_salas.php?turma=<?php echo htmlspecialchars($turmaNome); ?>" method="POST">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Horas</th>
                    <th>Seg</th>
                    <th>Sala</th>
                    <th>Ter</th>
                    <th>Sala</th>
                    <th>Qua</th>
                    <th>Sala</th>
                    <th>Qui</th>
                    <th>Sala</th>
                    <th>Sex</th>
                    <th>Sala</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $horarioResult->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php
                            // Converter bloco para horários
                            switch ($row['bloco']) {
                                case 'b1': echo '8:00 - 11:00'; break;
                                case 'b2': echo '11:00 - 14:00'; break;
                                case 'b3': echo '14:00 - 17:00'; break;
                                case 'b4': echo '17:00 - 20:00'; break;
                                default: echo htmlspecialchars($row['bloco']); break;
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['segunda']); ?></td>
                        <td>
                            <select name="salas[<?php echo $row['id']; ?>][s1]" class="form-select">
                                <option value="">Selecione a Sala</option>
                                <?php foreach ($salas as $id_sala => $nome): ?>
                                    <option value="<?php echo htmlspecialchars($id_sala); ?>" <?php echo ($row['s1'] == $id_sala) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($row['terça']); ?></td>
                        <td>
                            <select name="salas[<?php echo $row['id']; ?>][s2]" class="form-select">
                                <option value="">Selecione a Sala</option>
                                <?php foreach ($salas as $id_sala => $nome): ?>
                                    <option value="<?php echo htmlspecialchars($id_sala); ?>" <?php echo ($row['s2'] == $id_sala) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($row['quarta']); ?></td>
                        <td>
                            <select name="salas[<?php echo $row['id']; ?>][s3]" class="form-select">
                                <option value="">Selecione a Sala</option>
                                <?php foreach ($salas as $id_sala => $nome): ?>
                                    <option value="<?php echo htmlspecialchars($id_sala); ?>" <?php echo ($row['s3'] == $id_sala) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($row['quinta']); ?></td>
                        <td>
                            <select name="salas[<?php echo $row['id']; ?>][s4]" class="form-select">
                                <option value="">Selecione a Sala</option>
                                <?php foreach ($salas as $id_sala => $nome): ?>
                                    <option value="<?php echo htmlspecialchars($id_sala); ?>" <?php echo ($row['s4'] == $id_sala) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($row['sexta']); ?></td>
                        <td>
                            <select name="salas[<?php echo $row['id']; ?>][s5]" class="form-select">
                                <option value="">Selecione a Sala</option>
                                <?php foreach ($salas as $id_sala => $nome): ?>
                                    <option value="<?php echo htmlspecialchars($id_sala); ?>" <?php echo ($row['s5'] == $id_sala) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
<?php else: ?>
    <p class="text-center">Nenhum horário encontrado para essa turma.</p>
<?php endif;

$conn->close();
?>
