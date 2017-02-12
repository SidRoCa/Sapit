<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crddpt") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    ?>
    <table>
        <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR DEPARTAMENTAL DE TUTORÍAS</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR DE TUTORÍAS DEL DEPARTAMENTO ACADÉMICO:</strong> <input type="text" id="nombreCrdTutoDpto" value="<?php echo($_SESSION["nombre_usuario"]); ?>">
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO: <input type="text" id="programaEducativo"></td>
            <td>DEPARTAMENTO ACADEMICO: <input type="text" id="departamentoAcademico"> </td>
            <td>SEMESTRE: <input type="text" id="semestre"> </td>
        </tr>
        <tr>
            <td>LISTA DE TUTORES</td>
            <td>GRUPO</td>
            <td>TUTORÍA GRUPAL</td>
            <td>TUTORÍA INDIVIDUAL</td>
            <td>ESTUDIANTES CANALIZADOS EN EL SEMESTRE</td>
            <td>ÁREA CANALIZADA</td>
        </tr>
    </table>
    <table id="tablaDatos">
        <?php
        $idDpto = $conn->getIdDpto($_SESSION["id_usuario"]);
        $listaTutores = $conn->getTutoresDpto($idDpto);
        $cnt = 1;
        foreach ($listaTutores as $tutor) {
            echo ('<tr  data-id-tutor = "'.$tutor['id'].'">');
            echo ('<td> <input  type="text" value="' . $cnt . '. ' . $tutor['nombre'] . '"></td>');

            $grupoNombre = $conn->getGrupoTutor($tutor['id']);
            echo ('<td> <input type="text" value="' . $grupoNombre . '"></td>');

            $numeroEstudiantesGrupalTutor = $conn->getCantidadEstudiantesGrupalTutor($tutor['id']);
            echo ('<td> <input type="text" value="' . $numeroEstudiantesGrupalTutor . '"></td>');

            $numeroEstudiantesIndividualTutor = $conn->getCantidadEstudiantesIndividualTutor($tutor['id']);
            echo ('<td> <input type="text" value="' . $numeroEstudiantesIndividualTutor . '"></td>');



            echo ('<td> <input type="text"> </td>');
            echo ('<td> <input type="text"> </td>');

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
                •	Este reporte deberá ser llenado por el Coordinador de Tutoría del Departamento Académico <br>
                •	Deberá ser entregada al Jefe de Departamento Académico con copia para el Coordinador Institucional de Tutoría <br>
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

    function guardar() {
        if ($("#fecha").val() != "") {
            if ($("#selAlumno").val() != -1) {

                var arreglo = '';
                var aux = '';
                var intaux = 1;
                var intauxx = 1;
                var cntd = 0;

                

                $("#tablaDatos tr").each(function (fila) {
                    
                    if (intauxx == 1) {
                        $(this).children("td").each(function (columna) {
                            if (intaux === 1) {
                                //aquí va el id de alumno en vez de lo que dice.
                                
                                
                                
                                aux = aux + $(this).parent().attr("data-id-tutor");
                                //aux = aux + $(this).children("input").val();
                                cntd = cntd + 1;
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
                                //aux = aux + $(this).children("input").val();
                                aux = aux + $(this).parent().attr("data-id-tutor");;
                                
                                intaux = intaux + 1;
                                cntd = cntd + 1
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
                
                $.ajax({
                    method: "POST",
                    url: "guardarReporteSemestralCoordinadorDepartamental.php",
                    data: {fecha: $("#fecha").val(), nombreCrdTutoDpto: $("#nombreCrdTutoDpto").val(), programaEducativo: $("#programaEducativo").val(), departamentoAcademico: $("#departamentoAcademico").val(), idPeriodo: $("#semestre").val(), tabla: arreglo, observaciones: $("#observaciones").val()}
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
