<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    
    $idTutor = intval($_POST['idTutor']);
    $fecha = ($_POST['fecha']);
    $idGrupo = intval($_POST['idGrupo']);
    $tabla = ($_POST['tabla']);
    $observaciones = ($_POST['observaciones']);


    $res = $conn->guardarReporteTutor($idTutor, $idGrupo, $fecha, $tabla, $observaciones);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <table>
        <tr>
            <td>REPORTE SEMESTRAL DEL TUTOR</td>
        </tr>
        <tr>
            <td>
                <strong>Nombre del(los) tutores:</strong> <?php
                $res = $conn->getTutoresGrupo($idGrupo);
                foreach ($res as $tutor) {
                    echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
                }
                ?>
            </td>
            <td>
                <strong>Fecha: </strong><?php echo($fecha); ?>
            </td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO: PROGRAMA INSTITUCIONAL DE TUTORÍAS</td>
            <td>
                <?php
                $res = $conn->getGrupo($idGrupo);
                echo('<strong>Grupo:</strong>' . $res);
                ?>                 
            </td>


        </tr>

    </table>
    <table id="tablaDatos">
        <tr id="headerTablaDatos">
            <td>LISTA DE ESTUDIANTES</td>
            <td>TUTORÍA GRUPAL</td>
            <td>TUTORÍA INDIVIDUAL</td>
            <td>ESTUDIANTES CANALIZADOS EN EL SEMESTRE</td>
            <td>AREA CANALIZADA</td>
        </tr>
        <?php
        $a = explode("|", $tabla);
        $cnt = 1;
        foreach ($a as $s) {
            $b = explode("^", $s);
            echo ('<tr>');
            $auux = true;

            foreach ($b as $d) {
                if ($auux) {
                    $res = $conn->getAlumno($d);
                    echo('<td>' . $cnt . '. ' . $res . '</td>');
                    $auux = false;
                    $cnt++;
                } else {
                    echo('<td>' . $d . '</td>');
                }
            }
            echo ('<tr>');
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
