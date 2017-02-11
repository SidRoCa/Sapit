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
    if(filter_input(INPUT_POST, 'nombreCarrera') and filter_input(INPUT_POST, 'idDepartamento')){
        $nombreCarrera = $_POST['nombreCarrera'];
        $idDepartamento = $_POST['idDepartamento'];
        $conn->conectar();
        $query = 'insert into carreras values (default,\''.$nombreCarrera.'\', '.$idDepartamento.')';
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
