<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "admin") {
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
                echo ('<p>Administrador<p>');
                ?>
                <p><a href="logout.php">Logout</a></p>
            </div>
            <h1>Página de administrador</h1>

        </div>
        <div id="contenido">
            <div id="leftcolumn">
                <ul>
                    <li>
                        <strong>Carreras</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarCarrera()">Agregar Carrera</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarCarrera()">Editar Carrera</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarCarrera()">Eliminar Carrera</a></li>
                        </ul>
                    </li>
                </ul>
                <ul>
                    <li>
                        <strong>Departamentos</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarDepartamento()">Agregar Departamento</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarDepartamento()">Editar Departamento</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarDepartamento()">Eliminar Departamento</a></li>
                        </ul>
                    </li>
                </ul>
                <ul>
                    <li>
                        <strong>Periodos</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarPeriodo()">Agregar Periodo</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarPeriodo()">Editar Periodo</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarPeriodo()">Eliminar Periodo</a></li>
                        </ul>
                    </li>
                </ul>
                <ul>
                    <li>
                        <strong>Tutores</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarTutor()">Agregar Tutor</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarTutor()">Editar Tutor</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarTutor()">Eliminar Tutor</a></li>
                        </ul>
                    </li>
                </ul>
                <ul>
                    <li>
                        <strong>Grupos</strong>
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicAgregarGrupo()">Agregar Grupo</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEditarGrupo()">Editar Grupo</a></li>
                            <li><a href="javascript:void(0);" onclick="clicEliminarGrupo()">Eliminar Grupo</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="principal">
                <div id="mainContenido" class="mainContenido">
                    <p>Principal</p>    

                </div>
            </div>
        </div>
    </body>
</html>
<script>
    function clicAgregarDepartamento() {
        $.ajax({
            method: "POST",
            url: "getAgregarDepartamento.php"
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

    function clicEditarDepartamento() {
        $.ajax({
            method: "POST",
            url: "getListaDepartamentosEditar.php"
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

    function clicEliminarDepartamento() {
        $.ajax({
            method: "POST",
            url: "getListaDepartamentosEliminar.php"
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

    function clicAgregarCarrera() {
        $.ajax({
            method: "POST",
            url: "getAgregarCarrera.php"
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

    function clicEditarCarrera() {
        $.ajax({
            method: "POST",
            url: "getListaCarrerasEditar.php"
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
    function clicEliminarCarrera() {
        $.ajax({
            method: "POST",
            url: "getListaCarrerasEliminar.php"
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
    function clicAgregarPeriodo() {
        $.ajax({
            method: "POST",
            url: "getAgregarPeriodo.php"
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
    
    function clicEditarPeriodo() {
        $.ajax({
            method: "POST",
            url: "getListaPeriodosEditar.php"
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
    function clicEliminarPeriodo() {
        $.ajax({
            method: "POST",
            url: "getListaPeriodosEliminar.php"
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
    
    function clicAgregarTutor() {
        $.ajax({
            method: "POST",
            url: "getAgregarTutor.php"
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

    function clicEditarTutor() {
        $.ajax({
            method: "POST",
            url: "getListaTutoresEditar.php"
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

    function clicEliminarTutor() {
        $.ajax({
            method: "POST",
            url: "getListaTutoresEliminar.php"
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
    
    function clicAgregarGrupo() {
        $.ajax({
            method: "POST",
            url: "getAgregarGrupo.php"
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
    
    function clicEditarGrupo() {
        $.ajax({
            method: "POST",
            url: "getListaGruposEditar.php"
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
    
    function clicEliminarGrupo() {
        $.ajax({
            method: "POST",
            url: "getListaGruposEliminar.php"
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
