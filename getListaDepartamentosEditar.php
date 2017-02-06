<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $departamentos = $conn->getListaDepartamentos();
    ?>
    <h2>Editar un departamento</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Identificador
            </th>
            <th>
                Nombre departamento
            </th>
        </tr>
        <?php
            foreach ($departamentos as $departamento) {
                echo ('<tr data-id-departamento ="'.$departamento['id'].'">');
                echo('<td>'.$departamento['id'].'</td>');
                echo('<td>'.$departamento['nombre'].'</td>');
                echo('</tr>');
            }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click","tr", function(){
            var idString = $(this).attr("data-id-departamento");
            if(!(typeof idString == 'undefined')){
                var idDepartamento = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getEditarDepartamento.php",
                    data: {idDepartamento: idDepartamento}
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
