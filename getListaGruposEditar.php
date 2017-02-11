<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $grupos = $conn->getListaGrupos();
    ?>
    <h2>Editar un Grupo</h2>
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
                echo ('<tr data-id-grupo ="'.$grupo['id'].'">');
                echo('<td>'.$grupo['nombre'].'</td>');
                $tut = $conn->getTutor($grupo['idTutor1']);
                echo('<td>'.$tut['nombres'].' '.$tut['apPaterno'].' '. $tut['apMaterno'] .'</td>');
                $tut = $conn->getTutor($grupo['idTutor2']);
                echo('<td>'.$tut['nombres'].' '.$tut['apPaterno'].' '. $tut['apMaterno'] .'</td>');
                echo('</tr>');
            }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click","tr", function(){
            var idString = $(this).attr("data-id-grupo");
            if(!(typeof idString == 'undefined')){
                var idGrupo = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarGrupo.php",
                    data: {idGrupo: idGrupo}
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
