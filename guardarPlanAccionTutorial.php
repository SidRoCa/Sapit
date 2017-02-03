<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    $idGrupo = intval($_POST['idGrupo']);
    $fecha = ($_POST['fecha']);
    $tablaProb = ($_POST['arregloProb']);
    $tabla = ($_POST['arreglo']);
    $idCarrera = ($_POST['idCarrera']);
    $idDpto = ($_POST['idDpto']);
    $evaluacion = ($_POST['evaluacion']);
    $semestre = ($_POST['semestre']);

    $res = $conn->guardarPlanAccionTutorial($idGrupo, $tablaProb, $fecha, $tabla);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <p>PLAN DE ACCIÓN TUTORIAL</p>
    <table>
        <tr>
            <td>DATOS GENERALES</td>
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
                <strong>Fecha:</strong><?php echo ($fecha); ?>
            </td>
        </tr>
        <tr>
            <td>UNIDAD ACADÉMICA</td>
        </tr>
        <tr>
            <td><?php
                $res = $conn->getGrupoCarreraDpto($idGrupo);
                echo('<strong>Grupo:</strong>' . $res['nombre']);
                $idCarrera = $res['idcarr'];
                $idDpto = $res['iddpto'];
                ?>                 

                <br><strong>Carrera:</strong> 
                <?php
                $carrera = $conn->getCarrera($idCarrera);
                echo ($carrera);
                ?>
                <br><strong>Departamento:</strong> 
                <?php
                $departamento = $conn->getDpto($idDpto);
                echo ($departamento);
                ?>
            </td>
            <td>
                <strong>Número de alumnos:</strong>
                <?php
                $res = $conn->getNumeroAlumnos($idGrupo);
                echo($res);
                ?>
            </td>
            <td>
                <strong>Semestre:</strong> <?php echo($semestre); ?>

            </td>
        </tr>
        <tr>
            <th>PROBLEMÁTICAS IDENTIFICADAS</th> 
        </tr>
        <tr id="headerTblProb">
            <th>Problemática</th>
            <th>Valor asignado</th>
            <th>Objetivos</th>
            <th>Acciones</th>
        </tr>
        <?php
        $a = explode("|", $tablaProb);
        foreach ($a as $s) {
            $b = explode("^", $s);
            echo ('<tr>');
            foreach ($b as $d) {
                echo('<td>' . $d . '</td>');
            }
            echo ('</tr>');
        }
        ?>
        
        
        <tr>CALENDARIZACIÓN</tr>
        <?php
            if ($semestre = 'ene-jun') {
                ?>
                <th>Actividades</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>    
                <?php
            } else {
                ?>
                <th>Actividades</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <?php
            }
            ?>
        <?php
        $a = explode("|", $tabla);
        foreach ($a as $s) {
            $b = explode("^", $s);
            echo ('<tr>');
            foreach ($b as $d) {
                echo('<td>' . $d . '</td>');
            }
            echo ('</tr>');
        }
        ?>
    </table>
    <p>Evaluación: <?php echo ($evaluacion); ?></p>
    <div>
        <button onclick="imprimir()">imprimir</button>
        <button onclick="volver()">Volver</button>
    </div>
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

