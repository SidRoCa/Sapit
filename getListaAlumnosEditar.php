<div>
    <?php
        require "conexion.php";
        $conn = new Connection();
        session_start();
        $alumnos = $conn->getListaAlumnos();
    ?>
    <h2>Editar un Alumno</h2>
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
                $.ajax({
                    method: "POST",
                    url: "getEditarAlumno.php",
                    data: {idAlumno: idAlumno}
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
