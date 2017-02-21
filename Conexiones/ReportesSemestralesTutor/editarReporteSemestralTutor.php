<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "crddpt") {
    ?>
    <SCRIPT LANGUAGE="javascript">
        location.href = "validarSesion.php";
    </SCRIPT> 
<?php
}
require "../../conexion.php";
$conn = new Connection();
if(isset($_POST['det']) and filter_input(INPUT_POST, 'idReporte')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $det = $_POST['det'];
    $idReporte = $_POST['idReporte'];
    $observaciones = $_POST['observaciones'];
    $queryObservaciones = 'update reporte_tutor set observaciones = \''.$observaciones.'\' where id = '.$idReporte;
    $observacionesGuardado = pg_query($queryObservaciones);
    if($observacionesGuardado){
        $queryBorrarDet = 'delete from det_reporte_tutor where id_reporte_tutor = '.$idReporte;
        $detBorrado = pg_query($queryBorrarDet);
        if($detBorrado){
            $detGuardados = true;
            foreach ($det as $row) {
                $queryDet = 'insert into det_reporte_tutor values('.$idReporte.', '.$row['idAlumno'].', \''.$row['tutoriaGrupal'].'\', 
                    \''.$row['tutoriaIndividual'].'\', \''.$row['canalizado'].'\', \''.$row['areaCanalizada'].'\')';
                $resultDet = pg_query($queryDet);
                if($resultDet ==  false){
                    $detGuardados = false;
                }
            }
            if($detGuardados == true){
                pg_query('commit') or die ('No se completó la operación');
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
        pg_query('rollback');
        echo 'error3';
    }
}else{
    echo 'error4';
}
?>
