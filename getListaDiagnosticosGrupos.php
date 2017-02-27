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
    if($_SESSION['tipo_usuario']=="tutor"){
        $idTutor = $_POST['idTutor'];
        $diagnosticos = $conn->getListaDiagnosticosGruposPorTutor($idTutor);
    }elseif($_SESSION['tipo_usuario']=="crddpt"){
        $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
        $diagnosticos = $conn->getListaDiagnosticosGruposPorDepartamento($idDepartamento);
    }elseif ($_SESSION['tipo_usuario'] == "crdinst") {
        $diagnosticos = $conn->getListaDiagnosticosGrupos();
    }
    
    ?>
    <h2>Lista de diagnósticos grupales</h2>
    <table id="tablaDatos">
        <?php
        if($_SESSION['tipo_usuario']=="tutor"){
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha diagnóstico</th>';
            echo '<th>Semestre</th>';
            echo '</tr>';
            foreach ($diagnosticos as $diagnostico) {
                echo ('<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">');
                echo('<td>' . $diagnostico['nombreGrupo'] . '</td>');
                echo('<td>' . $diagnostico['fechaDiagnostico'] . '</td>');
                echo('<td>' . $diagnostico['semestreDiagnostico'] . '</td>');
                echo('</tr>');
            }
        }elseif ($_SESSION['tipo_usuario'] == "crddpt") {
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha diagnóstico</th>';
            echo '<th>Semestre</th>';
            echo '<th>Tutor 1</th>';
            echo '<th>Tutor 2</th>';
            echo '</tr>';
            foreach ($diagnosticos as $diagnostico) {
                echo ('<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">');
                echo('<td>' . $diagnostico['grupo'] . '</td>');
                echo('<td>' . $diagnostico['fecha'] . '</td>');
                echo('<td>' . $diagnostico['semestre'] . '</td>');
                echo('<td>' . $diagnostico['tutor'] . '</td>');
                echo('<td>' . $diagnostico['tutor2'] . '</td>');
                echo('</tr>');
            }
        }elseif ($_SESSION['tipo_usuario'] == "crdinst") {
            echo '<tr>';
            echo '<th>Grupo</th>';
            echo '<th>Fecha diagnóstico</th>';
            echo '<th>Semestre</th>';
            echo '<th>Tutor 1</th>';
            echo '<th>Tutor 2</th>';
            echo '</tr>';
            foreach ($diagnosticos as $diagnostico) {
                echo ('<tr data-id-diagnostico ="' . $diagnostico['idDiagnostico'] . '">');
                echo('<td>' . $diagnostico['grupo'] . '</td>');
                echo('<td>' . $diagnostico['fecha'] . '</td>');
                echo('<td>' . $diagnostico['semestre'] . '</td>');
                echo('<td>' . $diagnostico['tutor1'] . '</td>');
                echo('<td>' . $diagnostico['tutor2'] . '</td>');
                echo('</tr>');
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
                    url: "getConsultarDiagnosticoGrupal.php",
                    data: {idDiagnostico: idDiagnostico}
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
