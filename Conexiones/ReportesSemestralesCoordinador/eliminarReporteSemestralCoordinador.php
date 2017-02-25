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
    $queryBorrarDet = 'delete from det_reporte_coordinador_departamental where id_reporte_coordinador_departamental = '.$idReporte;
    $resultBorrarDet = pg_query($queryBorrarDet);
    if($resultBorrarDet){
        $queryBorrarRep = 'delete from reporte_coordinador_departamental where id = '.$idReporte;
        $resultBorrarRep = pg_query($queryBorrarRep);
        if($resultBorrarRep){
            pg_query('commit') or die ('No se completó la operación');
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
