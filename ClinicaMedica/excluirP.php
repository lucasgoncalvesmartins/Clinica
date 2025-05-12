<?php
    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao();  
    $con->connect(); 

    mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");

    $crud = new crud('pacientes','localhost','root','','clinica'); 
    $id = $_GET['id']; 

    
    $crud->excluir("id = $id"); 

    $con->disconnect(); 

    header("Location: paciente.php"); 
?>