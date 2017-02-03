<div>
    <?php
    session_start();
    require "conexion.php";
    $conn = new Connection();
    
    $nombreDpto = ($_POST['nombreDpto']);
    $idDpto = ($_POST['idDpto']);
    $fecha = ($_POST['fecha']);
    $listaIdGrupos = ($_POST['listaIdGrupos']);
    $tabla = ($_POST['arreglo']);
    
    
    $res = $conn->guardarPlaneacionDiagnosticoDpt($idDpto, $fecha, $tabla, $listaIdGrupos);
    
    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    
    <p>PLANEACIÓN PARA DESARROLLAR EL DIAGNÓSTICO DEPARTAMENTAL</p>
    <p>Nombre del Departamento: <?php echo ($nombreDpto); ?>
        Fecha: <input type="date" id="fecha" value="<?php echo ($fecha); ?>"></p>

    <table id="tablaDatos">
        <tr id="headerTablaDatos">

            <th>Problema</th>
            <?php
            $res = $conn->getGruposDpto($idDpto);
            $listaIdGrupos = array();
            foreach ($res as $grupo) {
                echo ('<th>Grupo: ' . $grupo['nombre'] . ' </th>');
                array_push($listaIdGrupos, $grupo['id']);
            }
            ?>
            <th>Suma</th>
            <th>Orden</th>
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
        <button onclick="imprimir()">Imprimir</button>
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

