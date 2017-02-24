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
    $planes = $conn->getListaPlanesDesarrollarDiagnosticoDepartamental();
    ?>
    <h2>Lista de planes para desarrollar el diagnóstico departamental</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha
            </th>
            <th>
                Departamento
            </th>
        </tr>
        <?php
        foreach ($planes as $plan) {
            echo '<tr data-id-plan ="' . $plan['idPlan'] . '">';
            echo '<td>' . $plan['fecha'] . '</td>';
            echo '<td>' . $plan['departamento'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-plan");
            if (!(typeof idString == 'undefined')) {
                var eliminar = window.confirm('¿Estás seguro que deseas eliminar esta planeación? No podrás recuperarla de nuevo');
                if(eliminar == true){
                    var idPlan = parseInt(idString);
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/PlanesAccionDesarrollarDiagnosticoDepartamental/eliminarPlanAccionDesarrollarDiagnosticoDepartamental.php",
                        data: {idPlan: idPlan}
                    }).done(function (msg) {
                        if(msg.localeCompare('ok')==0){
                            irALista();
                            window.alert('Eliminado correctamente');
                        }else{
                            window.alert('Ocurrió un error, inténtalo de nuevo');
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
                url: "getListaPlanesDesarrollarDiagnosticoDepartamentalEliminar.php"
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
