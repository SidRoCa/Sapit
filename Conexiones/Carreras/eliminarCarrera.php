<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idCarrera')){
        $idCarrera = $_POST['idCarrera'];
        $conn->conectar();
        $query = 'delete from carreras where id='.$idCarrera;
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
