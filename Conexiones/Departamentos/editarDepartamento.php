<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idDepartamento') and filter_input(INPUT_POST, 'nombreDepartamento')){
        $idDepartamento = $_POST['idDepartamento'];
        $nombreDepartamento = $_POST['nombreDepartamento'];
        $conn->conectar();
        $query = 'update departamentos set nombre = \''.$nombreDepartamento.'\' where id = '.$idDepartamento;
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
