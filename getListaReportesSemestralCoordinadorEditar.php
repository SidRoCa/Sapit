<div>
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
    $reportes = $conn->getListaReportesSemestralesCoordinador();
    ?>
    <h2>Lista de reportes semestrales del tutor</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha
            </th>
            <th>
                Coordinador
            </th>
            <th>
                Departamento académico
            </th>
        </tr>
        <?php
        foreach ($reportes as $reporte) {
            echo ('<tr data-id-reporte ="' . $reporte['id'] . '">');
            echo('<td>' . $reporte['fecha'] . '</td>');
            echo('<td>' . $reporte['coordinador'] . '</td>');
            echo('<td>' . $reporte['departamento'] . '</td>');
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
                    url: "getEditarReporteSemestralCoordinador.php",
                    data: {idReporte: idReporte}
                }).done(function (msg) {
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
