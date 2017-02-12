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
    if(filter_input(INPUT_POST, 'idTutoriaIndividual') and filter_input(INPUT_POST, 'idGrupo') and  filter_input(INPUT_POST, 'fecha') and filter_input(INPUT_POST, 'solicPor') and filter_input(INPUT_POST, 'motivos')and filter_input(INPUT_POST, 'aspectos') and filter_input(INPUT_POST, 'conclusiones') and filter_input(INPUT_POST, 'observaciones') and filter_input(INPUT_POST, 'proxFecha') and filter_input(INPUT_POST, 'idAlumno') and filter_input(INPUT_POST, 'idTutor') ){
        $idTutoriaIndividual = $_POST['idTutoriaIndividual'];
        $idGrupo = $_POST['idGrupo'];
        $fecha = $_POST['fecha'];
        $solicPor = $_POST['solicPor'];
        $motivos = $_POST['motivos'];
        $aspectos = $_POST['aspectos'];
        $conclusiones = $_POST['conclusiones'];
        $observacioes = $_POST['observaciones'];
        $proxFecha = $_POST['proxFecha'];
        $idAlumno = $_POST['idAlumno'];
        $idTutor = $_POST['idTutor'];
        $conn->conectar();
        $query = 'update tutorias_individual set fecha = \''. $fecha .'\', solicitada_por = \''. $solicPor.'\', motivos = \''.$motivos.'\', aspectos_tratados = \''.$aspectos.'\', conclusiones = \''.$conclusiones.'\', observaciones = \''.$observacioes.'\', fecha_prox_visita = \''.$proxFecha.'\', id_alumno = '.$idAlumno.' where id= '.$idTutoriaIndividual;
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
