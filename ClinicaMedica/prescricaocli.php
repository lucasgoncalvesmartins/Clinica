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
    <title>Prescrições de <?php echo $nomePaciente; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Prescrições do paciente: <?php echo $nomePaciente; ?></h2>

        <?php
        $query = "
                    SELECT  m.nome AS nome_medicamento,p.quantidade
                    FROM prescricoes p
                    INNER JOIN medicamentos m ON p.id_medicamento = m.id
                    WHERE p.id_paciente = $idPaciente
    ";

        $resPrescricoes = $con->getConnection()->query($query);

        if ($resPrescricoes->num_rows > 0) {
            echo "<table class='table table-bordered mt-3'>
                <thead class='table-dark'>
                    <tr>
                        <th>Medicamento</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>";
            while ($row = $resPrescricoes->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['nome_medicamento']}</td>
                    <td>{$row['quantidade']}</td>
                  </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='mt-3'>Nenhuma prescrição encontrada.</p>";
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