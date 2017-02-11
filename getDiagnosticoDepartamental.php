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

    <p>DIAGNÓSTICO DEPARTAMENTAL</p>
    <table>
        <tr>
            <th> DATOS GENERALES </th>
        </tr>
        <tr>
            <td>
                <strong>Nombre del coordinador departamental: </strong> <input type="text" id="nombreCrdDpt" value="<?php
                echo($_SESSION['nombre_usuario']);
                ?> ">
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <th> UNIDAD ACADÉMICA </th>
        </tr>
        <tr>
            <td>
                <br><strong>Departamento: </strong> <?php
                $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
                $dpto = $conn->getDpto($idDepartamento);
                echo ($dpto);
                ?>
            </td> 
            <td>                
                <br><strong>Carreras: </strong>
                <input id="carreras" type="text" value="<?php
                $res = $conn->getCarrerasDpto($idDepartamento);
                foreach ($res as $carrera) {
                    echo ($carrera['nombre'] . ' ');
                }
                ?>">
            </td>    

            <td>
                <strong>Semestres: </strong>
                <input id="semestres" type="text" value="<?php
                $res = $conn->getSemestresDpto($idDepartamento);
                foreach ($res as $semestres) {
                    echo ($semestres['ident'] . ' ');
                }
                ?>">
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
        <button onclick="guardar()">Generar diagnóstico del Grupo</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>
<script>

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
        //$("#diagnosticoGrupo").show();
        $("#mainContenido").hide();
    }
    function guardar() {

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
                url: "guardarDiagnosticoDepartamental.php",
                data: {nombreCrdDpt: $("#nombreCrdDpt").val(), idDepartamento: <?php echo($idDepartamento) ?>, fecha: $("#fecha").val(), arreglo: arreglo}
            }).done(function (msg) {

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
            alert('Debe agregar elementos a la tabla');
        }

    }





</script>

