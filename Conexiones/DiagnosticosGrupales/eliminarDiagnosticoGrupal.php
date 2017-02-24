<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "crdinst") {
    ?>
    <SCRIPT LANGUAGE="javascript">
        location.href = "validarSesion.php";
    </SCRIPT> 
<?php
}
require "../../conexion.php";
$conn = new Connection();
if(filter_input(INPUT_POST, 'idDiagnostico')){
    $conn->conectar();
    $idDiagnostico = $_POST['idDiagnostico'];
    pg_query('begin') or die ('No se pudo iniciar la transacción');
    $queryBorrarDet = 'delete from det_diagnostico_grupo where id_diagnostico_grupo = '.$idDiagnostico;
    $resultBorrarDet = pg_query($queryBorrarDet);
    if($resultBorrarDet){
        $queryBorrarDiag = 'delete from diagnostico_grupo where id = '.$idDiagnostico;
        $resultBorrarDiag = pg_query($queryBorrarDiag);
        if($resultBorrarDiag){
            pg_query('commit') or die('No se completó la operación');
            echo 'ok';
        }else{
            pg_query('rollback');
            echo 'error3';
        }
    }else{
        pg_query('rollback');
        echo 'error2';
    }
}else{
    echo 'error';
}
?>
