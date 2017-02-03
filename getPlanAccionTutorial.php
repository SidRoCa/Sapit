<div>
    <?php
    require "conexion.php";
    $conn = new Connection();

    date_default_timezone_set('America/Denver');
    $idGrupo = intval($_POST['idGrupo']);
    ?>
    <p>PLAN DE ACCIÓN TUTORIAL</p>
    <table>
        <tr>
            <td>DATOS GENERALES</td>
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
            <td>UNIDAD ACADÉMICA</td>
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
                $periodo = $conn->getPeriodo($idGrupo);
                echo ($periodo);
                ?>
            </td>
        </tr>
        <tr>
                <th>PROBLEMÁTICAS IDENTIFICADAS</th> 
        </tr>
        <table id="tblProblematicas">
            
            <tr id="headerTblProb"z>
                <th>Problemática</th>
                <th>Valor asignado</th>
                <th>Objetivos</th>
                <th>Acciones</th>
            </tr>
        </table>
        <tr>
            <td><input id="problematica" type="text"required></td>
            <td><input id="valor" type="text" required></td>
            <td><input id="objetivos" type="text" required></td>
            <td><input id="acciones" type="text" required></td>
        </tr>
        <td><div>
                <button onclick="clicAgregarProblematica()">agregar</button>
                <button onclick="clicBorrarProblematica()">borrar</button>
            </div></td>
        </tr>
        </tr>

    </table>
    <p>CALENDARIZACIÓN</p>
    <table id="tablaDatos">
        <tr id="headerTablaDatos">

            <?php
            if ($periodo = 'ene-jun') {
                ?>
                <th>Actividades</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>    
                <?php
            } else {
                ?>
                <th>Actividades</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <?php
            }
            ?>


        </tr>
    </table>
    <table>
        <tr>
            <td><input id="actividad" type="text" ></td>
            <td><input id="mes1" type="text"></td>
            <td><input id="mes2" type="text"></td>
            <td><input id="mes3" type="text"></td>
            <td><input id="mes4" type="text"></td>
            <td><input id="mes5" type="text"></td>
            <td><input id="mes6" type="text"></td>
        </tr>
    </table>
    <button onclick="clicAgregar()">agregar</button>
    <button onclick="clicBorrar()">borrar</button>
    <p>Evaluación:<textarea id="evaluacion"></textarea></p>
    <div>
        <button onclick="guardar(<?php echo($idGrupo) ?>)">Generar plan de acción tutorial</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>
<script>
    function clicAgregar() {
        if ($("#actividad").val() !== "") {

            $("#tablaDatos").html($("#tablaDatos").html() + '<tr><td>' + $("#actividad").val() + '</td><td>' + $("#mes1").val() + '</td><td>' + $("#mes2").val() + '</td><td>' + $("#mes3").val() + '</td><td>' + $("#mes4").val() + '</td><td>' + $("#mes5").val() + '</td><td>' + $("#mes6").val() + '</td></tr>');
            $("#actividad").val("");
            $("#mes1").val("");
            $("#mes2").val("");
            $("#mes3").val("");
            $("#mes4").val("");
            $("#mes5").val("");
            $("#mes6").val("");

        } else {
            alert('Debe agregar una actividad');
        }
    }
    function clicAgregarProblematica() {
//       if ($("#problematica").val() !== "" || $("#valor").val() !== "" || $("#objetivos").val() !== "" || $("#acciones").val() !== "") {

        $("#tblProblematicas").html($("#tblProblematicas").html() + '<tr><td>' + $("#problematica").val() + '</td><td>' + $("#valor").val() + '</td><td>' + $("#objetivos").val() + '</td><td>' + $("#acciones").val() + '</td></tr>');
        $("#problematica").val("");
        $("#valor").val("");
        $("#objetivos").val("");
        $("#acciones").val("");

//        } else {
//            alert('Debe completar los campos');
//        }
    }
    function clicBorrar() {
        if ($("#tablaDatos tr:last").attr("id") === "headerTablaDatos") {
            alert('No hay elementos que borrar');
        } else {
            $("#tablaDatos tr:last").remove();
        }
    }
    function clicBorrarProblematica() {
        if ($("#tblProblematicas tr:last").attr("id") === "headerTblProb") {
            alert('No hay elementos que borrar');
        } else {
            $("#tblProblematicas tr:last").remove();
        }
    }
    function cancelar() {
        $("#planAccionTutorial").show();
        $("#mainContenido").hide();
    }

    function guardar(idGrupo) {
        if ($("#fecha").val() !== "") {
            if ($("#semestre").val() !== "") {
                if ($("#tblProblematicas tr:last").attr("id") !== "headerTblProb") {
                    if ($("#tablaDatos tr:last").attr("id") !== "headerTablaDatos") {

                        var arregloProb = '';
                        var aux = '';
                        var intaux = 1;
                        var intauxx = 1;
                        $("#tblProblematicas tr").each(function (fila) {
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
                                    arregloProb = arregloProb + aux;
                                    aux = '';
                                    intauxx = intauxx + 1;
                                } else {
                                    arregloProb = arregloProb + '|';
                                    $(this).children("td").each(function (columna) {
                                        if (intaux === 1) {
                                            aux = aux + $(this).text();
                                            intaux = intaux + 1;
                                        } else {
                                            aux = aux + '^' + $(this).text();
                                            intaux = intaux + 1;
                                        }
                                    });
                                    arregloProb = arregloProb + aux;
                                    aux = '';
                                    intauxx = intauxx + 1;
                                }
                                intaux = 1;
                            }
                        });
                        
                        
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
                            url: "guardarPlanAccionTutorial.php",
                            data: {idGrupo: idGrupo, fecha: $("#fecha").val(), arregloProb: arregloProb ,  arreglo: arreglo,  idCarrera: $("#selectCarrera").val(), idDpto: $("#selectDpto").val(), evaluacion: $("#evaluacion").val(), semestre: '<?php echo($periodo) ?>'}
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
                        alert('Debe asignar calendarización');
                    }
                } else {
                    alert('Debe asignar una problemática');
                }
            } else {
                alert('Debe asignar un semestre');
            }
        } else {
            alert('Debe seleccionar una fecha');
        }
    }


</script>