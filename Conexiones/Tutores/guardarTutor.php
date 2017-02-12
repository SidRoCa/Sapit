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
    if(filter_input(INPUT_POST, 'nombres') and filter_input(INPUT_POST, 'apPaterno') and filter_input(INPUT_POST, 'idDepartamento') 
        and filter_input(INPUT_POST, 'nip') and filter_input(INPUT_POST, 'identificador')){
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
        $query = 'insert into tutores values(default, \''.$nombres.'\', \''.$apPaterno.'\', \''.$apMaterno.'\', \''.$correo.'\','.$idDepartamento.', \''.$nip.'\', \''.$telefono.'\', \''.$ciudad.'\', \''.$domicilio.'\', \''.$identificador.'\')';
        $res = pg_query($query);
        if($res){
            $queryUsuario = 'insert into usuarios values(default, \'tutor\',\''.$identificador.'\', \''.$nip.'\', \''.$nombres.' '.$apPaterno.' '.$apMaterno.'\', '.$idDepartamento.')';
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
