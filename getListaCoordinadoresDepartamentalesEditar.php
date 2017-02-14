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
    $coordinadoresDepartamentales = $conn->getListaCoordinadoresDepartamentales();
    ?>
    <h2>Editar un Coordinador Departamental</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Departamento
            </th>
        </tr>
        <?php
        foreach ($coordinadoresDepartamentales as $coordinadorDepartamental) {
            echo ('<tr data-id-coordinador ="' . $coordinadorDepartamental['id'] . '">');
            echo('<td>' . $coordinadorDepartamental['nombre'] . '</td>');
            $departamento = $conn->getDpto($coordinadorDepartamental['iddpto']);
            echo('<td>' . $departamento . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-coordinador");
            if (!(typeof idString == 'undefined')) {
                var idCoordinador = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarCoordinadorDepartamental.php",
                    data: {idCoordinador: idCoordinador}
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
