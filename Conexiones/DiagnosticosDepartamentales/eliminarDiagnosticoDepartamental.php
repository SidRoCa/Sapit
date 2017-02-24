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
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $queryBorrarDet = 'delete from det_diagnostico_departamental where id_diagnostico_departamental = '.$idDiagnostico;
    $resultBorrarDet = pg_query($queryBorrarDet);
    if($resultBorrarDet){
        $queryBorrarDiag = 'delete from diagnostico_departamental where id = '.$idDiagnostico;
        $resultBorrarDiag = pg_query($queryBorrarDiag);
        if($resultBorrarDiag){
            pg_query('commit') or die('No se pudo completar la operación');
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
