<?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idTutoriaIndividual')){
        $idTutoriaIndividual = $_POST['idTutoriaIndividual'];
        $conn->conectar();
        $query = 'delete from tutorias_individual where id='.$idTutoriaIndividual;
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

