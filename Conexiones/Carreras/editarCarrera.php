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
    if(filter_input(INPUT_POST, 'idCarrera') and filter_input(INPUT_POST, 'nombreCarrera') and filter_input(INPUT_POST, 'idDepartamento')){
        $idCarrera = $_POST['idCarrera'];
        $nombreCarrera = $_POST['nombreCarrera'];
        $idDepartamento = $_POST['idDepartamento'];
        $conn->conectar();
        $query = 'update carreras set nombre = \''.$nombreCarrera.'\' , id_departamento = '.$idDepartamento.' where id = '.$idCarrera;
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
