<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();    
    $reportes = $conn->getListaReportesSemestralesTutores();
    ?>
    <h2>Lista de reportes semestrales</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha
            </th>
            <th>
                Tutor
            </th>
            <th>
                Grupo
            </th>
        </tr>
        <?php
        foreach ($reportes as $reporte) {
            echo ('<tr data-id-reporte ="' . $reporte['idReporte'] . '">');
            echo('<td>' . $reporte['fecha'] . '</td>');
            echo('<td>' . $reporte['tutor'] . '</td>');
            echo('<td>' . $reporte['grupo'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-reporte");
            if (!(typeof idString == 'undefined')) {
                var eliminar = window.confirm('¿Seguro que deseas eliminar este reporte? No podrás recuperarlo de nuevo');
                if(eliminar == true){
                    var idReporte = parseInt(idString);
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/ReportesSemestralesTutor/eliminarReporteSemestralTutor.php",
                        data: {idReporte: idReporte}
                    }).done(function (msg) {
                        if(msg.localeCompare('ok')==0){
                            window.alert('Eliminado correctamente');
                            irALista();
                        }else{
                            window.alert('Ocurrió un error, inténtalo de nuevo')
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
                url: "getListaReportesSemestralesTutorEliminar.php"
            }).done(function (msg) {
                $("#mainContenido").show();
                $("#mainContenido").html(msg);
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
