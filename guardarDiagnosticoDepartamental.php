<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    $nombreCrdDpt = ($_POST['nombreCrdDpt']);
    $idDpto = intval($_POST['idDepartamento']);
    $fecha = ($_POST['fecha']);
    $tabla = ($_POST['arreglo']);

    $res = $conn->guardarDiagnosticoDepartamental($nombreCrdDpt, $idDpto, $fecha, $tabla);
    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <p>DIAGNÓSTICO DEPARTAMENTAL</p>
    <table>
        <tr>
            <th> DATOS GENERALES </th>
        </tr>
        <tr>
            <td>
                <strong>Nombre del coordinador departamental: </strong> <?php echo ($nombreCrdDpt); ?>
            </td>
            <td>
                <strong>Fecha:</strong><?php echo($fecha) ?>
            </td>
        </tr>
        <tr>
        
        <tr>
            <th> UNIDAD ACADÉMICA </th>
        </tr>
        <tr>
            <td>
                <br><strong>Departamento: </strong> <?php
                $dpto = $conn->getDpto($idDpto);
                echo ($dpto);
                ?>
            </td> 
             <td>                
                <br><strong>Carreras: </strong>
                <input id="carreras" type="text" value="<?php
                $res = $conn->getCarrerasDpto($idDpto);
                foreach ($res as $carrera) {
                    echo ($carrera['nombre'] . ' ');
                }
                ?>">
            </td>       

            <td>
                <strong>Semestres: </strong>
                <input id="semestres" type="text" value="<?php
                $res = $conn->getSemestresDpto($idDpto);
                foreach ($res as $semestres) {
                    echo ($semestres['ident'] . ' ');
                }
                ?>">
            </td>
        </tr>

    </table>
    <table id="tablaDatos">
        <tr id="headerTablaDatos"><th>Fases de la tutoría</th>
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
        //$("#diagnosticoGrupo").show();
        $("#mainContenido").hide();
    }
    function imprimir() {
        alert('Not supported yet');
    }
</script>
