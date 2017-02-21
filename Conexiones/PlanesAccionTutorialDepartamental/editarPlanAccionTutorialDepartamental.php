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
if(isset($_POST['problematicas']) and isset($_POST['actividades']) and filter_input(INPUT_POST, 'idPlan')){
    $conn->conectar();
    pg_query('begin') or die("No se pudo comenzar la transacción");
    $problematicas = $_POST['problematicas'];
    $actividades = $_POST['actividades'];
    $idPlan = $_POST['idPlan'];
    $evaluacion = $_POST['evaluacion'];
    $queryPlan = 'update plan_accion_tutorial_departamental set evaluacion = \''.$evaluacion.'\' where id = '.$idPlan;
    $resultPlan = pg_query($queryPlan);
    if($resultPlan){
        $queryBorrarProb = 'delete from det_plan_accion_tutorial_departamental_problematicas where id_plan_accion_tutorial_departamental = '.$idPlan;
        $resultBorraProb = pg_query($queryBorrarProb);
        if($resultBorraProb){
            $problematicasAgregadas = true;
            foreach ($problematicas as $problematica) {
                $queryProb = 'insert into det_plan_accion_tutorial_departamental_problematicas values('.$idPlan.', \''.$problematica['problematica'].'\', \''.$problematica['valor'].'\', \''.$problematica['objetivos'].'\', \''.$problematica['acciones'].'\')';
                $resultProb = pg_query($queryProb);
                if($resultProb == false){
                    $problematicasAgregadas = false;
                }
            }
            if($problematicasAgregadas==true){
                $queryBorrarAct = 'delete from det_plan_accion_tutorial_departamental where id_plan_accion_tutorial_departamental='.$idPlan;
                $resultBorrarAct = pg_query($queryBorrarAct);
                if($resultBorrarAct == true){
                    $actividadesAgregadas = true;
                    foreach ($actividades as $actividad) {
                        $queryAct = 'insert into det_plan_accion_tutorial_departamental values('.$idPlan.', \''.$actividad['actividad'].'\', \''.$actividad['mes1'].'\', \''.$actividad['mes2'].'\', \''.$actividad['mes3'].'\', \''.$actividad['mes4'].'\', \''.$actividad['mes5'].'\', \''.$actividad['mes6'].'\')';
                        $resultAct = pg_query($queryAct);
                        if($resultAct == false){
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
