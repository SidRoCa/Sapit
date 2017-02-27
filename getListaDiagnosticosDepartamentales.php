<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $tipoUsuario = $_SESSION['tipo_usuario'];
    if($tipoUsuario == "crddpt"){
        $nombreCoordinador = $_SESSION["nombre_usuario"];
        $diagnosticos = $conn->getListaDiagnosticosDepartamentalesPorCoordinador($nombreCoordinador);
    }elseif ($tipoUsuario == "crdinst") {
        $diagnosticos = $conn->getListaDiagnosticosDepartamentales();
    }
    
    ?>
    <h2>Lista de diagnósticos departamentales </h2>
    <table id="tablaDatos">
        <tr>
            <th>
                Fecha diagnóstico
            </th>
        </tr>
        <?php
        if($tipoUsuario == "crddpt"){
            echo '<tr>';
            echo '<td>Fecha diagnóstico</td>';
            echo '</tr>';
            foreach ($diagnosticos as $diagnostico) {
                echo '<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">';
                echo '<td>'.$diagnostico['fecha'].'</td>';
                echo '</tr>';
            }
        }elseif ($tipoUsuario == "crdinst") {
            echo '<tr>';
            echo '<td>Fecha diagnóstico</td>';
            echo '<td>Coordinador</td>';
            echo '<td>Departamento</td>';
            echo '</tr>';
            foreach ($diagnosticos as $diagnostico) {
                echo '<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">';
                echo '<td>'.$diagnostico['fecha'].'</td>';
                echo '<td>'.$diagnostico['coordinador'].'</td>';
                echo '<td>'.$diagnostico['departamento'].'</td>';
                echo '</tr>';
            }
        }
        
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-diagnostico");
            if (!(typeof idString == 'undefined')) {
                var idDiagnostico = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getConsultarDiagnosticoDepartamental.php",
                    data: {idDiagnostico: idDiagnostico}
                }).done(function (msg) {
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
