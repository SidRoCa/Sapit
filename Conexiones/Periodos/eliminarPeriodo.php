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
    if(filter_input(INPUT_POST, 'idPeriodo')){
        $idPeriodo = $_POST['idPeriodo'];
        $conn->conectar();
        $query = 'delete from periodos where id='.$idPeriodo;
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