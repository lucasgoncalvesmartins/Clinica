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
    <title>Document</title>
</head>
<body>
<?php
    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); 
    $con->connect(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lista de Medicamentos</title>
       
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ1QR+6t3Yf4Jzz2TSfiQ5jsmlbTxkCh+nQhPEkLCTsTb5DO1zmTxaAYw22O" crossorigin="anonymous">
    </head>
    <body>

        <div class="container mt-4">
            <h1 class="mb-4">Lista de Medicamentos</h1>
            <a href="formularioMedicamento.php" class="btn btn-primary mb-4">Novo</a>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Uso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $consulta = $con->getConnection()->query("SELECT * FROM medicamentos");

                        if ($consulta) {
                            while ($campo = $consulta->fetch_assoc()) { 
                    ?>
                                <tr>
                                    <td><?php echo $campo['nome']; ?></td>
                                    <td><?php echo $campo['tipo']; ?></td>
                                    <td><?php echo $campo['uso']; ?></td>
                                    <td>
                                    <a href="editarMedicamento.php?id=<?php echo $campo['id']; ?>" class="btn btn-sm btn-primary">editar</a><br><br>
                                    </td>
                                </tr>
                    <?php
                            }
                        } else {
                            echo '<tr><td colspan="3" class="text-center text-danger">Erro na consulta: ' . $con->getConnection()->error . '</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            <a href="principaladm.php" class="btn btn-primary">Voltar para a Página Principal</a>
        </div>
        

       
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybWk8xWRF2p2RUxML9f1WnvfTgFhU2Zy0B2k5f5OM5gq4kBhk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0D3U+IW4xkVek/Xp3Pkp5q94C7tfo5IWmb7QX9vvAy+Lk8F7" crossorigin="anonymous"></script>

    </body>
</html>
<?php
    $con->disconnect(); 
?>


<script src="js/bootstrap.bundle.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet">   
</body>
</html>