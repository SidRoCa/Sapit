<div>
    <?php
    session_start();
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    ?>

    <p>PLANEACIÓN PARA DESARROLLAR EL DIAGNÓSTICO DEPARTAMENTAL</p>
    <p><strong>Nombre del Departamento:</strong> <?php
        $idDepartamento = $conn->getDptoUsuario($_SESSION["id_usuario"]);
        $dpto = $conn->getDpto($idDepartamento);
        echo ($dpto);
        ?>
        <strong>Fecha: </strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>"></p>

    <table id="tablaDatos">
        <tr id="headerTablaDatos">

            <th>Problema</th>
            <?php
            $res = $conn->getGruposDpto($idDepartamento);
            $listaIdGrupos = array();
            foreach ($res as $grupo) {
                echo ('<th>Grupo: ' . $grupo['nombre'] . ' </th>');
                array_push($listaIdGrupos, $grupo['id']);
            }
            ?>
            <th>Suma</th>
            <th>Orden</th>
        </tr>
        <tr>
            <?php
            //renglón
            foreach ($listaIdGrupos as $idGrupoAux) {
                $probs = $conn->getProblematicasGrupo($idGrupoAux);

                foreach ($probs as $pr) {
                    echo('<tr>');
                    echo ('<td> <input type="text" value="' . $pr['problematica'] . '"></td>');

                    //cantidad de texts / grupos
                    for ($i = 0; $i < sizeof($listaIdGrupos); $i++) {
                        if ($idGrupoAux == $listaIdGrupos[$i]) {
                            echo ('<td><input type="text" value = "' . $pr['valor'] . '"></td>');
                        } else {
                            echo ('<td><input type="text"></td>');
                        }
                    }
                    echo ('<td><input type="text"></td>');
                    echo ('<td><input type="text"></td>');
                    echo ('</tr>');
                }

                
            }
            ?>
        </tr>
    </table>

    <button onclick="clicAgregar()">Crear nueva fila</button>
    <button onclick="clicBorrar()">Borrar última fila</button>
    <div>
        <button onclick="guardar()">Generar planeación</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>
<script>

    function clicAgregar() {

//        var textTablaDatos = "<table id='tablaDatos'>";
//        if ($("#tablaDatos tr:last").attr("id") !== "headerTablaDatos") {
//            $("#tablaDatos tr").each(function (fila) {
//                if (fila !== 0) {
//                    textTablaDatos = textTablaDatos + "<tr>";
//                    $(this).children("td").each(function (columna) {
//
//                        textTablaDatos = textTablaDatos + "<td>" + $(this).value() + "</td>";
//
//                    });
//                    textTablaDatos = textTablaDatos + "</tr>";            
//
//                }
//            });
//            textTablaDatos = textTablaDatos + "</table>";            
//            alert (textTablaDatos);
//            $("#tablaDatos").html(textTablaDatos + '<tr><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td></tr>');
//        } else {
        $("#tablaDatos").html($("#tablaDatos").html() + '<tr><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td><td><input type="text"></td></tr>');
//        }




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
            var filaAux = 0;
            var columnaAux = 0;


            $("#tablaDatos tr").each(function (fila) {

                if (fila !== 0) {
                    if (intauxx == 1) {
                        $(this).children("td").each(function (columna) {
                            if (intaux === 1) {
                                aux = aux + $(this).find('input').val();

                                intaux = intaux + 1;


                            } else {

                                aux = aux + '^' + $(this).find('input').val();
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
                                aux = aux + $(this).find('input').val();
                                intaux = intaux + 1;
                            } else {
                                aux = aux + '^' + $(this).find('input').val();
                                intaux = intaux + 1;
                            }
                        });
                        arreglo = arreglo + aux;
                        aux = '';
                        intauxx = intauxx + 1;
                        columnaAux = columnaAux + 1;
                    }
                    intaux = 1;
                }
                filaAux = filaAux + 1;
            });

            var listaIdGrupos = '';
<?php
foreach ($listaIdGrupos as $idGrupo) {
    ?> listaIdGrupos = listaIdGrupos + '<?php echo($idGrupo); ?> ';
<?php }
?>




            $.ajax({
                method: "POST",
                url: "guardarPlaneacionDiagnosticoDepartamental.php",
                data: {nombreDpto: "<?php echo($dpto) ?>", idDpto: <?php echo($idDepartamento) ?>, fecha: $("#fecha").val(), listaIdGrupos: listaIdGrupos, arreglo: arreglo}
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

