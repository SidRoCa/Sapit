<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $tutores = $conn->getListaTutores();
    ?>
    <h2>Editar un Tutor</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Departamento
            </th>
            <th>
                Identificador
            </th>
        </tr>
        <?php
            foreach ($tutores as $tutor) {
                echo ('<tr data-id-tutor ="'.$tutor['id'].'">');
                echo('<td>'.$tutor['nombre'].' '.$tutor['apPaterno'].' '.$tutor['apMaterno'].'</td>');
                echo('<td>'.$tutor['departamento'].'</td>');
                echo('<td>'.$tutor['identificador'].'</td>');
                echo('</tr>');
            }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click","tr", function(){
            var idString = $(this).attr("data-id-tutor");
            if(!(typeof idString == 'undefined')){
                var idTutor = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarTutor.php",
                    data: {idTutor: idTutor}
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
