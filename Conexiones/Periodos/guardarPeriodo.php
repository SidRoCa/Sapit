<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'nombrePeriodo') and filter_input(INPUT_POST, 'fechaInicio') and filter_input(INPUT_POST, 'fechaFin')){
        $nombrePeriodo = $_POST['nombrePeriodo'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $conn->conectar();
        $query = 'insert into periodos values (default,\''.$nombrePeriodo.'\',\''.$fechaInicio.'\',\''.$fechaFin.'\')';
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
