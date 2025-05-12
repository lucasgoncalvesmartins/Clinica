<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");


$cpf = $_SESSION['usuario']; 

$resPaciente = $con->getConnection()->query("SELECT id, nome FROM pacientes WHERE cpf = '$cpf'");

if ($resPaciente->num_rows > 0) {
    $paciente = $resPaciente->fetch_assoc();
    $idPaciente = $paciente['id'];
    $nomePaciente = $paciente['nome'];
} else {
    echo "<p class='mt-3'>Paciente não encontrado.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Consultas do paciente: <?php echo $nomePaciente; ?></h2>

    <?php

    $resConsultas = $con->getConnection()->query("
        SELECT * FROM consultas WHERE id_paciente = $idPaciente
    ");

    if ($resConsultas->num_rows > 0) {
        echo "<table class='table table-bordered mt-3'>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>CRM</th>
                        <th>Diagnóstico</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $resConsultas->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['data_hora']}</td>
                    <td>{$row['CRM']}</td>
                    <td>{$row['diagnostico']}</td>
                    <td>R$ {$row['status']}</td>
                </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='mt-3'>Nenhuma consulta encontrada.</p>";
    }

    $con->disconnect();
    ?>

<div class="mt-4">
        <a href="principalcli.php" class="btn btn-primary">Voltar para a Página Principal</a>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
