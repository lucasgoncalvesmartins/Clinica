<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    $cpf = $_POST['usuario'];
    header('Location: principalcli.php');
    exit();
}


require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

mysqli_query($con->getConnection(), "SET @usuario_logado = '" . @$_SESSION['usuario'] . "'");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./meucss/estilo.css">
    <title>Document</title>
</head>
<body>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button
            class="nav-link active"
            id="home-tab"
            data-bs-toggle="tab"
            data-bs-target="#home"
            type="button"
            role="tab"
            aria-controls="home"
            aria-selected="true"
        >
            Principal
        </button>
    </li>


    <li class="nav-item dropdown" role="presentation">
        <a
            class="nav-link dropdown-toggle"
            href="consulta.php"
            id="cadastrosDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
        >
            Consultas
        </a>
        <ul class="dropdown-menu" aria-labelledby="cadastrosDropdown">
            <li><a class="dropdown-item" href="consultas.php">Minhas consultas</a></li>
            <li><a class="dropdown-item" href="agendaConsultaCli.php"> Agendar Consulta</a></li>
            <li><a class="dropdown-item" href="prescricaocli.php"> Minhas Prescrições</a></li>
        </ul>

    </li>
    <li class="nav-item" role="presentation">
    <a
        class="nav-link active"
        id="home-tab"
        href="medico.php"
        role="tab"
        aria-controls="home"
        aria-selected="true"
    >
        Médicos
    </a>
    </li>
    <li class="nav-item" role="presentation">
        <button
            class="nav-link active"
            id="home-tab"
            data-bs-toggle="tab"
            data-bs-target="#home"
            type="button"
            role="tab"
            aria-controls="home"
            aria-selected="true"
        >
            Fale Conosco
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <a href="logout.php" class="btn btn-danger m-1">Encerrar Sessão</a>
    </li>
</div>

</ul>
<img src="./img/trabprog.webp" alt="" id="med">





<div class="container mt-5">
    <?php 
   echo  '<strong>Bem-vindo, ' . $_SESSION['nome'] . '! </strong>';
    ?>
    <h2 class="text-center mb-4">Clínica Vida Saudável</h2>

    

    <div class="mb-5">
        <h4>Missão</h4>
        <p>Oferecer atendimento humanizado e de excelência, promovendo saúde, bem-estar e qualidade de vida para nossos pacientes com tecnologia e carinho.</p>
    </div>

    <div class="mb-5">
        <h4>Quem Somos</h4>
        <p>Somos uma clínica médica moderna e acolhedora, com mais de 10 anos de experiência em medicina preventiva, diagnóstica e especializada, dedicada a cuidar de você e da sua família.</p>
    </div>

    <div class="mb-5">
        <h4>Nossa Equipe</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dr. Carlos Mendes</h5>
                        <p class="card-text">Clínico Geral com 15 anos de experiência em medicina da família.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dra. Juliana Rocha</h5>
                        <p class="card-text">Pediatra especializada em desenvolvimento infantil.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dr. Rafael Lima</h5>
                        <p class="card-text">Cardiologista dedicado à prevenção e ao diagnóstico precoce.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="js/bootstrap.bundle.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">    
</body>
</html>