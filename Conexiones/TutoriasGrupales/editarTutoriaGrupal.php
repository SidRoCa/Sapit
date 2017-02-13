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
    if(filter_input(INPUT_POST, 'idTutoriaGrupal') and filter_input(INPUT_POST, 'idGrupo') and  filter_input(INPUT_POST, 'fecha') and filter_input(INPUT_POST, 'lugarTuto') and filter_input(INPUT_POST, 'temaTuto')and filter_input(INPUT_POST, 'idTutor') ){
        $idTutoriaGrupal = $_POST['idTutoriaGrupal'];
        $idGrupo = $_POST['idGrupo'];
        $fecha = $_POST['fecha'];
        $lugarTutoria = $_POST['lugarTuto'];
        $temaTutoria = $_POST['temaTuto'];
        $idTutor = $_POST['idTutor'];
        $conn->conectar();
        $query = 'update tutorias_grupal set id_Grupo = '. $idGrupo .', fecha = \''. $fecha .'\', tema = \''. $temaTutoria.'\', lugar = \''.$lugarTutoria.'\' where id= '.$idTutoriaGrupal;
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

