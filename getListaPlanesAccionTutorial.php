<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor" and $_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario'] != "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();    
    if($_SESSION['tipo_usuario'] == "tutor"){
        $idTutor = $_POST['idTutor'];
        $planes = $conn->getListaPlanesAccionPorTutor($idTutor);
    }elseif ($_SESSION['tipo_usuario'] == "crddpt") {
        $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
        $planes = $conn->getListaPlanesAccionTutorialPorDepartamento($idDepartamento);
    }elseif ($_SESSION['tipo_usuario'] == "crdinst") {
        $planes = $conn->getListaPlanesAccionTutorial();
    }
    
    ?>
    <h2>Lista de planes de acción tutorial</h2>
    <table id="tablaDatos">
        <?php
        if($_SESSION['tipo_usuario']=="tutor"){
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha</th>';
            echo '</tr>';
            foreach ($planes as $plan) {
                echo ('<tr data-id-plan ="' . $plan['idPlan'] . '">');
                echo('<td>' . $plan['nombreGrupo'] . '</td>');
                echo('<td>' . $plan['fechaPlan'] . '</td>');
                echo('</tr>');
            }
        }elseif ($_SESSION['tipo_usuario'] == "crddpt") {
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha</th>';
            echo '<th>Tutor 1</th>';
            echo '<th>Tutor 2</th>';
            echo '</tr>';
            foreach ($planes as $plan) {
                echo ('<tr data-id-plan ="' . $plan['idPlan'] . '">');
                echo('<td>' . $plan['grupo'] . '</td>');
                echo('<td>' . $plan['fecha'] . '</td>');
                echo('<td>' . $plan['tutor'] . '</td>');                
                echo('<td>' . $plan['tutor2'] . '</td>');
                echo('</tr>');
            }
        }elseif ($_SESSION['tipo_usuario'] == "crdinst") {
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha</th>';
            echo '<th>Tutor 1</th>';
            echo '<th>Tutor 2</th>';
            echo '</tr>';
            foreach ($planes as $plan) {
                echo ('<tr data-id-plan ="' . $plan['idPlan'] . '">');
                echo('<td>' . $plan['grupo'] . '</td>');
                echo('<td>' . $plan['fecha'] . '</td>');
                echo('<td>' . $plan['tutor1'] . '</td>');                
                echo('<td>' . $plan['tutor2'] . '</td>');
                echo('</tr>');
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
                    url: "getConsultarPlanAccionTutorial.php",
                    data: {idPlan: idPlan}
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
