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
if(filter_input(INPUT_POST, 'idReporte')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $idReporte = $_POST['idReporte'];
    $queryBorrarDet = 'delete from det_reporte_tutor where id_reporte_tutor = '.$idReporte;
    $resultBorrarDet = pg_query($queryBorrarDet);
    if($resultBorrarDet){
        $queryBorrarReporte = 'delete from reporte_tutor where id = '.$idReporte;
        $resultBorrarReporte = pg_query($queryBorrarReporte);
        if($resultBorrarReporte){
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
