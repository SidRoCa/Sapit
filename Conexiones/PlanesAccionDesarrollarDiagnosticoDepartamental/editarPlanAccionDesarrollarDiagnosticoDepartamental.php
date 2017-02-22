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
if(isset($_POST['problematicas']) and isset($_POST['problematicasAnteriores']) and filter_input(INPUT_POST, 'idPlan')){
    $problematicas = $_POST['problematicas'];
    $problematicasAnteriores = $_POST['problematicasAnteriores'];
    $idPlan = $_POST['idPlan'];
    $conn->conectar();
    pg_query('begin') or die('No se pudo iniciar la transacción');
    $borrar = true;
    foreach ($problematicasAnteriores as $prob) {
        $id = $prob['id'];
        $queryBorrarGrupos = 'delete from det_planeacion_diagnostico_departamental_grupos where id_det_planeacion_diagnostico_departamental = '.$id;
        $resultBorrarGrupos = pg_query($queryBorrarGrupos);
        if($resultBorrarGrupos){
            $queryBorrarProblematica = 'delete from det_planeacion_diagnostico_departamental where id = '.$id;
            $resultBorrarProblematica = pg_query($queryBorrarProblematica);
            if($resultBorrarProblematica==false){
                $borrar = false;
            }
        }else{
            $borrar = false;
        }
    }
    if($borrar == true){
        $terminado = true;
        foreach ($problematicas as $problematica) {
            $problema = $problematica['problema'];
            $queryAgregarProblematica = 'insert into det_planeacion_diagnostico_departamental values(default,'.$idPlan.', \''.$problema.'\') returning id';
            $resultAgregarProblematica = pg_query($queryAgregarProblematica);
            $idInsertado = 0;
            $row = pg_fetch_array($resultAgregarProblematica);
            $idInsertado = $row['id'];
            if($idInsertado>0){
                $gruposAux = $problematica[0];
                $gruposGuardados = true;
                foreach ($gruposAux as $grupoAux) {
                    $queryAgregarGrupo = 'insert into det_planeacion_diagnostico_departamental_grupos values('.$idInsertado.', 
                        '.$grupoAux['idGrupo'].', \''.$grupoAux['valor'].'\')';
                    $resultAgregarGrupo = pg_query($queryAgregarGrupo);
                    if($resultAgregarGrupo == false){
                        $gruposGuardados = false;
                    }
                }
                if($gruposGuardados == false){
                    $terminado = false;   
                }
            }else{
                $terminado = false;
            }
        }
        if($terminado == true){
            pg_query('commit');
            echo 'ok';
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
