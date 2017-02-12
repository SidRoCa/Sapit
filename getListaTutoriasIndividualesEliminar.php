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
    $tutoriasIndividual = $conn->getListaTutoriasIndividualesPorTutor($idTutor);
    ?>
    <h2>Eliminar una Tutoría Individual</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha
            </th>
            <th>
                Alumno
            </th>
        </tr>
        <?php
        foreach ($tutoriasIndividual as $tutoriaIndividual) {
            echo ('<tr data-id-tutoria ="' . $tutoriaIndividual['id'] . '">');
            $grupo = $conn->getGrupo($tutoriaIndividual['idGrupo']);
            echo('<td>' . $grupo . '</td>');
            echo('<td>' . substr($tutoriaIndividual['fecha'], 0, 10) . '</td>');
            $alumno = $conn->getAlumno($tutoriaIndividual['idAlumno']);
            echo('<td>' . $alumno . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {

            var idString = $(this).attr("data-id-tutoria");
            if (!(typeof idString == 'undefined')) {
                var idTutoriaIndividual = parseInt(idString);
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if (eliminar == true) {
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/TutoriasIndividuales/eliminarTutoriaIndividual.php",
                        data: {idTutoriaIndividual: idTutoriaIndividual}
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
                url: "getListaTutoriasIndividualesEliminar.php",
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
