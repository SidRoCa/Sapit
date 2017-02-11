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
    if(filter_input(INPUT_POST, 'idPeriodo') and  filter_input(INPUT_POST, 'nombrePeriodo') and filter_input(INPUT_POST, 'fechaInicio') and filter_input(INPUT_POST, 'fechaFin')){
        $idPeriodo = $_POST['idPeriodo'];
        $nombrePeriodo = $_POST['nombrePeriodo'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $conn->conectar();
        $query = 'update periodos set identificador = \''. $nombrePeriodo .'\', fecha_inicio = \''. $fechaInicio.'\', fecha_fin = \''.$fechaFin.'\' where id= '.$idPeriodo;
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