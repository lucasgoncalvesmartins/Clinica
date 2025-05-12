<?php
include_once 'config/conexao.class.php';
include_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");

$crud = new CRUD('medicos', 'localhost', 'root', '', 'clinica');


if(isset($_GET['CRM'])) {
    $CRM = $_GET['CRM'];
    $crud->excluir("CRM = '$CRM'");
}

$con->disconnect();


header("Location: medico.php");
exit(); 
?>