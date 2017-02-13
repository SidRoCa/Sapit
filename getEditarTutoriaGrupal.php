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
    $idTutoriaGrupal = $_POST['idTutoriaGrupal'];
    $idTutor = $_POST['idTutor'];
    $tutoriaGrupal = $conn->getTutoriaGrupalPorId($idTutoriaGrupal);
    ?>

    <h2>Control de asistencia a las sesiones de tutorías</h2>
    <p>LISTA DE ASISTENCIA A LAS REUNIONES DE TUTORÍAS</p> 
    <form id="formulario">
        <p><strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo (substr($tutoriaGrupal['fecha'], 0, 10)); ?>"></p>
        <p><strong>Nombre del(los) tutores:</strong>  

            <?php
            $idGrupo = intval($tutoriaGrupal['idGrupo']);
            $res = $conn->getTutoresGrupo($idGrupo);
            foreach ($res as $tutor) {
                echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
            }
            echo('</p>');
            echo ('<p> <strong>Lugar de tutorías: </strong> <input id="lugarTuto" type="text" value = "' . $tutoriaGrupal['lugar'] . '"></p>');
            echo ('<p> <strong>Tema: </strong> <input id="temaTuto" type="text" value ="' . $tutoriaGrupal['tema'] . '"></p>');

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
            //Aquí me quedé
            var idTutoriaGrupal = <?php echo($idTutoriaGrupal); ?>;
            var idGrupo = <?php echo($tutoriaGrupal['idGrupo']); ?>;
            var fecha = $("#fecha").val();
            var lugarTuto = $("#lugarTuto").val();
            var temaTuto = $("#temaTuto").val();
            var idTutor = <?php echo($idTutor); ?>;

            if (!fecha) {
                window.alert("Todos los campos con * son obligatorios");
            } else {

                var txtEstado = $("#txtEstado");
                var btnGuardar = $("#btnGuardar");
                var btnCancelar = $("#btnCancelar");
                txtEstado.html("Cargando...");
                txtEstado.show();
                btnCancelar.hide();
                btnGuardar.hide();

                $.ajax({
                    method: "POST",
                    url: "Conexiones/TutoriasGrupales/editarTutoriaGrupal.php",
                    data: {idTutoriaGrupal: idTutoriaGrupal, idGrupo: idGrupo, fecha: fecha, lugarTuto: lugarTuto, temaTuto: temaTuto, idTutor: idTutor}
                }).done(function (msg) {
                    if (msg.localeCompare("ok") != 0) {
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
                        txtEstado.html("Ocurrió un error al editar la tutoría grupal");
                    }
                    btnGuardar.show();
                    btnCancelar.show();
                });

            }
        }

        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaTutoriasGrupalesEditar.php",
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
