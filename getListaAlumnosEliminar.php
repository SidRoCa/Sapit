<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $alumnos = $conn->getListaAlumnos();
    ?>
    <h2>Eliminar Alumno</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Nombre
            </th>
            <th>
                Carrera
            </th>
            <th>
                Grupo
            </th>
        </tr>
        <?php
            foreach ($alumnos as $alumno) {
                echo ('<tr data-id-alumno ="'.$alumno['id'].'">');
                echo('<td>'.$alumno['nombre'].'</td>');
                echo('<td>'.$alumno['carrera'].'</td>');
                echo('<td>'.$alumno['grupo'].'</td>');
                echo('</tr>');
            }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click","tr", function(){
            var idString = $(this).attr("data-id-alumno");
            if(!(typeof idString == 'undefined')){
                var idAlumno = parseInt(idString);
                var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
                if(eliminar == true){
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Alumnos/eliminarAlumno.php",
                        data: {idAlumno: idAlumno}
                    }).done(function (msg) {
                        if(msg.localeCompare("ok") == 0){
                            window.alert("Eliminado correctamente");
                            irALista();
                        }else{
                            alert(msg);
                            window.alert("No es posible eliminar este alumno");
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
                url: "getListaAlumnosEliminar.php"
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
