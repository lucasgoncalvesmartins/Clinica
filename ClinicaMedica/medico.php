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
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lista de Medicos</title>
      
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">Lista de Médicos</h1>

                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'adm') { ?>
                  <div class="mt-4">
                  <a href="formularioM.php" class="btn btn-primary mb-4">Novo</a><br><br>
                  <a href="principaladm.php" class="btn btn-primary">Voltar para a Página Principal</a>
                </div>
            <?php } else { ?>
                <div class="mt-4">
                    <a href="principalcli.php" class="btn btn-primary">Voltar para a Página Principal</a>
                </div>
            <?php } ?>


                </div>

            </div>
            <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>CRM</th>
                    <th>Nome</th>
                    <th>Especialidade</th>
                    <th>Telefone</th>
                    <th>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'adm') { ?>
                        Ações
                <?php } ?>
                </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $consulta = $con->getConnection()->query("SELECT * FROM medicos");

                if ($consulta) {
                    while ($campo = $consulta->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $campo['CRM']; ?></td>
                        <td><?php echo $campo['nome']; ?></td>
                        <td><?php echo $campo['especialidade']; ?></td>
                        <td><?php echo $campo['telefone']; ?></td>
                        <td>
                        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'adm') { ?>
                            <a href="editarMedico.php?CRM=<?=($campo['CRM']); ?>" class="btn btn-sm btn-primary">Editar</a>
                <?php } ?>
                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === 'adm') { ?>
                            <a href="excluirM.php?CRM=<?= ($campo['CRM']); ?>" class="btn btn-sm btn-primary">Excluir</a>
                <?php } ?>
                </td>
                        
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-danger">Erro na consulta: ' . $con->getConnection()->error . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>




            
            
  


            
      
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php
    $con->disconnect();
?>