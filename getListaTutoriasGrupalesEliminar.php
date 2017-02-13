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
    $tutoriasGrupal = $conn->getListaTutoriasGrupalesPorTutor($idTutor);
    ?>
    <h2>Eliminar una Tutoría Grupal</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha
            </th>
            <th>
                Tema
            </th>
        </tr>
        <?php
        foreach ($tutoriasGrupal as $tutoriaGrupal) {
            echo ('<tr data-id-tutoria ="' . $tutoriaGrupal['id'] . '">');
            $grupo = $conn->getGrupo($tutoriaGrupal['idGrupo']);
            echo('<td>' . $grupo . '</td>');
            echo('<td>' . substr($tutoriaGrupal['fecha'], 0, 10) . '</td>');
            echo('<td>' . $tutoriaGrupal['tema'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>

    <script>
        $("#tablaDatos").on("click", "tr", function () {

            var idString = $(this).attr("data-id-tutoria");
            if (!(typeof idString == 'undefined')) {
                var idTutoriaGrupal = parseInt(idString);
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if (eliminar == true) {
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/TutoriasGrupales/eliminarTutoriaGrupal.php",
                        data: {idTutoriaGrupal: idTutoriaGrupal}
                    }).done(function (msg) {
                        if (msg.localeCompare("ok") == 0) {
                            window.alert("Eliminado correctamente");
                            irALista();
                        } else {
                            window.alert("No es posible eliminar esta tutoria individual");
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
                url: "getListaTutoriasGrupalesEliminar.php",
                data: {idTutor: <?php echo($idTutor); ?>}
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
