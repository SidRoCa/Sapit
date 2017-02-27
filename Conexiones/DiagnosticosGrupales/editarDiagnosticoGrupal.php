<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario'] !== "crdinst") {
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
    $queryEliminar = 'delete from det_diagnostico_grupo where id_diagnostico_grupo = '.$idDiagnostico;
    $eliminado = pg_query($queryEliminar);
    if($eliminado){
        $guardarTodo = true;
        foreach ($det as $row) {
            $queryDetalle = 'insert into det_diagnostico_grupo values('.$idDiagnostico.',\''.$row['fase'].'\', \''.$row['areaEvaluacion'].'\', \''.$row['instrumento'].'\', \''.$row['recAnalisis'].'\', \''.$row['hallazgos'].'\')';
            $detGuardado = pg_query($queryDetalle);
            if($detGuardado == false){
                $guardarTodo = false;
            }
        }
        if($guardarTodo == true){
            pg_query('commit') or die("Ocurrió un error al guardar los datos en el sistema");
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
