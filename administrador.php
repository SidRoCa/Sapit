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
    
</script>
