<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idDepartamento')){
        $idDepartamento = $_POST['idDepartamento'];
        $conn->conectar();
        $query = 'delete from departamentos where id = '.$idDepartamento;
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
