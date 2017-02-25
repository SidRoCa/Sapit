<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    $idGrupo = intval($_POST['idGrupo']);
    $agregar = $conn->checkDiagnosticoGrupoDuplicado($idGrupo);
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    ?>
    
    
    <p>DIAGNÓSTICO DEL GRUPO</p>
    <table>
        <tr>
            <th> DATOS GENERALES </th>
        </tr>
        <tr>
            <td>
                <strong>Nombre del(los) tutores:</strong> <?php
                $res = $conn->getTutoresGrupo($idGrupo);
                foreach ($res as $tutor) {
                    echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
                }
                ?>
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <th> UNIDAD ACADÉMICA </th>
        </tr>
        <tr>
            <td><?php
                $res = $conn->getGrupoCarreraDpto($idGrupo);
                echo('<strong>Grupo:</strong>' . $res['nombre']);
                $idCarrera = $res['idcarr'];
                $idDpto = $res['iddpto'];
                ?>                 

                <br><strong>Carrera:</strong> 
                <select id="selectCarrera">
                    <?php
                    $res = $conn->getCarreras();
                    foreach ($res as $carrera) {
                        if ($carrera['id'] == $idCarrera) {
                            echo ('<option value = ' . $carrera['id'] . ' selected = "selected">' . $carrera['nombre'] . '</option>');
                        } else {
                            echo ('<option value = ' . $carrera['id'] . '>' . $carrera['nombre'] . '</option>');
                        }
                    }
                    ?>
                </select>
                <br><strong>Departamento:</strong> 
                <select id="selectDpto">
                    <?php
                    $res = $conn->getDptos();
                    foreach ($res as $dpto) {
                        if ($dpto['id'] == $idDpto) {
                            echo ('<option value = ' . $dpto['id'] . ' selected = "selected">' . $dpto['nombre'] . '</option>');
                        } else {
                            echo ('<option value = ' . $dpto['id'] . '>' . $dpto['nombre'] . '</option>');
                        }
                    }
                    ?>
                </select>

            </td>
            <td>
                <strong>Número de alumnos:</strong>
                <?php
                $res = $conn->getNumeroAlumnos($idGrupo);

                echo($res);
                ?>
            </td>
            <td>
                <strong>Semestre:</strong> 
                <?php
                $res = $conn->getPeriodo($idGrupo);

                echo($res);
                ?>
            </td>
        </tr>

    </table>
    <table id="tablaDatos">
        <tr id="headerTablaDatos"><th>Fases de la tutoría</th>
            <th>Áreas de evaluación</th>
            <th>Instrumento</th>
            <th>Recolección y análisis de la información</th>
            <th>Hallazgos</th>
        </tr>

    </table>
    <table>
        <tr>
            <td><input id="fase" type="text"></td>
            <td><input id="area" type="text"></td>
            <td><input id="instrumento" type="text"></td>
            <td><input id="analisis" type="text"></td>
            <td><input id="hallazgos" type="text"></td>
        </tr>
    </table>
    <button onclick="clicAgregar()">agregar</button>
    <button onclick="clicBorrar()">borrar</button>
    <div>
        <button onclick="guardar(<?php echo($idGrupo) ?>)">Generar diagnóstico del Grupo</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>
<script>
    var agregar = <?php echo $agregar?>;
    function clicAgregar() {
        if ($("#fase").val() !== "") {
            if ($("#area").val() !== "") {
                if ($("#instrumento").val() !== "") {
                    if ($("#analisis").val() !== "") {
                        if ($("#hallazgos").val() !== "") {
                            $("#tablaDatos").html($("#tablaDatos").html() + '<tr><td>' + $("#fase").val() + '</td><td>' + $("#area").val() + '</td><td>' + $("#instrumento").val() + '</td><td>' + $("#analisis").val() + '</td><td>' + $("#hallazgos").val() + '</td></tr>');
                            $("#fase").val("");
                            $("#area").val("");
                            $("#instrumento").val("");
                            $("#analisis").val("");
                            $("#hallazgos").val("");
                        } else {
                            alert('Debe agregar hallazgos');
                        }
                    } else {
                        alert('Debe agregar recoleccion y análisis de la información');
                    }
                } else {
                    alert('Debe agregar un instrumento');
                }
            } else {
                alert('Debe agregar una área de evaluación');
            }
        } else {
            alert('Debe agregar una fase');
        }
    }
    function clicBorrar() {
        if ($("#tablaDatos tr:last").attr("id") === "headerTablaDatos") {
            alert('No hay elementos que borrar');
        } else {
            $("#tablaDatos tr:last").remove();
        }
    }
    function cancelar() {
        $("#diagnosticoGrupo").show();
        $("#mainContenido").hide();
    }
    function guardar(idGrupo) {
        if(agregar==0){
            if ($("#fecha").val() !== "") {
                if ($("#semestre").val() !== "") {
                    if ($("#tablaDatos tr:last").attr("id") !== "headerTablaDatos") {

                        var arreglo = '';
                        var aux = '';
                        var intaux = 1;
                        var intauxx = 1;
                        $("#tablaDatos tr").each(function (fila) {
                            if (fila !== 0) {
                                if (intauxx == 1) {
                                    $(this).children("td").each(function (columna) {
                                        if (intaux === 1) {
                                            aux = aux + $(this).text();
                                            intaux = intaux + 1;
                                        } else {
                                            aux = aux + '^' + $(this).text();
                                            intaux = intaux + 1;
                                        }
                                    });
                                    arreglo = arreglo + aux;
                                    aux = '';
                                    intauxx = intauxx + 1;
                                } else {
                                    arreglo = arreglo + '|';
                                    $(this).children("td").each(function (columna) {
                                        if (intaux === 1) {
                                            aux = aux + $(this).text();
                                            intaux = intaux + 1;
                                        } else {
                                            aux = aux + '^' + $(this).text();
                                            intaux = intaux + 1;
                                        }
                                    });
                                    arreglo = arreglo + aux;
                                    aux = '';
                                    intauxx = intauxx + 1;
                                }
                                intaux = 1;
                            }
                        });

                        $.ajax({
                            method: "POST",
                            url: "guardarDiagnosticoGrupo.php",
                            data: {idGrupo: idGrupo, fecha: $("#fecha").val(), idCarrera: $("#selectCarrera").val(), idDpto: $("#selectDpto").val(), semestre: $("#semestre").val(), arreglo: arreglo}
                        }).done(function (msg) {
                            $("#fichaAlumnosTutorados").hide();
                            $("#registroAsistenciaGrupal").hide();
                            $("#registroAsistenciaIndividual").hide();
                            $("#diagnosticoGrupo").hide();
                            $("#planAccionTutorial").hide();
                            $("#mainContenido").show();
                            $("#mainContenido").html(msg);
                        }).fail(function (jqXHR, textStatus) {
                            if (textStatus === 'timeout') {
                                $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                            } else {
                                $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                            }
                        });

                    } else {
                        alert('No hay elementos de la tabla que agregar');
                    }
                } else {
                    alert('Debe asignar un semestre');
                }
            } else {
                alert('Debe seleccionar una fecha');
            }
        }else{
            window.alert('Ya se registró un diagnóstico de este grupo con anterioridad y sólo puede existir uno por grupo');
        }
        
    }





</script>

