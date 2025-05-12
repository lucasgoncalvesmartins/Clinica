<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    $cpf = $_POST['usuario'];
    header('Location: principalcli.php');
    exit();
}


mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");


    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); 
    $con->connect(); 

    @$getId = $_GET['id'];  

    if (@$getId) { 
        $consulta = $con->query("SELECT * FROM pacientes WHERE id = $getId");
        $campo = $consulta->fetch_assoc();
    }
   
    if (isset ($_POST['cadastrar'])) {  
        $nome = $_POST['nome']; 
        $tipo = $_POST['tipo'];
        $uso = $_POST['uso']; 
        $crud = new crud('medicamentos','localhost','root','','clinica');  
        $crud->inserir("nome, tipo, uso", "'$nome', '$tipo', '$uso'");
        header("Location: medicamento.php"); 
    }

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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Medicamentos</title>

   
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Cadastro de Medicamentos</h2>

    <form action="" method="post"> 
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo @$campo['nome']; ?>" />
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo @$campo['tipo']; ?>" />
        </div>

        <div class="mb-3">
            <label for="uso" class="form-label">Uso:</label>
            <input type="text" class="form-control" id="uso" name="uso" value="<?php echo @$campo['uso']; ?>" />
        </div>

        <?php
            if (@!$campo['id']) { 
        ?>
            <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
        <?php } else {  ?>
            <button type="submit" name="editar" class="btn btn-warning">Editar</button>   
        <?php } ?>
    </form>
</div>


<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>


