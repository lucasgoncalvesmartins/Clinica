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
    <title>Pacientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<?php
    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); 
    $con->connect(); 
?>
<!DOCTYPE html>
<html>
    <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lista de cliente</title>
    </head>
    <body>

    <div class="card">
    <div class="card-header">
        <h2 class="h4">Lista de Pacientes</h2>
        <a href="formularioP.php" class="btn btn-primary mb-4">Novo</a>
        <div class="mt-4">
                    <a href="principalADM.php" class="btn btn-primary">Voltar para a Página Principal</a>
                </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Histórico</th>
                        <th>Telefone</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th> 
                    </tr>
                </thead>
                
                <tbody>
                    <?php
     
                        $consulta = $con->getConnection()->query("SELECT * FROM pacientes");

                        if ($consulta) {
                            while ($campo = $consulta->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $campo['nome']; ?></td>
                            <td><?php echo $campo['CPF']; ?></td>
                            <td><?php echo $campo['historico']; ?></td>
                            <td><?php echo $campo['telefone']; ?></td>
                            <td><?php echo $campo['data_nascimento']; ?></td>
                            <td>
                                <a href="editarPaciente.php?id=<?php echo $campo['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="excluirP.php?id=<?php echo $campo['id']; ?>" class="btn btn-sm btn-primary">Excluir</a>
                            </td>
                        </tr>
                    <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-danger">Erro na consulta: ' . $con->getConnection()->error . '</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </body>
</html>
<?php
    $con->disconnect(); 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>