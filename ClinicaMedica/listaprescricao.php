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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Prescrição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php
    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); 
    $con->connect(); 
?>

<div class="card">
    <div class="card-header">
        <h1 class="h3">Lista Prescrição</h1>
        <div class="mt-4">
                  <a href="formularioM.php" class="btn btn-primary mb-4">Novo</a><br><br>
                  <a href="principaladm.php" class="btn btn-primary">Voltar para a Página Principal</a>
                </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID Prescrição</th>
                        <th>ID Consulta</th>
                        <th>CRM Médico</th>
                        <th>ID Paciente</th>
                        <th>ID Medicamento</th>
                        <th>quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $consulta = $con->getConnection()->query("SELECT * FROM prescricoes");

                        if ($consulta) {
                            while ($campo = $consulta->fetch_assoc()) {
                    ?>
                                <tr>
                                    <td><?php echo $campo['id_prescricao']; ?></td>
                                    <td><?php echo $campo['id_consulta']; ?></td>
                                    <td><?php echo $campo['CRM']; ?></td>
                                    <td><?php echo $campo['id_paciente']; ?></td>
                                    <td><?php echo $campo['id_medicamento']; ?></td>
                                    <td><?php echo $campo['quantidade']; ?></td>
                                    
                                </tr>
                    <?php
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-danger">Erro na consulta: ' . $con->getConnection()->error . '</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</div>

<?php
    $con->disconnect(); 
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>