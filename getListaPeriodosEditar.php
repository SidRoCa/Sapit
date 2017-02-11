<div>
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
    session_start();
    $periodos = $conn->getListaPeriodos();
    ?>
    <h2>Editar un periodo</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Identificador
            </th>
            <th>
                Nombre periodo
            </th>
            <th>
                Fecha inicio
            </th>
            <th>
                Fecha fin
            </th>
        </tr>
        <?php
        foreach ($periodos as $periodo) {
            echo ('<tr data-id-periodo ="' . $periodo['id'] . '">');
            echo('<td>' . $periodo['id'] . '</td>');
            echo('<td>' . $periodo['identificador'] . '</td>');
            echo('<td>' . substr($periodo['fecha_inicio'], 0, 10) . '</td>');
            echo('<td>' . substr($periodo['fecha_fin'], 0, 10) . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-periodo");
            if (!(typeof idString == 'undefined')) {
                var idPeriodo = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarPeriodo.php",
                    data: {idPeriodo: idPeriodo}
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
