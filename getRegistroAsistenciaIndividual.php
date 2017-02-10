<div id="mainContenido">
    <?php
    session_start();
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    ?>

    <script>var d = new Date()</script>
    <h2>Formato para el registro de tutoría individual</h2>
    <p>TUTORÍA INDIVIDUAL</p> 
    <form>
        <p><strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>"></p>
        <p><strong>Nombre del(los) tutores:</strong>  
        <p id="tutores">
            <?php
            $idGrupo = intval($_POST['idGrupo']);
            echo ($_SESSION['nombre_usuario']);
            echo('</p>');
            ?>
        <h3>INFORME DE UNA ENTREVISTA TUTORIAL</h3>  

        <p><strong>Nombre del Alumno: </strong> 
            <?php
            $res = $conn->getAlumnosGrupo($idGrupo);
            echo ('<select id="selAlumno">');
            echo ('<option value = "-1" > --Seleccionar alumno--</option>');
            foreach ($res as $alumno) {
                echo ('<option value = "' . $alumno['id'] . '">' . $alumno['nombres'] . " " . $alumno['ap_paterno'] . " " . $alumno['ap_materno'] . '</option>');
            }
            echo ('</select>');
            ?>
        </p>
        <p> <strong>Entrevista solicitada por: </strong> <input id="solicPor" type="text"></p>
        <ol>
            <li><strong>Motivos: </strong> <input id="motivos" type="text"></li>
            <li><strong>Aspectos tratados: </strong> <input id="aspectos" type="text"></li>
            <li><strong>Conclusiones y compromisos establecidos: </strong> <input id="conclusiones" type="text"></li>
            <li><strong>Observaciones: </strong> <input id="observaciones" type="text"></li>
            <li><strong>Fecha próxima visita:</strong><input type="date" id="proxFecha" ></li>
        </ol>
        <input type="button" value="Guardar" onclick="guardar(<?php echo($idGrupo) ?>)">
        <input type="button" value="Cancelar" onclick="cancelar()">
    </form>


</div>
<script>
    function cancelar() {
        $("#registroAsistenciaIndividual").show();
        $("#mainContenido").hide();

    }
    function guardar(idGrupo) {
        if ($("#fecha").val() != "") {
            if ($("#selAlumno").val() != -1) {

                $.ajax({
                    method: "POST",
                    url: "guardarFormatoTutoriaIndividual.php",
                    data: {idGrupo: idGrupo, fecha: $("#fecha").val() , solicPor: $("#solicPor").val(), motivos: $("#motivos").val(), aspectos: $("#aspectos").val(), conclusiones: $("#conclusiones").val(), observaciones: $("#observaciones").val(), proxFecha:$("#proxFecha").val(), idAlumno: $("#selAlumno").val(), idTutor: <?php echo($_SESSION['id_usuario']) ?> }
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