<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();

    $fecha = ($_POST['fecha']);
    $nombreCrdInst = ($_POST['nombre']);
    $matricula = ($_POST['matricula']);
    $tabla = ($_POST['tabla']);
    
    
    
    $res = $conn->guardarReporteCoordinadorInstitucional($fecha, $_SESSION["id_usuario"], $nombreCrdInst, $matricula, $tabla);

    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <table>
       <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR INSTITUCIONAL DE TUTORÍA</td>
        </tr>
        <tr>
            <td>Instituto Tecnológico de Parral</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR INSTITUCIONAL DE TUTORÍAS: </strong> <?php echo($_SESSION["nombre_usuario"]); ?>
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo ($fecha); ?>" disabled>
            </td>
        </tr>
        <tr>
            <td>Matrícula del Instituto Tecnológico Actual: <?php echo ($matricula); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO</td>
            <td>Cantidad de Tutores</td>
            <td>Tutoría Grupal</td>
            <td>Tutoría Individual</td>
            <td>Estudiantes Canalizados en el semestre</td>
            <td>Área canalizada</td>
            <td>Matrícula</td>
        </tr>
    </table>
    <table id="tablaDatos">

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
    <button onclick="imprimir()">imprimir</button>
    <button onclick="volver()">Volver</button>
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
