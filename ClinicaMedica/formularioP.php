<?php

session_start();


if (isset($_SESSION['usuario'])) {
    header('Location: principalcli.php');
    exit();
}


    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); 
    $con->connect(); 

    mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");


    @$getId = $_GET['id'];  

    if (@$getId) { 
        $consulta = $con->query("SELECT * FROM pacientes WHERE id = $getId");
        $campo = $consulta->fetch_assoc();
    }
   
 
    
    if (isset($_POST['cadastrar'])) {  
        $nome = $_POST['nome'];
        $CPF = $_POST['CPF'];
        $historico = $_POST['historico'];
        $telefone = $_POST['telefone'];
        $data_nascimento = $_POST['data_nascimento'];
        $senha = $_POST['senha'];
    
       
        require_once 'config/crud.class.php';
        $crud = new crud('pacientes','localhost','root','','clinica');
        $crud->inserir("nome, CPF, historico, telefone, data_nascimento, senha", "'$nome', '$CPF', '$historico', '$telefone', '$data_nascimento', '$senha'");
    
        
        if ($CPF == 'adm' && $senha == '123') {
            $_SESSION['usuario'] = $CPF;
            header('Location: principalAdm.php');  
            exit();
        } else {
            require_once 'config/conexao.class.php';
            $con = new conexao();
            $con->connect();
    
            $consulta = $con->getConnection()->query(
                "SELECT * FROM pacientes WHERE CPF = '$CPF' AND senha = '$senha'"
            );
    
            $campo = $consulta->fetch_assoc();  
    
            if ($campo) {
                $_SESSION['nome'] = $campo['nome'];
                $_SESSION['usuario'] = $campo['CPF'];
                $_SESSION['id_paciente'] = $campo['id'];
    
             
                header('Location: principalcli.php');
                exit();
            } else {
             
                echo 'Usuário ou senha inválidos';
            }
    
            $con->disconnect();  
        }
    }
  
    
    
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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Cadastrar Paciente</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Cadastrar Paciente</h2>
        <form action="" method="post">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo @$campo['nome']; ?>" />
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="CPF" value="<?php echo @$campo['CPF']; ?>" />
            </div>

            <div class="form-group">
                <label for="historico">Histórico:</label>
                <input type="text" class="form-control" id="historico" name="historico" value="<?php echo @$campo['historico']; ?>" />
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo @$campo['telefone']; ?>" />
            </div>

            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo @$campo['data_nascimento']; ?>" />
            </div>

            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="text" class="form-control" id="senha" name="senha" value="<?php echo @$campo['senha']; ?>" />
            </div>

            <?php
                if (@!$campo['id']) {
            ?>
                <button type="submit" class="btn btn-primary" name="cadastrar">Cadastrar</button>
            <?php } else { ?>
                <button type="submit" class="btn btn-warning" name="editar">Editar</button>
            <?php } ?>
        </form>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


<?php
    $con->disconnect(); 
?>