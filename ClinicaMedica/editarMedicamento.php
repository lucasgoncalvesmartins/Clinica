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

if (!isset($_GET['id'])) {
    echo "ID do paciente não informado.";
    exit();
}

$getId = $_GET['id'];


$consulta = $con->getConnection()->query("SELECT * FROM medicamentos WHERE id = '$getId'");
if (!$consulta || $consulta->num_rows == 0) {
    echo "Paciente não encontrado.";
    exit();
}
$paciente = $consulta->fetch_assoc();


if (isset ($_POST['editar'])) { 
    $nome = $_POST['nome'];  
    $tipo = $_POST['tipo'];
    $uso = $_POST['uso']; 
    $crud = new crud('medicamentos','localhost','root','','clinica'); 
    $crud->atualizar("nome='$nome', tipo='$tipo', uso='$uso'", "id='$getId'");
    header("Location: medicamento.php"); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar  Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Dados do Medicamento</h2>

    <form action="editarMedicamento.php?id=<?php echo $getId; ?>" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $paciente['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">tipo:</label>
            <input type="text" name="tipo" id="tipo" class="form-control" value="<?php echo $paciente['tipo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="uso" class="form-label">Histórico:</label>
            <textarea name="uso" id="uso" class="form-control" rows="3"><?php echo $paciente['uso']; ?></textarea>
        </div>

        <button type="submit" name="editar" class="btn btn-success">Salvar Alterações</button>
        <a href="paciente.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
