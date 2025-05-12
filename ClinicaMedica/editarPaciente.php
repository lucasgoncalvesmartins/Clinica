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


$consulta = $con->getConnection()->query("SELECT * FROM pacientes WHERE id = '$getId'");
if (!$consulta || $consulta->num_rows == 0) {
    echo "Paciente não encontrado.";
    exit();
}
$paciente = $consulta->fetch_assoc();


if (isset ($_POST['editar'])) { 
    $nome = $_POST['nome'];  
    $CPF = $_POST['CPF'];
    $historico = $_POST['historico']; 
    $telefone = $_POST['telefone'];  
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];
    $crud = new crud('pacientes','localhost','root','','clinica'); 
    $crud->atualizar("nome='$nome', CPF='$CPF', historico='$historico', telefone=$telefone, data_nascimento=$data_nascimento, senha=$senha", "id='$getId'"); 
    header("Location: paciente.php"); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Dados do Paciente</h2>

    <form action="editarPaciente.php?id=<?php echo $getId; ?>" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $paciente['nome']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="CPF" class="form-label">CPF:</label>
            <input type="text" name="CPF" id="CPF" class="form-control" value="<?php echo $paciente['CPF']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="historico" class="form-label">Histórico:</label>
            <textarea name="historico" id="historico" class="form-control" rows="3"><?php echo $paciente['historico']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo $paciente['telefone']; ?>" required>
        </div>
        <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo @$campo['data_nascimento']; ?>" />
            </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="text" name="senha" id="senha" class="form-control" value="<?php echo $paciente['senha']; ?>" required>
        </div>

        <button type="submit" name="editar" class="btn btn-success">Salvar Alterações</button>
        <a href="paciente.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
