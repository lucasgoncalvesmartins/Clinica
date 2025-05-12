<?php
session_start();
session_unset();
session_destroy();
header("Location: inicial.php");
exit();


?>



