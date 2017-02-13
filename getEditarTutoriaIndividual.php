<div>
    <?php
    session_start();
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    $idTutoriaIndividual = $_POST['idTutoriaIndividual'];
    $idTutor = $_POST['idTutor'];
    $tutoriaIndividual = $conn->getTutoriaIndividualPorId($idTutoriaIndividual);
    ?>

    <h2>Editar tutoría individual</h2>
    <p>TUTORÍA INDIVIDUAL</p> 
    <form id="formulario">
        <p><strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo (substr($tutoriaIndividual['fecha'], 0, 10)); ?>"></p>
        <p><strong>Nombre del(los) tutores:</strong>  
        <p id="tutores">
            <?php
            $tutor = $conn->getTutorPorId($tutoriaIndividual['idTutor']);
            echo ($tutor['nombre'] . ' ' . $tutor['apPaterno'] . ' ' . $tutor['apMaterno']);
            echo('</p>');
            ?>
        <h3>INFORME DE UNA ENTREVISTA TUTORIAL</h3>  

        <p><strong>Nombre del Alumno: </strong> 
            <?php
            $res = $conn->getAlumnosGrupo($tutoriaIndividual['idGrupo']);
            echo ('<select id="selAlumno">');
            echo ('<option value = "-1" > --Seleccionar alumno--</option>');
            foreach ($res as $alumno) {
                if ($alumno['id'] == $tutoriaIndividual['idAlumno']) {
                    echo ('<option value = "' . $alumno['id'] . '" selected>' . $alumno['nombres'] . " " . $alumno['ap_paterno'] . " " . $alumno['ap_materno'] . '</option>');
                } else {
                    echo ('<option value = "' . $alumno['id'] . '">' . $alumno['nombres'] . " " . $alumno['ap_paterno'] . " " . $alumno['ap_materno'] . '</option>');
                }
            }
            echo ('</select>');
            ?>
        </p>
        <p> <strong>Entrevista solicitada por: </strong> <input id="solicPor" type="text" value="<?php echo($tutoriaIndividual['solicitadaPor']) ?>" ></p>
        <ol>
            <li><strong>Motivos: </strong> <input id="motivos" type="text" value="<?php echo($tutoriaIndividual['motivos']) ?>" ></li>
            <li><strong>Aspectos tratados: </strong> <input id="aspectos" type="text" value="<?php echo($tutoriaIndividual['aspectosTratados']) ?>"></li>
            <li><strong>Conclusiones y compromisos establecidos: </strong> <input id="conclusiones" type="text" value="<?php echo($tutoriaIndividual['conclusiones']) ?>" ></li>
            <li><strong>Observaciones: </strong> <input id="observaciones" type="text" value="<?php echo($tutoriaIndividual['observaciones']) ?>" ></li>
            <li><strong>Fecha próxima visita:</strong><input type="date" id="proxFecha" value="<?php echo(substr($tutoriaIndividual['fechaProxVisita'], 0, 10)) ?>"></li>
        </ol>
        <button onclick="guardar()" id="btnGuardar">
            Aceptar
        </button>
        <button onclick="cancelar()" id="btnCancelar">
            Cancelar
        </button>
        <p id = "txtEstado">

        </p>
    </form>
    <script>

        $("#formulario").submit(function (e) {
            return false;
        });

        function cancelar() {
            irALista();
        }

        function guardar() {
            //nombres, apPat, apMat, idDep, nip, identificador
            var idTutoriaIndividual = <?php echo($idTutoriaIndividual); ?>;
            var idGrupo = <?php echo($tutoriaIndividual['idGrupo']); ?>;
            var fecha = $("#fecha").val();
            var solicPor = $("#solicPor").val();
            var motivos = $("#motivos").val();
            var aspectos = $("#aspectos").val();
            var conclusiones = $("#conclusiones").val();
            var observaciones = $("#observaciones").val();
            var proxFecha = $("#proxFecha").val();
            var idTutor = <?php echo($idTutor); ?>;
            
            if (!fecha) {
                window.alert("Todos los campos con * son obligatorios");
            } else {
                var alumnoSeleccionado = $("#selAlumno option:selected");
                var idAlumno = parseInt(alumnoSeleccionado.val());
                if (idAlumno > 0) {

                    var txtEstado = $("#txtEstado");
                    var btnGuardar = $("#btnGuardar");
                    var btnCancelar = $("#btnCancelar");
                    txtEstado.html("Cargando...");
                    txtEstado.show();
                    btnCancelar.hide();
                    btnGuardar.hide();

                    $.ajax({
                        method: "POST",
                        url: "Conexiones/TutoriasIndividuales/editarTutoriaIndividual.php",
                        data: {idTutoriaIndividual: idTutoriaIndividual, idGrupo: idGrupo, fecha: fecha, solicPor: solicPor, motivos: motivos, aspectos: aspectos,
                            conclusiones: conclusiones, observaciones: observaciones, proxFecha: proxFecha,
                            idAlumno: idAlumno, idTutor: idTutor}
                    }).done(function (msg) {
                        if (msg.localeCompare("ok") == 0) {
                            irALista();
                        } else {
                            alert(msg);
                            txtEstado.html("Ocurrió un error, inténtalo de nuevo");
                            btnCancelar.show();
                            btnGuardar.show();
                        }
                    }).fail(function (jqXHR, textStatus) {
                        if (textStatus === 'timeout') {
                            txtEstado.html("El servidor no responde, inténtalo de nuevo más tarde");
                        } else {
                            txtEstado.html("Ocurrió un error al editar la tutoría individual");
                        }
                        btnGuardar.show();
                        btnCancelar.show();
                    });
                } else {
                    window.alert("Debes seleccionar un alumno");
                }
            }
        }

        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaTutoriasIndividualesEditar.php",
                data: {idTutor: <?php echo($idTutor); ?>}
            }).done(function (msg) {
                $("#mainContenido").hide();
                $("#actualizarDatosTutor").hide();
                $("#registroAsistenciaIndividual").hide();
                $("#registroAsistenciaGrupal").hide();
                $("#diagnosticoGrupo").hide();
                $("#planAccionTutorial").hide();
                $("#reporteSemestral").hide();
                $("#actaResultadosObtenidos").hide();
                $("#cartaCompromiso").hide();
                $("#fichaAlumnosTutorados").hide();
                $("#mainContenido").html(msg);
                $("#mainContenido").show();
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                } else {
                    $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                }
            });
        }

    </script>
</div>
