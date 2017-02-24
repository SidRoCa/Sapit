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
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $idPlan = $_POST['idPlan'];
    $queryBorrarProb = 'delete from det_plan_accion_tutorial_departamental_problematicas where id_plan_accion_tutorial_departamental = '.$idPlan;
    $resultBorrarProb = pg_query($queryBorrarProb);
    if($resultBorrarProb){
        $queryBorrarDet = 'delete from det_plan_accion_tutorial_departamental where id_plan_accion_tutorial_departamental = '.$idPlan;
        $resultBorrarDet = pg_query($queryBorrarDet);
        if($resultBorrarDet){
            $queryBorrarPlan = 'delete from plan_accion_tutorial_departamental where id = '.$idPlan;
            $resultBorrarPlan = pg_query($queryBorrarPlan);
            if($resultBorrarPlan){
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
        pg_query('rollback');
        echo 'error1';
    }
}else{
    echo 'error';
}
?>
