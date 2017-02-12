<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'nombre') and filter_input(INPUT_POST, 'apPaterno') and filter_input(INPUT_POST, 'apMaterno') 
        and filter_input(INPUT_POST, 'noControl') and filter_input(INPUT_POST, 'nip') and filter_input(INPUT_POST, 'idCarrera') 
        and filter_input(INPUT_POST, 'idGrupo')){
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
        $queryAlumno = 'insert into alumnos values(default, \''.$nombre.'\', \''.$apPaterno.'\', \''.$apMaterno.'\', \''.$correo.'\', '.$noControl.', \''.$nip.'\', \''.$telefono.'\', \''.$ciudad.'\', \''.$domicilio.'\', '.$idCarrera.', '.$idGrupo.', \''.$nombreTutor.'\', \''.$domicilioTutor.'\', \''.$telefonoTutor.'\', \''.$ciudadTutor.'\')';
        $res = pg_query($queryAlumno);
        if($res){
            $queryUsuario = 'insert into usuarios values(default, \'alumno\', \''.$noControl.'\', \''.$nip.'\', \''.$nombre.' '.$apPaterno.' '.$apMaterno.'\', NULL)';
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
