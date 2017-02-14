<?php

require "../../conexion.php";
$conn = new Connection();
if (filter_input(INPUT_POST, 'idAlumno')) {
    $idAlumno = $_POST['idAlumno'];
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $queryObtenerDatos = 'select no_control, nip from alumnos where id = ' . $idAlumno;
    $res = pg_query($queryObtenerDatos);
    $row = pg_fetch_array($res);
    if (isset($row)) {
        $noControl = $row['no_control'];
        $nip = $row['nip'];
        $queryDetalleGrupo = 'delete from det_grupos where id_alumno = ' . $idAlumno;
        
        $res1 = pg_query($queryDetalleGrupo);
        if ($res1) {
            $queryEliminarUsuario = 'delete from usuarios where usuario=\'' . $noControl . '\' and password = \'' . $nip . '\'';
            $res2 = pg_query($queryEliminarUsuario);
            if ($res2) {
                $queryEliminarAlumno = 'delete from alumnos where id = ' . $idAlumno;
                $res3 = pg_query($queryEliminarAlumno);
                if ($res3) {
                    pg_query('commit') or die("Ocurrió un error al guardar los datos en el sistema");
                    echo 'ok';
                } else {
                    pg_query("rollback");
                    echo 'error1';
                }
            } else {
                pg_query('rollback');
                echo 'error2';
            }
        } else {
            pg_query('rollback');
            echo 'error3';
        }
    } else {
        echo 'error4';
    }
} else {
    echo "error5";
}
?>
