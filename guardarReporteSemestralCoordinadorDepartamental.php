<div>
        <?php
    require "conexion.php";
    session_start();
    $conn = new Connection();
    
    $fecha = ($_POST['fecha']);
    $nombreCrdTutoDpt = ($_POST['nombreCrdTutoDpto']);
    $programaEducativo = ($_POST['programaEducativo']);
    $departamentoAcademico = ($_POST['departamentoAcademico']);
    $idPeriodo = ($_POST['idPeriodo']);
    $tabla = ($_POST['tabla']);
    $observaciones = ($_POST['observaciones']);

    $res = $conn->guardarReporteCoordinadorDepartamental($fecha, $_SESSION["id_usuario"], $programaEducativo, $departamentoAcademico, $idPeriodo, $tabla, $observaciones);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <table>
        <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR DEPARTAMENTAL DE TUTORÍAS</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR DE TUTORÍAS DEL DEPARTAMENTO ACADÉMICO:</strong> <?php echo($nombreCrdTutoDpt);?> 
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo($fecha) ?>" disabled>
            </td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO: <?php echo($programaEducativo); ?></td>
            <td>DEPARTAMENTO ACADEMICO: <?php echo($departamentoAcademico); ?> </td>
            <td>SEMESTRE: <?php echo($idPeriodo); ?> (idPeriodo)</td>
        </tr>
        <tr>
            <td>LISTA DE TUTORES</td>
            <td>GRUPO</td>
            <td>TUTORÍA GRUPAL</td>
            <td>TUTORÍA INDIVIDUAL</td>
            <td>ESTUDIANTES CANALIZADOS EN EL SEMESTRE</td>
            <td>ÁREA CANALIZADA</td>
        </tr>
    </table>
    <table id="tablaDatos">
        
        <?php
        $a = explode("|", $tabla);
        $cnt = 1;
        foreach ($a as $s) {
            $b = explode("^", $s);
            echo ('<tr>');
            $auux = true;

            foreach ($b as $d) {
                if ($auux) {
                    $res = $conn->getTutor($d);
                    echo('<td>' . $cnt . '. ' . $res['nombres']. ' ' . $res['apPaterno']. ' ' . $res['apMaterno']. ' ' . '</td>');
                    $auux = false;
                    $cnt++;
                } else {
                    echo('<td>' . $d . '</td>');
                }
            }
            echo ('</tr>');
        }
        ?>

    </table>
    <table>
        <tr>
            <td>
                <strong>Instructivo de llenado:</strong>
                Anote los datos correspondientes en los apartados del encabezado <br>
                En el apartado de Observaciones anotar: <br>
                •	Anote las 10 actividades adicionales más importantes realizadas en el semestre <br>
                •	Anotar las acciones de mayor impacto para alcanzar la competencia de la asignatura <br>
                Este reporte deberá ser llenado por el Coordinador de Tutoría del Departamento Académico <br>
                Deberá ser entregada al Jefe de Departamento Académico con copia para el Coordinador Institucional de Tutoría 

            </td>
        </tr>
        <tr>
            <td>Observaciones: <?php echo($observaciones) ?></td>
        </tr>
    </table>
</div>
<script>
    function volver() {
        $("#diagnosticoGrupo").show();
        $("#mainContenido").hide();
    }
    function imprimir() {
        alert('Not supported yet');
    }
</script>
