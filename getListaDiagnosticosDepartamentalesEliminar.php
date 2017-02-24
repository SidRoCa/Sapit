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
    $diagnosticos = $conn->getListaDiagnosticosDepartamentales();
    ?>
    <h2>Lista de diagnósticos departamentales</h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha diagnóstico
            </th>
            <th>
                Coordinador
            </th>
            <th>
                Departamento
            </th>
        </tr>
        <?php
        foreach ($diagnosticos as $diagnostico) {
            echo '<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">';
            echo '<td>'.$diagnostico['fecha'].'</td>';
            echo '<td>'.$diagnostico['coordinador'].'</td>';
            echo '<td>'.$diagnostico['departamento'].'</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-diagnostico");
            if (!(typeof idString == 'undefined')) {
                var eliminar = window.confirm('¿Estás seguro que deseas eliminar este diagnóstico? No podrás recuperarlo de nuevo');
                if(eliminar == true){
                    var idDiagnostico = parseInt(idString);
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/DiagnosticosDepartamentales/eliminarDiagnosticoDepartamental.php",
                        data: {idDiagnostico: idDiagnostico}
                    }).done(function (msg) {
                        if(msg.localeCompare('ok') == 0){
                            irALista();
                            window.alert('Eliminado correctamente');
                        }else{
                            window.alert('Ocurrió un problema, inténtalo de nuevo');
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
                url: "getListaDiagnosticosDepartamentalesEliminar.php"
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
