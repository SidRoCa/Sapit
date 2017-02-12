<?php
    require "../../conexion.php";
    $conn = new Connection();
    if(filter_input(INPUT_POST, 'idAlumno')){
        $idAlumno = $_POST['idAlumno'];
        $conn->conectar();
        pg_query('begin') or die("No se pudo comenzar la transacción");
        $queryObtenerDatos = 'select no_control, nip from alumnos where id = '.$idAlumno;
        $res = pg_query($queryObtenerDatos);
        $row = pg_fetch_array($res);
        if(isset($row)){
            $noControl = $row['no_control'];
            $nip = $row['nip'];    
            $queryEliminarAlumno = 'delete from alumnos where id = '.$idAlumno;
            $res1 = pg_query($queryEliminarAlumno);
            if($res1){
                $queryEliminarUsuario = 'delete from usuarios where usuario=\''.$noControl.'\' and password = \''.$nip.'\'';
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
