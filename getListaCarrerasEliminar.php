<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $carreras = $conn->getListaCarreras();
    ?>
    <h2>Eliminar Carrera</h2>
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
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if(eliminar == true){
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Carreras/eliminarCarrera.php",
                        data: {idCarrera: idCarrera}
                    }).done(function (msg) {
                        if(msg.localeCompare("ok") == 0){
                            window.alert("Eliminado correctamente");
                            irALista();
                        }else{
                            window.alert("No es posible eliminar esta carrera");
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

    function irALista(){
        $.ajax({
                method: "POST",
                url: "getListaCarrerasEliminar.php"
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
