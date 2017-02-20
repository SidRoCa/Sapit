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
if(isset($_POST['problematicas']) and isset($_POST['actividades']) and filter_input(INPUT_POST, 'idPlan')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $problematicas = $_POST['problematicas'];
    $actividades = $_POST['actividades'];
    $idPlan = $_POST['idPlan'];
    $queryBorrarProb = 'delete from det_plan_accion_tutorial_problematicas where id_plan_accion_tutorial = '.$idPlan;
    $problematicasBorradas = pg_query($queryBorrarProb);
    if($problematicasBorradas){
        $problematicasAgregadas = true;
        foreach ($problematicas as $problematica) {
            $queryAgregarProb = 'insert into det_plan_accion_tutorial_problematicas values('.$idPlan.', \''.$problematica['problematica'].'\', \''.$problematica['valor'].'\', \''.$problematica['objetivos'].'\', \''.$problematica['acciones'].'\')';
            $resultAgregarProb = pg_query($queryAgregarProb);
            if($resultAgregarProb == false){
                $problematicasAgregadas = false;
            }

            if($problematicasAgregadas == true){
                $queryBorrarAct = 'delete from det_plan_accion_tutorial where id_plan_accion_tutorial = '.$idPlan;
                $actividadesBorradas = pg_query($queryBorrarAct);
                if($actividadesBorradas){
                    $actividadesAgregadas = true;
                    foreach ($actividades as $actividad) {
                        $queryAgregarAct = 'insert into det_plan_accion_tutorial values('.$idPlan.', \''.$actividad['accion'].'\', \''.$actividad['mes1'].'\', \''.$actividad['mes2'].'\', \''.$actividad['mes3'].'\', \''.$actividad['mes4'].'\', \''.$actividad['mes5'].'\', \''.$actividad['mes6'].'\')';
                        $resultAgregarAct = pg_query($queryAgregarAct);
                        if($resultAgregarAct == false){
                            $actividadesAgregadas = false;
                        }
                    }
                    if($actividadesAgregadas == true){
                        pg_query('commit') or die('No se pudo completar la operación');
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
                pg_query('rollback');
                echo 'error';
            }
        }
    }else{
        pg_query('rollback');
        echo 'error';
    }
}else{
    echo 'error';
}
?>
