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
    if(filter_input(INPUT_POST, 'idTutor')){
        $idTutor = $_POST['idTutor'];
        $conn->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $queryObtenerDatos = 'select identificador, nip from tutores where id = '.$idTutor;
        $res = pg_query($queryObtenerDatos);
        $row = pg_fetch_array($res);
        if(isset($row)){
            $identificador = $row['identificador'];
            $nip = $row['nip'];    
            $queryEliminarTutor = 'delete from tutores where id = '.$idTutor;
            $res1 = pg_query($queryEliminarTutor);
            if($res1){
                $queryEliminarUsuario = 'delete from usuarios where usuario=\''.$identificador.'\' and password = \''.$nip.'\'';
                $res2 = pg_query($queryEliminarUsuario);
                if($res2){
                    pg_query('commit');
                    echo 'ok';
                }else{
                    pg_query('rollback');
                    echo 'error1';     
                }
            }else{
                pg_query('rollback');
                echo 'error2'; 
            }
        }else{
            echo 'error3'; 
        }
        
    }else{
        echo "error4";
    }
?>
