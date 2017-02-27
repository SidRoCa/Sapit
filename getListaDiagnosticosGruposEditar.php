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
        $diagnosticos = $conn->getListaDiagnosticosGruposPorDepartamento($idDepartamento);
    }elseif ($tipoUsuario == "crdinst") {
        $diagnosticos = $conn->getListaDiagnosticosGrupos();
    }    
    
    ?>
    <h2>Lista de diagnósticos grupales de departamento</h2>
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
            if($tipoUsuario == "crddpt"){
                echo('<td>' . $diagnostico['tutor'] . '</td>');
            }elseif ($tipoUsuario == "crdinst") {
                echo('<td>' . $diagnostico['tutor1'] . '</td>');
            }
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
                $.ajax({
                    method: "POST",
                    url: "getEditarDiagnosticoGrupal.php",
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
