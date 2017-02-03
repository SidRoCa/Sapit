<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    ?>

    <h2>REPORTE DE DATOS DE LOS DOCENTES TUTORES<br>MAESTROS TUTORES:</h2>
    <table id="tablaDatos">
        <tr>
            <th>NOMBRE</th>
            <th>CORREO ELECTRÓNICO</th>
            <th>DEPARTAMENTO AL QUE ESTÁ ADSCRITO</th>
            <th>TELÉFONO</th>
            <th>LUGAR DE TUTORÍAS</th>
            <th>HORARIO DE TUTORÍAS</th>
            <th>GRUPO TUTORADO</th>
            <th>FIRMA</th>
        </tr>
        <?php
        $tutores = $conn->getTutores();
        foreach ($tutores as $tutor) {
            echo('<tr>');
            echo('<td>' . $tutor['nombres'] . ' ' . $tutor['apPaterno'] . ' ' . $tutor['apMaterno'] . '</td>');
            echo('<td>' . $tutor['correo'] . '</td>');
            echo('<td>' . $tutor['nombreDpto'] . '</td>');
            echo('<td>' . $tutor['telefono'] . '</td>');
            echo('<td>' . $tutor['lugarTutoria'] . '</td>');
            echo('<td>' . $tutor['horario'] . '</td>');
            echo('<td>' . $tutor['nombreGrupo'] . '</td>');
            echo('</tr>');
        }
        ?>

    </table>
    <button onclick="cancelar()">Volver</button>
</div>

<script>

    function cancelar() {
        $("#mainContenido").hide();
    }
</script>
