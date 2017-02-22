<div>
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
    $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
    $reportes = $conn->getListaReportesTutoresPorDepartamento($idDepartamento);
    ?>
    <h2>Lista de reportes de los tutores</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha
            </th>
            <th>
                Tutor 
            </th>
        </tr>
        <?php
        foreach ($reportes as $reporte) {
            echo '<tr data-id-reporte ="' . $reporte['idReporte'] . '">';
            echo '<td>' . $reporte['grupo'] . '</td>';
            echo '<td>' . $reporte['fecha'] . '</td>';
            echo '<td>' . $reporte['tutor'] . '</td>';
            echo '</tr>';
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
                    url: "getEditarReporteSemestralTutor.php",
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
