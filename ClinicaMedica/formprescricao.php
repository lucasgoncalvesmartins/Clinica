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


$consultas = $con->query("SELECT id_consulta, CRM, id_paciente FROM consultas ORDER BY id_consulta ASC");

$medicos = $con->query("SELECT CRM, nome FROM medicos ORDER BY nome ASC");
$medicamentos = $con->query("SELECT id, nome FROM medicamentos ORDER BY nome ASC");

if (isset($_POST['prescrever'])) {
    $id_consulta = $_POST['id_consulta'];
    $CRM = $_POST['CRM'];
    $id_paciente = $_POST['id_paciente'];
    $id_medicamento = $_POST['id_medicamento'];
    $quantidade = $_POST['quantidade'];

    $crud = new crud('prescricoes', 'localhost', 'root', '', 'clinica');
    $crud->inserir("id_consulta, CRM, id_paciente, id_medicamento, quantidade", 
        "'$id_consulta', '$CRM', '$id_paciente', '$id_medicamento', '$quantidade'");

    header("Location: listaprescricao.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Prescrição</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Disponibilizar prescrições</h3>
            </div>
        

            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Consulta (ID):</label>
                        <select class="form-select" name="id_consulta" required>
                            <option value="">Selecione</option>
                            <?php while ($consulta = $consultas->fetch_assoc()) { ?>
                                <option value="<?php echo $consulta['id_consulta']; ?>"><?php echo $consulta['id_consulta']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Médico:</label>
                        <select class="form-select" name="CRM" required>
                            <option value="">Selecione</option>
                            <?php while ($medico = $medicos->fetch_assoc()) { ?>
                                <option value="<?php echo $medico['CRM']; ?>"><?php echo $medico['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Paciente:</label>
                        <select class="form-select" name="id_paciente" required>
                            <option value="">Selecione</option>
                            <?php 

                            $pacientes = $con->query("SELECT id, nome FROM pacientes ORDER BY nome ASC");
                            while ($paciente = $pacientes->fetch_assoc()) { ?>
                                <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Medicamento:</label>
                        <select class="form-select" name="id_medicamento" required>
                            <option value="">Selecione</option>
                            <?php while ($medicamento = $medicamentos->fetch_assoc()) { ?>
                                <option value="<?php echo $medicamento['id']; ?>"><?php echo $medicamento['nome']; ?></option> 
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantidade:</label>
                        <input type="number" class="form-control" name="quantidade" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="prescrever" class="btn btn-primary">Prescrever</button>
                    </div>
                    <div class="d-grid">
                 <a href="listarConsulta.php" class="btn btn-primary">Listar Consultas</a>
            </div>
                </form>
            </div>
        </div>
        <a href="principaladm.php" class="btn btn-primary">Voltar para a Página Principal</a>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $con->disconnect(); ?>
