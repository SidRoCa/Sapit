<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'nombres') and filter_input(INPUT_POST, 'apPaterno') and filter_input(INPUT_POST, 'idDepartamento') and filter_input(INPUT_POST, 'nip') and 
        filter_input(INPUT_POST, 'telefono') and filter_input(INPUT_POST, 'ciudad') and filter_input(INPUT_POST, 'domicilio') and 
        filter_input(INPUT_POST, 'identificador') and filter_input(INPUT_POST, 'idTutor') and filter_input(INPUT_POST, 'identificadorAnterior')
         and filter_input(INPUT_POST, 'nipAnterior')){
        $idTutor = $_POST['idTutor'];
        $identificadorAnterior = $_POST['identificadorAnterior'];
        $nipAnterior = $_POST['nipAnterior'];
        $nombres = $_POST['nombres'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $correo = $_POST['correo'];
        $idDepartamento = $_POST['idDepartamento'];
        $nip = $_POST['nip'];
        $telefono = $_POST['telefono'];
        $ciudad = $_POST['ciudad'];
        $domicilio = $_POST['domicilio'];
        $identificador = $_POST['identificador'];
        $conn->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $query = 'update tutores set nombres = \''.$nombres.'\', ap_paterno = \''.$apPaterno.'\', ap_materno = \''.$apMaterno.'\', 
            correo = \''.$correo.'\', id_departamento = '.$idDepartamento.', nip = \''.$nip.'\', telefono = \''.$telefono.'\', cuidad = 
            \''.$ciudad.'\', domicilio = \''.$domicilio.'\', identificador = \''.$identificador.'\' where id = '.$idTutor;
        $res = pg_query($query);
        if($res){
            $queryUsuario = 'update usuarios set usuario = \''.$identificador.'\', password = \''.$nip.'\', nombre = \''.$nombres.' '.$apPaterno.' '.$apMaterno.'\' where usuario = \''.$identificadorAnterior.'\' and password = \''.$nipAnterior.'\'';
            $res2 = pg_query($queryUsuario);
            if($res2){
                pg_query('commit') or die("Ocurrió un error al guardar los datos en el sistema");
                echo "ok";
            }else{
                pg_query('rollback');
                echo 'error';
            }
        }else{
        	echo "error";
        }
    }else{
        echo "error";
    }
?>
