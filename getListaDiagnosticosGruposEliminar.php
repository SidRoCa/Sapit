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
    $diagnosticos = $conn->getListaDiagnosticosGrupos();
    ?>
    <h2>Lista de diagnósticos grupales</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha diagnóstico
            </th>
            <th>
                Semestre
            </th>
            <th>
                Tutor 1
            </th>
            <th>
                Tutor 2
            </th>
        </tr>
        <?php
        foreach ($diagnosticos as $diagnostico) {
            echo ('<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">');
            echo('<td>' . $diagnostico['grupo'] . '</td>');
            echo('<td>' . $diagnostico['fecha'] . '</td>');
            echo('<td>' . $diagnostico['semestre'] . '</td>');
            echo('<td>' . $diagnostico['tutor1'] . '</td>');
            echo('<td>' . $diagnostico['tutor2'] . '</td>');
            echo('</tr>');
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-diagnostico");
            if (!(typeof idString == 'undefined')) {
                var idDiagnostico = parseInt(idString);
                var eliminar = window.confirm('¿Estás seguro que deseas eliminar este elemento? No podrás recuperarlo de nuevo');
                if(eliminar == true){
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/DiagnosticosGrupales/eliminarDiagnosticoGrupal.php",
                        data: {idDiagnostico: idDiagnostico}
                    }).done(function (msg) {
                        if(msg.localeCompare('ok') == 0){
                            irALista();
                            window.alert('Eliminado correctamente');
                        }else{
                            window.alert('Ocurrió un error, inténtalo más tarde');   
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
                url: "getListaDiagnosticosGruposEliminar.php"
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
