<?php

session_start();

    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';
   

    $con = new conexao(); 
    $con->connect(); 

    mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");

    if (@$_POST['cpf'] == 'adm' && $_POST['senha'] == '123') {
        $_SESSION['usuario'] = @$_POST['cpf'];
  
        mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");
    
    
        mysqli_query($con->getConnection(), "
            INSERT INTO log (usuario, acao, tabela_afetada, detalhes)
            VALUES ('" . @$_SESSION['usuario'] . "', 'LOGIN', 'sistema', 'Administrador acessou o sistema')
        ");
    
        header('Location: principalADM.php');
        exit();
    }

    if(isset($_POST['cpf'])){
        $cpf = $_POST['cpf'];
    }
    
    if(isset($_POST['senha'])){
        $senha = $_POST['senha'];
    }
    
    $consulta = $con->getConnection()->query(
        "SELECT * FROM pacientes WHERE CPF = '" . @$cpf . "' AND senha = '" . @$senha . "'"
    );

    $campo = $consulta->fetch_assoc(); 



    if ($campo) {
        $_SESSION['nome'] = $campo['nome'];
        $_SESSION['usuario'] = $campo['CPF'];
        $_SESSION['id_paciente'] = $campo['id'];
    
        
        mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");
    
       
        mysqli_query($con->getConnection(), "
            INSERT INTO log (usuario, acao, tabela_afetada, detalhes)
            VALUES ('" . @$_SESSION['usuario'] . "', 'LOGIN', 'sistema', 'Usuário acessou o sistema')
        ");
    
        header("Location: principalcli.php");
        exit(); 
    }
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input 
                    type="text"
                    class="form-control"
                    name="cpf"
                    id="usuariologin"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input 
                    type="password"
                    class="form-control"
                    name="senha"
                    id="senha"
                    required
                />
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>