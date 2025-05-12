<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    $cpf = $_POST['usuario'];
    header('Location: index.php');
    exit();
}


require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");


    @$getId = $_GET['id'];  

    if (@$getId) { 
        $consulta = $con->query("SELECT * FROM produto WHERE id = $getId");
        $campo = $consulta->fetch_assoc();
    }
   
    if (isset ($_POST['cadastrar'])) {  
        $CRM = $_POST['CRM'];  
        $nome = $_POST['nome']; 
        $telefone = $_POST['telefone'];
        $especialidade = $_POST['especialidade'];
        $crud = new crud('medicos','localhost','root','','clinica');  
        $crud->inserir("crm, nome, telefone,  especialidade", "'$CRM', '$nome', '$telefone', '$especialidade'"); 
        header("Location: medico.php"); 
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar de Médico</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Cadastrar de Médico</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">CRM:</label>
                        <input type="text" class="form-control" name="CRM" value="<?php echo @$campo['CRM']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo @$campo['nome']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefone:</label>
                        <input type="text" class="form-control" name="telefone" value="<?php echo @$campo['telefone']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Especialidade:</label>
                        <input type="text" class="form-control" name="especialidade" value="<?php echo @$campo['especialidade']; ?>">
                    </div>

                    <div class="d-grid gap-2">
                        <?php if (@!$campo['id']) { ?>
                            
                                <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>

                        <?php }  ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>



<?php
    $con->disconnect(); 
?>