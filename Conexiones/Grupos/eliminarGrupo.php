<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idGrupo')){
        $idGrupo = $_POST['idGrupo'];
        $conn->conectar();
        $query = 'delete from grupos where id='.$idGrupo;
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
