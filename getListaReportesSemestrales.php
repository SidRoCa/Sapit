<div>
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
    $idTutor = $_POST['idTutor'];
    $reportes = $conn->getListaReportesSemestralesPorTutor($idTutor);
    ?>
    <h2>Lista de reportes semestrales</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha
            </th>
        </tr>
        <?php
        foreach ($reportes as $reporte) {
            echo ('<tr data-id-reporte ="' . $reporte['idReporte'] . '">');
            echo('<td>' . $reporte['nombreGrupo'] . '</td>');
            echo('<td>' . $reporte['fecha'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-reporte");
            if (!(typeof idString == 'undefined')) {
                var idReporte = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getConsultarReporteSemestral.php",
                    data: {idReporte: idReporte}
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
        });
    </script>
</div>
