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
    if(filter_input(INPUT_POST, 'idCoordinador') and filter_input(INPUT_POST, 'nombre') and filter_input(INPUT_POST, 'usuario') and filter_input(INPUT_POST, 'contraseña') and filter_input(INPUT_POST, 'idDepartamento')){
        $idCoordinador = $_POST['idCoordinador'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $idDepartamento = $_POST['idDepartamento'];
        $conn->conectar();
        $query = 'update usuarios set nombre = \'' . $nombre . '\' , usuario = \'' . $usuario . '\', password = \'' . $contraseña . '\', iddpto = ' . $idDepartamento . '  where id = ' . $idCoordinador;
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
