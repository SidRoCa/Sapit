<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "tutor") {
    ?>
    <SCRIPT LANGUAGE="javascript">
        location.href = "validarSesion.php";
    </SCRIPT> 
    <?php
}
require "conexion.php";
$conn = new Connection();
?>
<html>
    <head>
        <link href="estilo.css" rel="stylesheet">
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <meta charset="UTF-8">
        <title>Sapit</title>
    </head>
    <body>
        <div id="norte">
            <div id="sesion">

                <?php
                echo ('<p>Tutor: ' . $_SESSION['nombre_usuario'] . ' <p>');
                ?>
                <p><a href="logout.php">Logout</a></p>
            </div>
            <h1>Página de tutor</h1>

        </div>
        <div id="contenido">
            <div id="leftcolumn">
                <ul>
                    <li>
                        <strong>Grupos</strong> <i>- listado de grupos</i>
                        <ul>
                            <?php
                            $grupos = $conn->getGruposTutorGrupos($_SESSION['k_username']);
                            foreach ($grupos as $grup) {
                                echo ('<li><a id="' . $grup['nombre'] . '" class="grupos"  href="javascript:void(0);" onclick="clicGrupos(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <strong>Tutorías</strong> <i>- registro de asistencia</i>
                        <ul>

                            <li>
                                Individual
                                <ul>
                                    <li><a href="javascript:void(0);" onclick="clicRegistroTutoriaIndividual()">Registro de tutoría individual</a></li>
                                    <li><a href="javascript:void(0);" onclick="clicVerListaTutoriasIndividualesEditar()">Ver lista de tutorías individual (editar)</a></li>
                                    <li><a href="javascript:void(0);" onclick="clicVerListaTutoriasIndividualesEliminar()">Eliminar tutorías individuales</a></li>
                                </ul>
                            </li>
                            <li>
                                Grupal
                                <ul>
                                    <li><a href="javascript:void(0);" onclick="clicRegistroTutoriaGrupal()">Registro de tutoría grupal</a></li>
                                    <li><a href="javascript:void(0);" onclick="clicVerListaTutoriasGrupalesEditar()">Ver lista de tutorias individual (editar)</a></li>
                                    <li><a href="javascript:void(0);" onclick="clicVerListaTutoriasGrupalesEliminar()">Eliminar tutorías grupales</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <strong>Documentos y reportes</strong>
                        <ul>
                            <li>
                                Diasnóstico grupal
                            <ul>
                                <li><a href="javascript:void(0);" onclick="clicDiagnosticoGrupo()">Agregar</a></li>
                                <li><a href="javascript:void(0);" onclick="clicConsultarDiagnosticoGrupo()">Consultar</a></li>
                            </ul>
                            </li>
                            <li>
                                Plan de acción tutorial
                            <ul>
                                <li><a href="javascript:void(0);" onclick="clicPlanAccionTutorial()">Agregar</a></li>
                                <li><a href="javascript:void(0);" onclick="clicConsultarPlanAccionTutorial()">Consultar</a></li>
                            </ul>
                            </li>
                            <li>
                                Reporte semestral del tutor
                            <ul>
                                <li><a href="javascript:void(0);" onclick="clicReporteSemestral()">Agregar</a></li>
                                <li><a href="javascript:void(0);" onclick="clicConsultarReporteSemestral()">Consultar</a></li>
                            </ul>
                            </li>
                            
                            <li><a href="javascript:void(0);" onclick="clicActaResultadosObtenidos()">Acta de resultados obtenidos</a></li>
                            <li><a href="javascript:void(0);" onclick="clicCartaCompromiso()">Carta compromiso</a></li>
                        </ul>
                    </li>
                    <li>
                        <strong>Información del tutor</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicVerDatosTutor(<?php echo($_SESSION['id_usuario']); ?>)">Ver datos del tutor</a></li>
                            <li><a href="javascript:void(0);" onclick="clicActualizarDatosTutor()">Actualizar datos del tutor</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="principal">
                <div id="mainContenido" class="mainContenido">
                    <p>Principal</p>    
                </div>
                <div id="fichaAlumnosTutorados" hidden></div>
                <div id="registroAsistenciaIndividual" hidden>
                    <h2>Registro de asistencia individal</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposRegistroAsistenciaIndividual(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="actaResultadosObtenidos" hidden>
                    <h2>Acta de resultados obtenidos</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposActaResultadosObtenidos(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="cartaCompromiso" hidden>
                    <h2>Carta compromiso</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposCartaCompromiso(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="registroAsistenciaGrupal" hidden>

                    <h2>Registro de asistencia grupal</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposRegistroAsistenciaGrupal(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="diagnosticoGrupo" hidden>

                    <h2>Diagnóstico de grupo</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposDiagnosticoGrupo(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="planAccionTutorial" hidden>

                    <h2>Plan de acción tutorial</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        $grupos = $conn->getGruposTutorGrupos($_SESSION['k_username']);
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposPlanAccionTutorial(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="reporteSemestral" hidden>

                    <h2>Reporte semestral del tutor</h2>
                    <p>Seleccione un grupo</p>
                    <ul>
                        <?php
                        $grupos = $conn->getGruposTutorGrupos($_SESSION['k_username']);
                        foreach ($grupos as $grup) {
                            echo ('<li><a id="' . $grup['nombre'] . '" href="javascript:void(0);" onclick="clicGruposReporteSemestral(\'' . $grup['id'] . '\')">' . $grup['nombre'] . '</a></li>');
                        }
                        ?>
                    </ul>
                </div>
                <div id="actualizarDatosTutor" hidden>
                    <h2>DATOS DEL DOCENTE TUTOR</h2>
                    <?php
                    $idTutor = intval($_SESSION['id_usuario']);
                    $tutor = $conn->getTutorPorId($idTutor);
                    ?>
                    <input type="text" id="idTutor" value="<?php echo ($idTutor); ?>" hidden>

                    <label for = "nombres">
                        Nombres : *
                    </label>
                    <input type="text" name = "nombres" id="txtNombre" value="<?php echo($tutor['nombre']); ?>"/></br>
                    <label for = "apPaterno">
                        Ap. Paterno : *
                    </label>
                    <input type="text" name = "apPaterno" id="txtApPaterno" value="<?php echo($tutor['apPaterno']); ?>"/></br>
                    <label for = "apMaterno">
                        Ap. Materno : *
                    </label>
                    <input type="text" name = "apMaterno" id="txtApMaterno" value="<?php echo($tutor['apMaterno']); ?>"/></br>
                    <label for = "correo">
                        Correo :
                    </label>
                    <input type="text" name = "correo" id="txtCorreo" value="<?php echo($tutor['correo']); ?>"/></br>



                    <label for = "telefono">
                        Telefono : 
                    </label>
                    <input type="text" name = "telefono" id="txtTelefono" value="<?php echo($tutor['telefono']); ?>"/></br>
                    <label for = "ciudad">
                        Ciudad : 
                    </label>
                    <input type="text" name = "ciudad" id="txtCiudad" value="<?php echo($tutor['ciudad']); ?>"/></br>
                    <label for = "domicilio">
                        Domicilio : 
                    </label>
                    <input type="text" name = "domicilio" id="txtDomicilio" value="<?php echo($tutor['domicilio']); ?>"/></br>
                    <label for = "identificador">
                        Identificador : *
                    </label>
                    <input type="text" name = "identificador" id="txtIdentificador" value="<?php echo($tutor['identificador']); ?>"/></br>
                    <label for = "nip">
                        NIP : *
                    </label>
                    <input type="password" name = "nip" id="txtNip" value="<?php echo($tutor['nip']); ?>"/></br>
                    <label for = "nipComp">
                        NIP (de nuevo) : *
                    </label>
                    <input type="password" name = "nipComp" id="txtNipComp" value="<?php echo($tutor['nip']); ?>"/></br>
                    <button onclick="clicGuardarDatosTutor()" id="btnGuardar">
                        Aceptar
                    </button>
                    <button onclick="clicCancelar()" id="btnCancelar">
                        Cancelar
                    </button>
                    <p id="txtEstado" hidden>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
<script>

    function clicGrupos(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getFichaAlumnosTutorados.php",
            data: {idGrupo: idGrupo}
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
            $("#fichaAlumnosTutorados").html(msg);
            $("#fichaAlumnosTutorados").show();
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }
    function clicVerListaTutoriasIndividualesEditar() {
        $.ajax({
            method: "POST",
            url: "getListaTutoriasIndividualesEditar.php",
            data: {idTutor: <?php echo($_SESSION["id_usuario"]); ?>}
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
    function clicVerListaTutoriasGrupalesEditar() {
        $.ajax({
            method: "POST",
            url: "getListaTutoriasGrupalesEditar.php",
            data: {idTutor: <?php echo($_SESSION["id_usuario"]); ?>}
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
        5
    }
    function clicVerListaTutoriasGrupalesEliminar() {
        $.ajax({
            method: "POST",
            url: "getListaTutoriasGrupalesEliminar.php",
            data: {idTutor: <?php echo($_SESSION["id_usuario"]); ?>}
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
        5
    }
    function clicVerListaTutoriasIndividualesEliminar() {
        $.ajax({
            method: "POST",
            url: "getListaTutoriasIndividualesEliminar.php",
            data: {idTutor: <?php echo($_SESSION["id_usuario"]); ?>}
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

    function clicVerDatosTutor(idTutor) {
        $.ajax({
            method: "POST",
            url: "getVerDatosTutor.php",
            data: {idTutor: idTutor}
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
    function clicGuardarDatosTutor() {
        var idTutor = <?php echo ($idTutor); ?>;
        var nombre = $("#txtNombre");
        var apPaterno = $("#txtApPaterno");
        var apMaterno = $("#txtApMaterno");
        var correo = $("#txtCorreo");
        var telefono = $("#txtTelefono");
        var ciudad = $("#txtCiudad");
        var domicilio = $("#txtDomicilio");
        var identificador = $("#txtIdentificador");
        var nip = $("#txtNip");
        var nipComp = $("#txtNipComp");
        if (!nombre.val() || !apPaterno.val() || !apMaterno.val() || !nip.val() || !identificador.val() || !nipComp.val()) {
            window.alert("Todos los campos con * son obligatorios");
        } else {

            if (nip.val().localeCompare(nipComp.val()) == 0) {
                $.ajax({
                    method: "POST",
                    url: "getVerDatosTutorActualizado.php",
                    data: {idTutor: idTutor, nombre: nombre.val(), apPaterno: apPaterno.val(), apMaterno: apMaterno.val(),
                        correo: correo.val(), telefono: telefono.val(), ciudad: ciudad.val(), domicilio: domicilio.val(), 
                        identificador: identificador.val(), nip: nip.val(), identificadorAnterior: <?php echo($tutor['identificador']); ?>, nipAnterior: <?php echo($tutor['nip']); ?>}
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
                    $("#mainContenido").html(msg);
                    $("#mainContenido").show();

                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                    } else {
                        $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                    }
                });
            } else {
                window.alert("EL nip y la comprobación no coinciden");
            }

        }

    }
    function clicActualizarDatosTutor() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").show();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#diagnosticoGrupo").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#cartaCompromiso").hide();
    }
    function clicCancelar() {
        
        
        clicVerDatosTutor(<?php echo($idTutor);?>);
        
    }
    function clicGruposActaResultadosObtenidos(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getActaResultadosObtenidos.php",
            data: {idGrupo: idGrupo}
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
            $("#fichaAlumnosTutorados").html(msg);
            $("#fichaAlumnosTutorados").show();
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }
    function clicGruposCartaCompromiso(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getCartaCompromiso.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#mainContenido").hide();
            $("#actualizarDatosTutor").hide();
            $("#cartaCompromiso").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#reporteSemestral").hide();
            $("#actaResultadosObtenidos").hide();
            $("#cartaCompromiso").hide();
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
    function clicReporteSemestral() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#diagnosticoGrupo").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").show();
        $("#cartaCompromiso").hide();
    }
    function clicActaResultadosObtenidos() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#diagnosticoGrupo").hide();
        $("#actaResultadosObtenidos").show();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#cartaCompromiso").hide();
    }
    function clicPlanAccionTutorial() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#actaResultadosObtenidos").hide();
        $("#diagnosticoGrupo").hide();
        $("#reporteSemestral").hide();
        $("#planAccionTutorial").show();
        $("#cartaCompromiso").hide();
    }
    function clicDiagnosticoGrupo() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#diagnosticoGrupo").show();
        $("#cartaCompromiso").hide();
    }

    function clicConsultarDiagnosticoGrupo() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#diagnosticoGrupo").hide();
        $("#cartaCompromiso").hide();
        var idTutor = <?php echo $idTutor ?>;
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosGrupos.php",
            data: {idTutor: idTutor}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#cartaCompromiso").hide();
            $("#reporteSemestral").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }
    function clicConsultarPlanAccionTutorial() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#diagnosticoGrupo").hide();
        $("#cartaCompromiso").hide();
        var idTutor = <?php echo $idTutor ?>;
        $.ajax({
            method: "POST",
            url: "getListaPlanesAccionTutorial.php",
            data: {idTutor: idTutor}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#cartaCompromiso").hide();
            $("#reporteSemestral").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }

    function clicConsultarReporteSemestral() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#diagnosticoGrupo").hide();
        $("#cartaCompromiso").hide();
        var idTutor = <?php echo $idTutor ?>;
        $.ajax({
            method: "POST",
            url: "getListaReportesSemestrales.php",
            data: {idTutor: idTutor}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#cartaCompromiso").hide();
            $("#reporteSemestral").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }

    function clicRegistroTutoriaGrupal() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#actaResultadosObtenidos").hide();
        $("#diagnosticoGrupo").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#registroAsistenciaGrupal").show();
        $("#cartaCompromiso").hide();
    }
    function clicRegistroTutoriaIndividual() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").show();
        $("#actaResultadosObtenidos").hide();
        $("#diagnosticoGrupo").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#cartaCompromiso").hide();
    }
    function clicCartaCompromiso() {
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#actaResultadosObtenidos").hide();
        $("#diagnosticoGrupo").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#cartaCompromiso").hide();
        $("#cartaCompromiso").show();
    }

    function clicGruposPlanAccionTutorial(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getPlanAccionTutorial.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#cartaCompromiso").hide();
            $("#reporteSemestral").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });


    }

    function clicGruposRegistroAsistenciaGrupal(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getRegistroAsistenciaGrupal.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#cartaCompromiso").hide();
            $("#actualizarDatosTutor").hide();
            $("#fichaAlumnosTutorados").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#actaResultadosObtenidos").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#reporteSemestral").hide();
            $("#cartaCompromiso").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }
    function clicGruposReporteSemestral(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getReporteSemestral.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#cartaCompromiso").hide();
            $("#actualizarDatosTutor").hide();
            $("#fichaAlumnosTutorados").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#actaResultadosObtenidos").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#reporteSemestral").hide();
            $("#cartaCompromiso").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }

    function clicGruposRegistroAsistenciaIndividual(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getRegistroAsistenciaIndividual.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#cartaCompromiso").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#reporteSemestral").hide();
            $("#cartaCompromiso").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);
        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });


    }

    function clicGruposDiagnosticoGrupo(idGrupo) {
        $.ajax({
            method: "POST",
            url: "getDiagnosticoGrupo.php",
            data: {idGrupo: idGrupo}
        }).done(function (msg) {
            $("#fichaAlumnosTutorados").hide();
            $("#actualizarDatosTutor").hide();
            $("#cartaCompromiso").hide();
            $("#registroAsistenciaGrupal").hide();
            $("#registroAsistenciaIndividual").hide();
            $("#actaResultadosObtenidos").hide();
            $("#diagnosticoGrupo").hide();
            $("#planAccionTutorial").hide();
            $("#reporteSemestral").hide();
            $("#cartaCompromiso").hide();
            $("#mainContenido").show();
            $("#mainContenido").html(msg);

        }).fail(function (jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
            } else {
                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
            }
        });
    }
</script>
