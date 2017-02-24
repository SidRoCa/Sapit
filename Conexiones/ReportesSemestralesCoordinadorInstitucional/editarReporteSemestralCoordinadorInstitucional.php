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
if(isset($_POST['det']) and filter_input(INPUT_POST, 'idReporte') and filter_input(INPUT_POST, 'matriculaInstituto')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $det = $_POST['det'];
    $idReporte = $_POST['idReporte'];
    $matriculaInstituto = $_POST['matriculaInstituto'];
    $queryAct = 'update reporte_coordinador_institucional set matricula_instituto_tecnologico = \''.$matriculaInstituto.'\' where id = '.$idReporte;
    $resultAct = pg_query($queryAct);
    if($resultAct){
        $queryBorrarDet = 'delete from det_reporte_coordinador_institucional where id_reporte_coordinador_institucional = '.$idReporte;
        $resultBorrarDet = pg_query($queryBorrarDet);
        if($resultBorrarDet){
            $terminado = true;
            foreach ($det as $row) {
                $query = 'insert into det_reporte_coordinador_institucional values('.$idReporte.', \''.$row['programaEducativo'].'\', 
                    \''.$row['cantidadTutores'].'\', \''.$row['tutoriaGrupal'].'\', \''.$row['tutoriaIndividual'].'\', \''.$row['estudiantesCanalizados'].'\', 
                    \''.$row['areaCanalizada'].'\', \''.$row['matricula'].'\')';
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
