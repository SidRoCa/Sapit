<div id="mainContenido">
    <?php
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    ?>

    <script>var d = new Date()</script>
    <h2>Control de asistencia a las sesiones de tutorías</h2>
    <p>LISTA DE ASISTENCIA A LAS REUNIONES DE TUTORÍAS</p> 
    <form>
        <p><strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" ></p>
        <p><strong>Nombre del(los) tutores:</strong>  

            <?php
            $idGrupo = intval($_POST['idGrupo']);
            $res = $conn->getTutoresGrupo($idGrupo);
            foreach ($res as $tutor) {
                echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
            }
            echo('</p>');
            $res = $conn->getLugarTutoria($idGrupo);
            echo ('<p> <strong>Lugar de tutorías: </strong> <input id="lugarTuto" type="text" value = "' . $res . '"></p>');
            echo ('<p> <strong>Tema: </strong> <input id="temaTuto" type="text"></p>');

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
            <input type="button"  value="Guardar" onclick="guardar(<?php echo($idGrupo) ?>)">
            <input type="button"  value="Cancelar" onclick="cancelar()">
    </form>
</div>
<script>
    function cancelar() {
        $("#registroAsistenciaGrupal").show();
        $("#mainContenido").hide();
    }
    function guardar(idGrupo) {
        if ($("#fecha").val() != "") {
            if ($("#selAlumno").val() != -1) {
                
                 $.ajax({
                    method: "POST",
                    url: "guardarFormatoTutoriaGrupal.php",
                    data: {idGrupo: idGrupo, fecha: $("#fecha").val() , lugar: $("#lugarTuto").val(), tema: $("#temaTuto").val()}
                }).done(function (msg) {
                    $("#fichaAlumnosTutorados").hide();
                    $("#registroAsistenciaGrupal").hide();
                    $("#registroAsistenciaIndividual").hide();
                    $("#diagnosticoGrupo").hide();
                    $("#planAccionTutorial").hide();
                    $("#mainContenido").show();
                    $("#mainContenido").html(msg);

                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                    } else {
                        $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                    }
                });
            } else {
                alert('Debe seleccionar un alumno');
            }
        } else {
            alert('Debe seleccionar una fecha');
        }
    }
</script>