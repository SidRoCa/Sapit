<?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "admin") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idCoordinador')){
        $idCoordinador = $_POST['idCoordinador'];
        $conn->conectar();
        $query = 'delete from usuarios where id='.$idCoordinador;
        $res = pg_query($query);
        if($res){  
        	echo "ok";
        }else{
        	echo "error";
        }
    }else{
        echo "error";
    }
?>