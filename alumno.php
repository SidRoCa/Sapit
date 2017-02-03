<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "alumno") {
    ?>
    <SCRIPT LANGUAGE="javascript">
        location.href = "validarSesion.php";
    </SCRIPT> 
    <?php
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sapit</title>
    </head>
    <body>
        <h1>Página de alumno</h1>
        <?php
         echo ('<p>Alumno: '. $_SESSION['k_username'] . ' <p>');
        ?>
        
       

    <p><a href="logout.php">Logout</a></p>
    </body>
</html>