<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    $cpf = $_POST['usuario'];
    header('Location: principalcli.php');
    exit();
}


require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");


$medicos = $con->query("SELECT CRM, nome FROM medicos ORDER BY nome ASC");
$pacientes = $con->query("SELECT id, nome FROM pacientes ORDER BY nome ASC");

if (isset($_POST['agendar'])) {
    $CRM = $_POST['CRM'];
    $id_paciente = $_POST['id_paciente'];
    $data_consulta = $_POST['data_consulta'];
    $hora_consulta = $_POST['hora_consulta'];
    $diagnostico = $_POST['diagnostico'];

    $data_hora = $data_consulta . ' ' . $hora_consulta;

    $crud = new crud('consultas', 'localhost', 'root', '', 'clinica');
    $crud->inserir("CRM, id_paciente, diagnostico, data_hora",
        "'$CRM', '$id_paciente', '$diagnostico', '$data_hora'");

    header("Location: principalADM.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendar Consulta</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Agendar Consulta</h3>

            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Médico:</label>
                        <select class="form-select" name="CRM" required>
                            <option value="">Selecione</option>
                            <?php while ($m = $medicos->fetch_assoc()) { ?>
                                <option value="<?php echo $m['CRM']; ?>"><?php echo $m['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Paciente:</label>
                        <select class="form-select" name="id_paciente" required>
                            <option value="">Selecione</option>
                            <?php while ($p = $pacientes->fetch_assoc()) { ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data da Consulta:</label>
                        <input type="date" class="form-control" name="data_consulta" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hora da Consulta:</label>
                        <input type="time" class="form-control" name="hora_consulta" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnóstico:</label>
                        <textarea class="form-control" name="diagnostico" rows="4" required></textarea>
                    </div>

                    <div class="d-grid">
                      <button type="submit" name="agendar" class="btn btn-primary">Agendar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-4">
                    <a href="principalADM.php" class="btn btn-primary">Voltar para a Página Principal</a>
                </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $con->disconnect(); ?>
