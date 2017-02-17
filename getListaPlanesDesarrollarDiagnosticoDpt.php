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
    $planes = $conn->getListaPlanesDesarrollarDiagnosticoDptPorDepartamento($idDepartamento);
    ?>
    <h2>Lista de planes para desarrollar el diagnóstico departamental</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha
            </th>
        </tr>
        <?php
        foreach ($planes as $plan) {
            echo '<tr data-id-plan ="' . $plan['idPlan'] . '">';
            echo '<td>' . $plan['fecha'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-plan");
            if (!(typeof idString == 'undefined')) {
                var idPlan = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getConsultarPlanAccionDesarrollarDiagnosticoDepartamental.php",
                    data: {idPlan: idPlan}
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
