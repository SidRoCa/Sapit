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
    $planes = $conn->getListaPlanesAccionTutorial();
    ?>
    <h2>Lista de planes de acción tutorial por departamento</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Grupo
            </th>
            <th>
                Fecha
            </th>
            <th>
                Tutor 1
            </th>
            <th>
                Tutor 2
            </th>
        </tr>
        <?php
        foreach ($planes as $plan) {
            echo '<tr data-id-plan ="' . $plan['idPlan'] . '">';
            echo '<td>' . $plan['grupo'] . '</td>';
            echo '<td>' . $plan['fecha'] . '</td>';
            echo '<td>' . $plan['tutor1'] . '</td>';
            echo '<td>' . $plan['tutor2'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-plan");
            if (!(typeof idString == 'undefined')) {
                var eliminar = window.confirm('¿Está seguro que desea eliminar este plan? No podrá recuperarlo de nuevo');
                if(eliminar == true){
                    var idPlan = parseInt(idString);
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/PlanesAccionTutorial/eliminarPlanAccionTutorial.php",
                        data: {idPlan: idPlan}
                    }).done(function (msg) {
                        if(msg.localeCompare('ok') == 0){
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
                url: "getListaPlanesAccionTutorialEliminar.php"
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
