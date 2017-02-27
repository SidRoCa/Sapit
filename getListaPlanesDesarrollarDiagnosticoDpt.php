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
    $tipoUsuario = $_SESSION['tipo_usuario'];
    $conn = new Connection();    
    if($tipoUsuario == "crddpt"){
        $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
        $planes = $conn->getListaPlanesDesarrollarDiagnosticoDptPorDepartamento($idDepartamento);
    }elseif ($tipoUsuario == "crdinst") {
        $planes = $conn->getListaPlanesDesarrollarDiagnosticoDepartamental();
    }
    
    ?>
    <h2>Lista de planes para desarrollar el diagnóstico departamental</h2>
    <table id="tablaDatos">
        <?php
        if($tipoUsuario == "crddpt"){
            echo '<tr>';
            echo '<th>Fecha</th>';
            echo '</tr>';
            foreach ($planes as $plan) {
                echo '<tr data-id-plan ="' . $plan['idPlan'] . '">';
                echo '<td>' . $plan['fecha'] . '</td>';
                echo '</tr>';
            }
        }elseif ($tipoUsuario == "crdinst") {
            echo '<tr>';
            echo '<th>Fecha</th>';
            echo '<th>Departamento</th>';
            echo '</tr>';
            foreach ($planes as $plan) {
                echo '<tr data-id-plan ="' . $plan['idPlan'] . '">';
                echo '<td>' . $plan['fecha'] . '</td>';
                echo '<td>' . $plan['departamento'] . '</td>';
                echo '</tr>';
            }
        }
        
        ?>
    </table>
    <script>
        $("#tablaDatos").on("click", "tr", function () {
            var idString = $(this).attr("data-id-plan");
            if (!(typeof idString == 'undefined')) {
                var idPlan = parseInt(idString);
                $.ajax({
                    method: "POST",
                    url: "getConsultarPlanAccionDesarrollarDiagnosticoDepartamental.php",
                    data: {idPlan: idPlan}
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
