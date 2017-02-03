<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    $idGrupo = intval($_POST['idGrupo']);
    $fecha = ($_POST['fecha']);
    $idCarrera = intval($_POST['idCarrera']);
    $idDpto = intval($_POST['idDpto']);
    $semestre = ($_POST['semestre']);
    $tabla = ($_POST['arreglo']);

    $res = $conn->guardarDiagnosticoGrupo($idGrupo, $fecha, $semestre, $tabla);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <p>DIAGNÓSTICO DEL GRUPO</p>
    <table>
        <tr>
            <th> DATOS GENERALES </th>
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
                <strong>Fecha:</strong> <?php echo($fecha) ?>
            </td>
        </tr>
        <tr>
            <th> UNIDAD ACADÉMICA </th>
        </tr>
        <tr>
            <td>               
                <br><strong>Carrera: </strong> 

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
                $numAl = $conn->getNumeroAlumnos($idGrupo);
                echo($numAl);
                ?>
            </td>
            <td>
                <strong>Semestre:</strong> 
                <?php echo($semestre) ?>
            </td>
        </tr>

    </table>
    <table id="tablaDatos">
        <tr id="headerTablaDatos">
            <th>Fases de la tutoría</th>
            <th>Áreas de evaluación</th>
            <th>Instrumento</th>
            <th>Recolección y análisis de la información</th>
            <th>Hallazgos</th>
        </tr>
        <?php
        $a = explode("|", $tabla);
        foreach ($a as $s) {
            $b = explode("^", $s);
            echo ('<tr>');
            foreach ($b as $d) {
                echo('<td>' . $d . '</td>');
            }
            echo ('<tr>');
        }
        ?>
    </table>
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
