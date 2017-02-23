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
if(isset($_POST['det']) and filter_input(INPUT_POST, 'idReporte') and filter_input(INPUT_POST, 'programaEducativo') and 
    filter_input(INPUT_POST, 'departamentoAcademico')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $det = $_POST['det'];
    $idReporte = $_POST['idReporte'];
    $observaciones = $_POST['observaciones'];
    $programaEducativo = $_POST['programaEducativo'];
    $departamentoAcademico = $_POST['departamentoAcademico'];
    $queryActualizarReporte = 'update reporte_coordinador_departamental set programa_educativo = \''.$programaEducativo.'\', 
    departamento_academico = \''.$departamentoAcademico.'\', observaciones = \''.$observaciones.'\' where id = '.$idReporte;
    $resultActualizarReporte = pg_query($queryActualizarReporte);
    if($resultActualizarReporte){
        $queryBorrarDet = 'delete from det_reporte_coordinador_departamental where id_reporte_coordinador_departamental = '.$idReporte;
        $resultBorrarDet = pg_query($queryBorrarDet);
        if($resultBorrarDet){
            $terminado = true;
            foreach ($det as $row) {
                $query = 'insert into det_reporte_coordinador_departamental values('.$idReporte.', '.$row['idTutor'].', 
                    \''.$row['grupo'].'\', \''.$row['tutoriasGrupales'].'\', \''.$row['tutoriasIndividuales'].'\', \''.$row['estudiantesCanalizados'].'\', 
                    \''.$row['areaCanalizada'].'\')';
                $result = pg_query($query);
                if($result == false){
                    $terminado = false;
                }
            }
            if($terminado == true){
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
        pg_query('rollback');
        echo 'error1';
    }
}else{
    echo 'error';
}
?>
