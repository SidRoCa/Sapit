<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    $carreras = $conn->getListaCarreras();
    ?>
    <table>
        <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR INSTITUCIONAL DE TUTORÍA</td>
        </tr>
        <tr>
            <td>Instituto Tecnológico de Parral</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR INSTITUCIONAL DE TUTORÍAS</strong> <input type="text" id="nombreCordinadorInstitucional" value="<?php echo($_SESSION["nombre_usuario"]); ?>">
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <td>Matrícula del Instituto Tecnológico Actual: <input type="text" id="matricula"></td>
            <td></td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO</td>
            <td>Cantidad de Tutores</td>
            <td>Tutoría Grupal</td>
            <td>Tutoría Individual</td>
            <td>Estudiantes Canalizados en el semestre</td>
            <td>Área canalizada</td>
            <td>Matrícula</td>
        </tr>
    </table>
    <table id="tablaDatos">
        <?php
        foreach ($carreras as $carrera) {
            echo ('<tr>');
            echo ('<td> <input value = "' . $carrera['nombre'] . '" > </td>');
            $grupos = $conn->getListagruposPorCarrera($carrera['id']);
            $listaTutores = array();

            foreach ($grupos as $grupo) {
                if ($grupo['idTutor1'] != null) {
                    if (count($listaTutores) > 0) {
                        $existe = false;
                        foreach ($listaTutores as $tutor) {
                            if ($tutor['id'] == $grupo['idTutor1']) {
                                $existe = true;
                            }
                        }
                        if (!$existe) {
                            $res = $conn->getTutorPorId($grupo['idTutor1']);
                            array_push($listaTutores, $res);
                        }
                    } else {
                        $res = $conn->getTutorPorId($grupo['idTutor1']);
                        array_push($listaTutores, $res);
                    }
                } else {
                    if (count($listaTutores) > 0) {
                        $existe = false;
                        foreach ($listaTutores as $tutor) {
                            if ($tutor['id'] == $grupo['idTutor2']) {
                                $existe = true;
                            }
                        }
                        if (!existe) {
                            $res = $conn->getTutorPorId($Grupo['idTutor2']);
                            array_push($listaTutores, $res);
                        }
                    } else {
                        $res = $conn->getTutorPorId($Grupo['idTutor2']);
                        array_push($listaTutores, $res);
                    }
                }
            }

            echo('<td> <input value = "' . count($listaTutores) . '"></td>');
            $cantTutoriasGrupales = 0;

            foreach ($grupos as $grupo) {
                $res = $conn->getCantTutoriasGrupalesPorGrupo($grupo['id']);

                $cantTutoriasGrupales = $cantTutoriasGrupales + $res;
            }

            echo('<td> <input value = "' . $cantTutoriasGrupales . '"></td>');

            $cantTutoriasIndividuales = 0;
            foreach ($listaTutores as $tutor) {
                $cant = $conn->getCantTutoriasIndividualesPorTutor($tutor['id']);
                $cantTutoriasIndividuales = $cantTutoriasIndividuales + $cant;
            }
            echo('<td><input value= "' . $cantTutoriasIndividuales . '"></td>');
            echo('<td><input></td>');
            echo('<td><input></td>');
            echo('<td><input></td>');
            echo ('</tr>');
        }
        ?>
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
        if ($("#fecha").val() != "" || $("#nombreCordinadorInstitucional").val() != "" || $("#matricula").val() != "") {

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



                            //aux = aux + $(this).parent().attr("data-id-tutor");
                            aux = aux + $(this).children("input").val();
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
                            aux = aux + $(this).children("input").val();
                            //aux = aux + $(this).parent().attr("data-id-tutor");;

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
                url: "guardarReporteSemestralCoordinadorInstitucional.php",
                data: {fecha: $("#fecha").val(), nombre: $("#nombreCordinadorInstitucional").val(),
                    matricula: $("#matricula").val(), tabla: arreglo}
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
            alert('Debe completar todos los campos');
        }
    }


</script>
