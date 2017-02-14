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
    <h2>Eliminar un Coordinador Departamental</h2>
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
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if (eliminar == true) {

                    $.ajax({
                        method: "POST",
                        url: "Conexiones/CoordinadoresDepartamentales/eliminarCoordinadorDepartamental.php",
                        data: {idCoordinador: idCoordinador}
                    }).done(function (msg) {
                        if (msg.localeCompare("ok") == 0) {
                            window.alert("Eliminado correctamente");
                            irALista();
                        } else {
                            window.alert("No es posible eliminar este coordinador departamental");
                        }
                    }).fail(function (jqXHR, textStatus) {
                        if (textStatus === 'timeout') {
                            $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                        } else {
                            $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                        }
                    });
                }
            }
        });
        
        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaCoordinadoresDepartamentalesEliminar.php"
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
</div>
