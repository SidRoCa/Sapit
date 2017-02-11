<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();
    $grupos = $conn->getListaGrupos();
    ?>
    <h2>Eliminar un Grupo</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Primer tutor
            </th>
            <th>
                Segundo tutor
            </th>
        </tr>
        <?php
        foreach ($grupos as $grupo) {
            echo ('<tr data-id-grupo ="' . $grupo['id'] . '">');
            echo('<td>' . $grupo['nombre'] . '</td>');
            $tut = $conn->getTutor($grupo['idTutor1']);
            echo('<td>' . $tut['nombres'] . ' ' . $tut['apPaterno'] . ' ' . $tut['apMaterno'] . '</td>');
            $tut = $conn->getTutor($grupo['idTutor2']);
            echo('<td>' . $tut['nombres'] . ' ' . $tut['apPaterno'] . ' ' . $tut['apMaterno'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-grupo");
            if (!(typeof idString == 'undefined')) {
                var idGrupo = parseInt(idString);
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if (eliminar == true) {
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Grupos/eliminarGrupo.php",
                        data: {idGrupo: idGrupo}
                    }).done(function (msg) {
                        if(msg.localeCompare("ok") == 0){
                            window.alert("Eliminado correctamente");
                            irALista();
                        }else{
                            window.alert("No es posible eliminar este grupo");
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
                url: "getListaGruposEliminar.php"
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