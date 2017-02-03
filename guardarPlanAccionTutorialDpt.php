<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();


    $nombreCrdDpt = ($_POST['nombreCrdDpt']);
    $fecha = ($_POST['fecha']);
    $tablaProb = ($_POST['arregloProb']);
    $tabla = ($_POST['arreglo']);
    $evaluacion = ($_POST['evaluacion']);
    $semestre = ($_POST['semestre']);

    $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);

    $res = $conn->guardarPlanAccionTutorialDpt($nombreCrdDpt, $idDepartamento, $fecha, $tablaProb, $evaluacion, $tabla);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <p>PLAN DE ACCIÓN TUTORIAL DEPARTAMENTAL</p>
    <p>Nombre del Coordinador Departamental:  <?php echo($nombreCrdDpt); ?></p>
    <table>
        <tr>
            <td>DATOS GENERALES</td>
        </tr>
        <tr>
            <td>
                <strong>Nombre del Departamento: </strong> <?php
                $dpto = $conn->getDpto($idDepartamento);
                echo ($dpto);
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
            <td>                

                <br><strong>Carreras:</strong>
                <?php
                $res = $conn->getCarrerasDpto($idDepartamento);
                foreach ($res as $carrera) {
                    echo ($carrera['nombre'] . '<br>');
                }
                ?>
            </td>    
            <td>
                <br><strong>Grupos:</strong> 
                <?php
                $listaIdGrupos = array();
                $res = $conn->getGruposDpto($idDepartamento);
                foreach ($res as $grupo) {
                    array_push($listaIdGrupos, $grupo['id']);
                    echo ($grupo['nombre'] . '<br>');
                }
                ?>
            </td>
            <td>
                <strong>Semestres:</strong>
                <?php
                $res = $conn->getSemestresDpto($idDepartamento);
                foreach ($res as $semestres) {
                    echo ($semestres['ident'] . '<br>');
                }
                ?>
            </td>
        </tr>
        <tr>
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
        <tr id="headerTablaDatos">
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

    <p>Evaluación: <?php echo ($evaluacion); ?></p>
    <div>
        <button onclick="imprimir()">imprimir</button>
        <button onclick="volver()">Volver</button>
    </div>
</div>
<script>
    function volver() {
        $("#mainContenido").hide();
    }
    function imprimir() {
        alert('Not supported yet');
    }
</script>

