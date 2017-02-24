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
if(filter_input(INPUT_POST, 'idPlan')){
    $idPlan = $_POST['idPlan'];
    $conn->conectar();
    pg_query('begin') or die('No se pudo iniciar la transacción');
    $queryIdProb = 'select id from det_planeacion_diagnostico_departamental where id_planeacion_diagnostico_departamental = '.$idPlan;
    $resultProb = pg_query($queryIdProb);
    $detEliminado = true;
    while($row = pg_fetch_array($resultProb)){
        $id = $row['id'];
        $queryBorrarDet = 'delete from det_planeacion_diagnostico_departamental_grupos where id_det_planeacion_diagnostico_departamental = '.$id;
        $resultDet = pg_query($queryBorrarDet);
        if($resultDet == false){
            $detEliminado = false;
        }
    } 
    if($detEliminado == true){
        $queryBorrarDet2 = 'delete from det_planeacion_diagnostico_departamental where id_planeacion_diagnostico_departamental = '.$idPlan;
        $resultDet2 = pg_query($queryBorrarDet2);
        if($resultDet2 == true){
            $queryBorrar = 'delete from planeacion_diagnostico_departamental where id = '.$idPlan;
            $resultBorrar = pg_query($queryBorrar);
            if($resultBorrar){
                pg_query('commit');
                echo 'ok';
            }else{
                pg_query('rollback');
                echo 'error4';
            }
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
