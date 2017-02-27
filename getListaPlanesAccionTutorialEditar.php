<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario'] !=="crdinst") {
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
        $planes = $conn->getListaPlanesAccionTutorialPorDepartamento($idDepartamento);
    }elseif ($tipoUsuario == "crdinst") {
        $planes = $conn->getListaPlanesAccionTutorial();
    }
    
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
            if($tipoUsuario == "crddpt"){
                echo '<td>' . $plan['tutor'] . '</td>';
            }elseif ($tipoUsuario == "crdinst") {
                echo '<td>' . $plan['tutor1'] . '</td>';
            }
            echo '<td>' . $plan['tutor2'] . '</td>';
            echo '</tr>';
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
                    url: "getEditarPlanAccionTutorial.php",
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
