<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'nombre') and filter_input(INPUT_POST, 'apPaterno') and filter_input(INPUT_POST, 'apMaterno') 
        and filter_input(INPUT_POST, 'noControl') and filter_input(INPUT_POST, 'nip') and filter_input(INPUT_POST, 'idCarrera') 
        and filter_input(INPUT_POST, 'idGrupo') and filter_input(INPUT_POST, 'noControlAnterior') and filter_input(INPUT_POST, 'nipAnterior') and
        filter_input(INPUT_POST, 'idAlumno')){
        $idAlumno = $_POST['idAlumno'];
        $noControlAnterior = $_POST['noControlAnterior'];
        $nipAnterior = $_POST['nipAnterior'];
        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $correo = $_POST['correo'];
        $noControl = $_POST['noControl'];
        $nip = $_POST['nip'];
        $telefono = $_POST['telefono'];
        $ciudad = $_POST['ciudad'];
        $domicilio = $_POST['domicilio'];
        $nombreTutor = $_POST['nombreTutor'];
        $domicilioTutor = $_POST['domicilioTutor'];
        $telefonoTutor = $_POST['telefonoTutor'];
        $ciudadTutor = $_POST['ciudadTutor'];
        $idCarrera = $_POST['idCarrera'];
        $idGrupo = $_POST['idGrupo'];
        $conn->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $queryAlumno = 'update alumnos set nombres = \''.$nombre.'\', ap_paterno = \''.$apPaterno.'\', ap_materno=\''.$apMaterno.'\', correo = \''.$correo.'\', no_control ='.$noControl.', nip = \''.$nip.'\', telefono = \''.$telefono.'\', ciudad = \''.$ciudad.'\', domicilio = \''.$domicilio.'\', nombres_tutor = \''.$nombreTutor.'\', domicilio_tutor = \''.$domicilioTutor.'\', telefono_tutor=\''.$telefonoTutor.'\', ciudad_tutor = \''.$ciudadTutor.'\', id_carrera = '.$idCarrera.', id_grupo = '.$idGrupo.' where id = '.$idAlumno;
        $res = pg_query($queryAlumno);
        if($res){
            $queryUsuario = 'update usuarios set usuario = \''.$noControl.'\', password = \''.$nip.'\', nombre = \''.$nombre.' '.$apPaterno.' '.$apMaterno.'\' where usuario= \''.$noControlAnterior.'\' and password = \''.$nipAnterior.'\'';
            $res2 = pg_query($queryUsuario);
            if($res2){
                pg_query('commit') or die("Ocurrió un error al guardar los datos en el sistema");
                echo 'ok';
            }else{
                pg_query("rollback");
                echo 'error1';
            }
        }else{
            pg_query("rollback");
            echo 'error2';
        }    
    }else{
        echo "error3";
    }
?>
