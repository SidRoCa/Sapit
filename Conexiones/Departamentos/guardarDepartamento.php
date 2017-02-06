<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'nombreDepartamento')){
        $nombreDepartamento = $_POST['nombreDepartamento'];
        $conn->conectar();
        $query = 'insert into departamentos values (default,\''.$nombreDepartamento.'\')';
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
