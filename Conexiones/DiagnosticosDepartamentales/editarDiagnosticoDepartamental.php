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
if(isset($_POST['det']) and filter_input(INPUT_POST, 'idDiagnostico')){
    $conn->conectar();
    $det = $_POST['det'];
    $idDiagnostico = $_POST['idDiagnostico'];
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $queryElminar = 'delete from det_diagnostico_departamental where id_diagnostico_departamental = '.$idDiagnostico;
    $resultEliminar = pg_query($queryElminar);
    if($resultEliminar){
        $detAlmacenado = true;
        foreach ($det as $row) {
            $queryDet = 'insert into det_diagnostico_departamental values('.$idDiagnostico.', \''. $row['fase'].'\', \''.$row['areaEvaluacion'].'\', 
                \''.$row['instrumento'].'\', \''.$row['recanalisis'].'\', \''.$row['hallazgos'].'\')';
            $resultDet = pg_query($queryDet);
            if($resultDet == false){
                $detAlmacenado = false;
            }
        }
        if($detAlmacenado == true){
            pg_query('commit') or die('No se completó la operación');
            echo 'ok';
        }else{
            pg_query('rollback');
            echo 'error';
        }
    }else{
        pg_query('rollback');
        echo 'error';
    }
}else{
    echo 'error';
}
?>
