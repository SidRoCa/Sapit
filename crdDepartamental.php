<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "crddpt") {
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
                echo ('<p>Usuario: ' . $_SESSION['nombre_usuario'] . ' <p>');
                ?>
                <p><a href="logout.php">Logout</a></p>
            </div>
            <h1>Página de coordinador departamental</h1>

        </div>
        <div id="contenido">
            <div id="leftcolumn">
                <ul>
                    <strong>Documentos y reportes</strong>
                    <ul>
                        <li>
                            Diasnóstico departamental
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicDiagnosticoDepartamental()">Agregar</a></li>
                            <li><a href="javascript:void(0);" onclick="clicConsultarDiagnosticoDepartamental()">Consultar</a></li>
                        </ul>
                        </li>
                        <li>
                            Plan de acción tutorial departamental
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicPlanAccionTutorialDpt()">Agregar</a></li>
                            <li><a href="javascript:void(0);" onclick="clicConsultarPlanAccionTutorial()">Consultar</a></li>
                        </ul>
                        </li>
                        <li>
                            Plan para desarrollar el diagnóstico departamental
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicPlanDesarrollarDiagnosticoDpt()">Agregar</a></li>
                            <li><a href="javascript:void(0);" onclick="clicConsultarPlanDesarrollarDiagnosticoDpt()">Consultar</a></li>
                        </ul>
                        </li>
                        <li><a href="javascript:void(0);" onclick="clicReporteSemestralCoordDpt()">Reporte semestral del coordinador departamental</a></li>
                        <li>
                            Diagnósticos grupales
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicEditarDiagnosticosGrupos()">Editar</a></li>
                        </ul>
                        </li>
                    </ul>
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

    function clicPlanAccionTutorialDpt() {
        $.ajax({
            method: "POST",
            url: "getPlanAccionTutorialDpt.php"

        }).done(function (msg) {

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
    function clicActaResultados() {
        $.ajax({
            method: "POST",
            url: "getActaResultadosObtenidos.php"

        }).done(function (msg) {

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
    function clicDiagnosticoDepartamental() {
        $.ajax({
            method: "POST",
            url: "getDiagnosticoDepartamental.php"

        }).done(function (msg) {

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

    function clicConsultarDiagnosticoDepartamental() {
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosDepartamentales.php"
        }).done(function (msg) {
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
        $.ajax({
            method: "POST",
            url: "getListaPlanesAccionTutorialDepartamental.php"
        }).done(function (msg) {
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

    function clicConsultarPlanDesarrollarDiagnosticoDpt() {
        $.ajax({
            method: "POST",
            url: "getListaPlanesDesarrollarDiagnosticoDpt.php"
        }).done(function (msg) {
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

    function clicPlanDesarrollarDiagnosticoDpt() {
        $.ajax({
            method: "POST",
            url: "getPlaneacionDiagnosticoDepartamental.php"

        }).done(function (msg) {

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
    function clicReporteSemestralCoordDpt() {
        $.ajax({
            method: "POST",
            url: "getReporteSemestralCoordinadorDepartamental.php"

        }).done(function (msg) {

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

    function clicEditarDiagnosticosGrupos(){
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosGruposEditar.php"
        }).done(function (msg) {
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
