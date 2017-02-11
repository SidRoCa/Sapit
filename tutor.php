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
                            <li><a href="javascript:void(0);" onclick="clicRegistroTutoriaIndividual()">Individual</a></li>
                            <li><a href="javascript:void(0);" onclick="clicRegistroTutoriaGrupal()">Grupal</a></li>
                        </ul>
                    </li>
                    <li>
                        <strong>Documentos y reportes</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicDiagnosticoGrupo()">Diagnóstico de grupo</a></li>
                            <li><a href="javascript:void(0);" onclick="clicPlanAccionTutorial()">Plan de acción tutorial</a></li>
                            <li><a href="javascript:void(0);" onclick="clicReporteSemestral()">Reporte semestral del tutor</a></li>
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
                    <li>
                        <strong>Periodos</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarDepartamento()">Agregar Departamento</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarDepartamento()">Editar Departamento</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarDepartamento()">Eliminar Departamento</a></li>
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
                    $tutor = $conn->getTutor($idTutor);
                    ?>
                        <input type="text" id="idTutor" value="<?php echo ($idTutor); ?>" hidden>
                        <p><strong>Nombres: </strong><input type="text" id="nombres" value="<?php echo($tutor['nombres']); ?>"></p>
                        <p><strong>Apellido paterno: </strong><input type="text" id="apPaterno" value="<?php echo($tutor['apPaterno']); ?>"></p>
                        <p><strong>Apellido materno: </strong><input type="text" id="apMaterno" value="<?php echo($tutor['apMaterno']); ?>"></p>
                        <p><strong>Correo electrónico: </strong><input type="text" id="correo" value="<?php echo($tutor['correo']); ?>"></p>
                        <p><strong>Departamento al que está adscrito: </strong><?php echo($tutor['nombreDpto']); ?></p>
                        <p><strong>Teléfono: </strong><input type="text" id="telefono" value="<?php echo($tutor['telefono']); ?>"></p>
                        <p><strong>Lugar tutorías: </strong> <input type="text" id="lugar" value="<?php echo($tutor['lugarTutoria']); ?>"> </p>
                        <p><strong>Horario tutorías: </strong> <input type="text" id="horario" value="<?php echo($tutor['horario']); ?>"></p>
                        <p><strong>Grupo tutorado: </strong><?php echo($tutor['nombreGrupo']); ?></p>
                        <button onclick="clicGuardarDatosTutor()">Guardar</button>
                        <button onclick="clicCancelar()">Cancelar</button>
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
        $.ajax({
            method: "POST",
            url: "getVerDatosTutorActualizado.php",
            data: {idTutor: $('#idTutor').val(), nombres: $('#nombres').val(), apPaterno: $('#apPaterno').val(), apMaterno: $('#apMaterno').val(), correo: $('#correo').val(), telefono: $('#telefono').val(), lugar: $('#lugar').val(), horario: $('#horario').val()}
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
        $("#mainContenido").hide();
        $("#actualizarDatosTutor").hide();
        $("#fichaAlumnosTutorados").hide();
        $("#registroAsistenciaIndividual").hide();
        $("#registroAsistenciaGrupal").hide();
        $("#diagnosticoGrupo").hide();
        $("#actaResultadosObtenidos").hide();
        $("#planAccionTutorial").hide();
        $("#reporteSemestral").hide();
        $("#cartaCompromiso").hide();
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
