<?php
session_start();
if ($_SESSION['tipo_usuario'] !== "crdinst") {
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
            <h1>Página de coordinador institucional</h1>

        </div>
        <div id="contenido">
            <div id="leftcolumn">
                <ul>
                    <strong>Documentos y reportes</strong>
                    <ul>
                        <li><a href="javascript:void(0);" onclick="clicReporteDatosTutores()">Reporte de datos de los docentes tutores</a></li>
                        <li><a href="javascript:void(0);" onclick="clicReporteSemestral()">Reporte semestral</a></li>
                        <li>
                            Diagnosticos departamentales
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicEditarDiagnosticoDepartamental()">Editar</a></li>
                        </ul>
                        </li>
                        <li>
                            Planes acción tutorial departamental
                        <ul>
                            <li><a href="javascript:void(0);" onclick="clicEditarPlanAccionTutorialDepartamental()">Editar</a></li>
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

    function clicReporteDatosTutores() {
        $.ajax({
            method: "POST",
            url: "getReporteDatosTutores.php"

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
    function clicReporteSemestral() {
        $.ajax({
            method: "POST",
            url: "getReporteSemestralCoordinadorInstitucional.php"

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

    function clicEditarDiagnosticoDepartamental(){
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosDepartamentalesEditar.php"
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

    function clicEditarPlanAccionTutorialDepartamental(){
        $.ajax({
            method: "POST",
            url: "getListaPlanesAccionTutorialDepartamentalEditar.php"
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
