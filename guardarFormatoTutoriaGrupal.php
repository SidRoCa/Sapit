<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    $idGrupo = intval($_POST['idGrupo']);
    $fecha = ($_POST['fecha']);
    $lugar = ($_POST['lugar']);
    $tema = ($_POST['tema']);

    
    
    $res = $conn->guardarTutoriasGrupal($idGrupo, $fecha, $tema, $lugar);
    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>
    <h2>Control de asistencia a las sesiones de tutorías</h2>
    <p>LISTA DE ASISTENCIA A LAS REUNIONES DE TUTORÍAS</p> 

    <p><strong>Fecha:</strong><?php echo($fecha); ?></p>
    <p><strong>Nombre del(los) tutores:</strong>  

        <?php
        $res = $conn->getTutoresGrupo($idGrupo);
        foreach ($res as $tutor) {
            echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
        }
        echo('</p>');
        ?>
    <p> <strong>Lugar de tutorías: </strong> <?php echo($lugar); ?> </p>
    <p> <strong>Tema: </strong> <?php echo($tema); ?> </p>

    <?php
     echo "<table>
            <tr>
            <th>Número de control</th>
            <th>Nombre del alumno</th>
            <th>Firma del alumno</th>
            </tr>";
            $res = $conn->getAlumnosGrupo($idGrupo);
            foreach ($res as $alumno) {
                echo ('<tr>');
                echo ('<td>' . $alumno['no_control'] . '</td>');
                echo ('<td>' . $alumno['nombres'] . ' ' . $alumno['ap_paterno'] . ' ' . $alumno['ap_materno'] . '</td>');
                echo ('<td></td>');
                echo ('<tr>');
            }
            echo "</table>";
    ?>
    <button onclick="volver()">Volver</button>
    <button onclick="imprimir()">Imprimir</button>

</div>
<script>
    function volver() {
        $("#mainContenido").hide();
        $("#registroAsistenciaGrupal").show();
    }
    function imprimir() {
        alert('not supported yet');
    }
</script>