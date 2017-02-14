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
    $diagnosticos = $conn->getListaDiagnosticosGruposPorTutor($idTutor);
    ?>
    <h2>Lista de diagnósticos grupales</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha diagnóstico
            </th>
            <th>
                Semestre
            </th>
        </tr>
        <?php
        foreach ($diagnosticos as $diagnostico) {
            echo ('<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">');
            echo('<td>' . $diagnostico['nombreGrupo'] . '</td>');
            echo('<td>' . $diagnostico['fechaDiagnostico'] . '</td>');
            echo('<td>' . $diagnostico['semestreDiagnostico'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-diagnostico");
            if (!(typeof idString == 'undefined')) {
                var idDiagnostico = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getConsultarDiagnosticoGrupal.php",
                    data: {idDiagnostico: idDiagnostico}
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
