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


if (!isset($_GET['CRM'])) {
    echo "CRM do Medico não informado.";
    exit();
}

$getId = $_GET['CRM'];


$consulta = $con->getConnection()->query("SELECT * FROM medicos WHERE CRM = '$getId'");
if (!$consulta || $consulta->num_rows == 0) {
    echo "Medico não encontrado.";
    exit();
}
$medico = $consulta->fetch_assoc();


if (isset ($_POST['editar'])) { 
    $CRM = $_POST['CRM'];  
    $nome = $_POST['nome']; 
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];
    $crud = new crud('medicos','localhost','root','','clinica'); 
    $crud->atualizar("nome='$nome', telefone='$telefone', especialidade='$especialidade'","CRM='$CRM'"); 
    header("Location: medico.php"); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Medico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Dados do Medico</h2>

    <form action="editarMedico.php?CRM=<?php echo $getId; ?>" method="post">
    <div class="mb-3">
            <label for="CRM" class="form-label">Nome:</label>
            <input type="text" name="CRM" id="CRM" class="form-control" value="<?php echo @$medico['CRM']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo @$medico['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="CPF" class="form-label">Especialidade:</label>
            <input type="text" name="especialidade" id="especialidade" class="form-control" value="<?php echo @$medico['especialidade']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo @$medico['telefone']; ?>" required>
        </div>


        <button type="submit" name="editar" class="btn btn-success">Salvar Alterações</button>
        <a href="medico.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
