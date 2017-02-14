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
    if(filter_input(INPUT_POST, 'nombre') and filter_input(INPUT_POST, 'lugarTutoria') and filter_input(INPUT_POST, 'idPeriodo') 
             and filter_input(INPUT_POST, 'horario')){
        $nombre = $_POST['nombre'];
        $lugarTutoria = $_POST['lugarTutoria'];
        $idPeriodo = $_POST['idPeriodo'];
        $idTutor1 = $_POST['idTutor1'];
        $idTutor2 = $_POST['idTutor2'];
        $horario = $_POST['horario'];
        $conn->conectar();
        $query = 'insert into grupos values (default,\''.$nombre.'\',\''.$lugarTutoria.'\','.$idPeriodo.','.$idTutor1.','.$idTutor2.',\''.$horario.'\')';
        $res = pg_query($query);
        if($res){
        	echo "ok";
        }else{
        	echo "error";
        }
    }else{
        
        echo "error en filter inputs";
    }
?>
