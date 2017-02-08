<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $carreras = $conn->getListaCarreras();
    ?>
    <h2>Editar una carrera</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Identificador
            </th>
            <th>
                Nombre Carrera
            </th>
            <th>
                Departamento
            </th>
        </tr>
        <?php
            foreach ($carreras as $carrera) {
                echo ('<tr data-id-carrera ="'.$carrera['id'].'">');
                echo('<td>'.$carrera['id'].'</td>');
                echo('<td>'.$carrera['nombre'].'</td>');
                echo('<td>'.$carrera['departamento'].'</td>');
                echo('</tr>');
            }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click","tr", function(){
            var idString = $(this).attr("data-id-carrera");
            if(!(typeof idString == 'undefined')){
                var idCarrera = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarCarrera.php",
                    data: {idCarrera: idCarrera}
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
