<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();
    date_default_timezone_set('America/Denver');
    $idGrupo = intval($_POST['idGrupo']);
    ?>
    <table>
        <tr>
            <td>REPORTE SEMESTRAL DEL TUTOR</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL TUTOR: <?php echo($_SESSION['nombre_usuario']); ?> </strong> 
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" >
            </td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO: PROGRAMA INSTITUCIONAL DE TUTORÍAS</td>
            <td>
                <?php
                $res = $conn->getGrupo($idGrupo);
                echo('<strong>Grupo:</strong>' . $res);
                ?>                 
            </td>

        </tr>
        <tr>
            <td>LISTA DE ESTUDIANTES</td>
            <td>TUTORÍA GRUPAL</td>
            <td>TUTORÍA INDIVIDUAL</td>
            <td>ESTUDIANTES CANALIZADOS EN EL SEMESTRE</td>
            <td>AREA CANALIZADA</td>
        </tr>
    </table>
    <table id="tablaDatos">
        <?php
        $res = $conn->getAlumnosGrupo($idGrupo);
        $cnt = 1;
        $listaIdAlumnos = array();
        foreach ($res as $alumno) {

            array_push($listaIdAlumnos, $alumno['id']);
            echo ('<tr>');
            echo ('<td>' . $cnt . '. ' . $alumno['nombres'] . ' ' . $alumno['ap_paterno'] . ' ' . $alumno['ap_materno'] . '</td>');

            echo ('<td><input type = "text" value="X"></td>');
            $isIndiv = $conn->hasTutoIndiv($alumno['id']);

            if ($isIndiv) {
                echo ('<td><input type = "text" value = "X"></td>');
            } else {
                echo ('<td><input type = "text"></td>');
            }
            echo('<td><input type="text"></td>');
            echo('<td><input type="text"></td>');
            echo ('</tr>');
            $cnt = $cnt + 1;
        }
        ?>
    </table>
    <table>
        <tr>
            <td>
                <strong>Instructivo de llenado:</strong>
                Anote los datos correspondientes en los apartados del encabezado <br>
                En el apartado de Observaciones anotar: <br>
                •	Anote las 10 actividades adicionales más importantes realizadas en el semestre <br>
                •	Anotar las acciones de mayor impacto para alcanzar la competencia de la asignatura <br>
                Este reporte deberá ser llenado por el Coordinador de Tutoría del Departamento Académico <br>
                Deberá ser entregada al Jefe de Departamento Académico con copia para el Coordinador Institucional de Tutoría 

            </td>
        </tr>
        <tr>
            <td>Observaciones: <input type = "text" id="observaciones"></td>
        </tr>
    </table>
    <div>
        <button onclick="guardar()">Guardar</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>

<script>

  

    function cancelar() {
        $("#reporteSemestral").show();
        $("#mainContenido").hide();
    }


    
    function guardar(idGrupo) {
    
        if ($("#fecha").val() != "") {
            if ($("#selAlumno").val() != -1) {

                var arreglo = '';
                var aux = '';
                var intaux = 1;
                var intauxx = 1;
                var cntd = 0;
                
                var listaIdAlumnosAux = <?php echo(json_encode($listaIdAlumnos)); ?>;
                
                $("#tablaDatos tr").each(function (fila) {

                    if (intauxx == 1) {
                        $(this).children("td").each(function (columna) {
                            if (intaux === 1) {
                                //aquí va el id de alumno en vez de lo que dice.
                                
                                aux = aux +  listaIdAlumnosAux[cntd];
                                //aux = aux + $(this).text();
                                cntd = cntd +1;
                                intaux = intaux + 1;
                                
                            } else {
                                aux = aux + '^' + $(this).children("input").val();
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
                                //aquí va el id alumno en vez de lo que dice
                                aux = aux + listaIdAlumnosAux[cntd];
                                intaux = intaux + 1;
                                cntd = cntd +1
                            } else {
                                aux = aux + '^' + $(this).children("input").val();
                                intaux = intaux + 1;
                            }
                            
                        });
                        arreglo = arreglo + aux;
                        aux = '';
                        intauxx = intauxx + 1;
                    }
                    intaux = 1;
                    

                });

                var lstIdAlumnos = '';


                

                $.ajax({
                    method: "POST",
                    url: "guardarReporteSemestral.php",
                    data: {idTutor: <?php echo($_SESSION["id_usuario"]); ?>, fecha: $("#fecha").val(), idGrupo: <?php echo($idGrupo); ?>, tabla: arreglo, listaIdAlumnos: lstIdAlumnos, observaciones: $("#observaciones").val()}
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
                alert('Debe seleccionar un alumno');
            }
        } else {
            alert('Debe seleccionar una fecha');
        }
    }


</script>