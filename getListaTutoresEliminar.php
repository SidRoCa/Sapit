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
        session_start();
        $tutores = $conn->getListaTutores();
    ?>
    <h2>Eliminar Tutor</h2>
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
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if(eliminar == true){
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Tutores/eliminarTutor.php",
                        data: {idTutor: idTutor}
                    }).done(function (msg) {
                        if(msg.localeCompare("ok") == 0){
                            window.alert("Eliminado correctamente");
                            irALista();
                        }else{
                            alert(msg);
                            window.alert("No es posible eliminar este tutor");
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
                url: "getListaTutoresEliminar.php"
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
