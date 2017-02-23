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
    $idReporte = $_POST['idReporte'];
    $reporteSemestral = $conn->getReporteSemestralCoordinadorPorId($idReporte);
    ?>
    <h2>Reporte Semestral del coordinador departamental de tutorías</h2>
    <label>
        <b>
            Nombre del coordinador de tutorías del departamento académico
        </b>
    </label><br>
    <input type = "text" value = "<?php echo $reporteSemestral['coordinador'];?>" readonly><br>
    <label>
        Fecha : 
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['fecha'];?>" readonly><br>
    <label>
        Programa educativo: *
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['programaEducativo'];?>" id = "programaEducativo"><br>
    <label>
        Departamento académico: *
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['departamentoAcademico'];?>" id = "departamentoAcademico"><br>
    <table id = "tabla">
        <tr>
            <th>
                Lista de tutores
            </th>
            <th>
                Grupo
            </th>
            <th>
                Tutoría grupal
            </th>
            <th>
                Tutoría individual
            </th>
            <th>
                Estudiantes canalizados
            </th>
            <th>
                Área canalizada
            </th>
            <th>
                Editar
            </th>
        </tr>
        <?php 
            $det = $reporteSemestral[0];
            $cont = 0;
            foreach ($det as $row) {
                echo '<tr data-indice-tabla = "'.$cont.'">';
                echo '<td>'.$row['tutor'].'</td>';
                echo '<td>'.$row['grupo'].'</td>';
                echo '<td>'.$row['tutoriasGrupales'].'</td>';
                echo '<td>'.$row['tutoriasIndividuales'].'</td>';
                echo '<td>'.$row['estudiantesCanalizados'].'</td>';
                echo '<td>'.$row['areaCanalizada'].'</td>';
                echo '<td><button class="editar">Editar</button></td>';
                echo '</tr>';
                $cont++;
            }
        ?>
    </table>
    <textarea id = "observaciones"><?php echo $reporteSemestral['observaciones'];?></textarea>
    <div id = "opcionesPrincipales">
        <button id = "aceptar">
            Guardar
        </button>
        <button id = "cancelar">
            Cancelar
        </button>
    </div>
    <div id = "formEditarDet" hidden>
        <h3>
            Editar elemento
        </h3>
        <label>
            Tutor :
        </label>   
        <input type = "text" id = "tutor" readonly><br>
        <label>
            Grupo :
        </label> 
        <input type = "text" id = "grupo" readonly><br>
        <label>
            Tutorías grupales :
        </label>
        <input type = "text" id = "tutoriasGrupales"><br>
        <label>
            Tutorías individuales :
        </label>
        <input type = "text" id = "tutoriasIndividuales"><br>
        <label>
            Estudiantes canalizados :
        </label>
        <input type = "text" id = "estudiantesCanalizados"><br>
        <label>
            Área canalizada
        </label>
        <input type = "text" id = "areaCanalizada"><br>
        <button id ="aceptarEditar">
            Guardar edición
        </button>
        <button id = "cancelarEditar">
            Cancelar
        </button>
    </div>
    <p id = "estado" hidden>
        Cargando...
    </p>
</div>
<script>
    var det = <?php echo json_encode($det);?>;
    var idDetEditar;
    var detEditar;
    $('#aceptar').on('click', function(){
        var programaEducativo = $('#programaEducativo');
        var departamentoAcademico = $('#departamentoAcademico');
        var observaciones = $('#observaciones');
        if(!programaEducativo.val() || !departamentoAcademico.val()){
            window.alert('Todos los campos con * son obligatorios');
        }else{
            $('#opcionesGenerales').hide();
            $('#estado').show();
            $.ajax({
                method: "POST",
                url: "Conexiones/ReportesSemestralesCoordinador/editarReporteSemestralCoordinador.php",
                data: {idReporte: <?php echo $idReporte;?>, det: det, programaEducativo: programaEducativo.val(), 
                    departamentoAcademico: departamentoAcademico.val(), observaciones: observaciones.val()}
            }).done(function (msg) {
                if(msg.localeCompare('ok') == 0){
                    irALista();
                }else{
                    window.alert('Ocurrió un error, inténtalo de nuevo');
                     $('#opcionesGenerales').show();
                     $('#estado').hide();
                }
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    window.alert("El servidor no responde, inténtalo de nuevo más tarde");
                } else {
                    window.alert('Ocurrió un error al editar los datos');
                }
                $('#opcionesGenerales').show();
                $('#estado').hide();
            });
        }
        
    });

    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#tabla').on('click', '.editar', function(){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idDetEditar = parseInt(idString);
        detEditar = det[idDetEditar];
        editarDet();
    });

    function editarDet(){
        $('#opcionesPrincipales').hide();
        $('#formEditarDet').show();
        $('#tutor').val(detEditar['tutor']);
        $('#grupo').val(detEditar['grupo']);
        $('#tutoriasGrupales').val(detEditar['tutoriasGrupales']);
        $('#tutoriasIndividuales').val(detEditar['tutoriasIndividuales']);
        $('#estudiantesCanalizados').val(detEditar['estudiantesCanalizados']);
        $('#areaCanalizada').val(detEditar['areaCanalizada']);
        $('#tutoriasGrupales').focus();
    }

    $('#cancelarEditar').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formEditarDet').hide();
        limpiarFormEditarDet();
    });

    function limpiarFormEditarDet(){
        $('#tutor').val('');
        $('#grupo').val('');
        $('#tutoriasGrupales').val('');
        $('#tutoriasIndividuales').val('');
        $('#estudiantesCanalizados').val('');
        $('#areaCanalizada').val('');
    }

    $('#aceptarEditar').on('click', function(){
        var tutoriasGrupales = $('#tutoriasGrupales');
        var tutoriasIndividuales = $('#tutoriasIndividuales');
        var estudiantesCanalizados = $('#estudiantesCanalizados');
        var areaCanalizada = $('#areaCanalizada');
        if(!tutoriasGrupales.val() || !tutoriasIndividuales.val() || !estudiantesCanalizados.val() || !areaCanalizada.val()){
            window.alert('Debes llenar todos los campos para continuar');
        }else{
            det[idDetEditar]['tutoriasGrupales'] = tutoriasGrupales.val();
            det[idDetEditar]['tutoriasIndividuales'] = tutoriasIndividuales.val();
            det[idDetEditar]['estudiantesCanalizados'] = estudiantesCanalizados.val();
            det[idDetEditar]['areaCanalizada'] = areaCanalizada.val();
            $('#opcionesPrincipales').show();
            $('#formEditarDet').hide();
            limpiarFormEditarDet();     
            actualizarTabla();
        }
    });

    function actualizarTabla(){
        var tabla = $('#tabla');
        var cabecera = '<tr>';
        cabecera += '<th>Lista de tutores</th>';
        cabecera += '<th>Grupo</th>';
        cabecera += '<th>Tutoría grupal</th>';
        cabecera += '<th>Tutoría individual</th>';
        cabecera += '<th>Estudiantes canalizados</th>';
        cabecera += '<th>Area canalizada</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i<det.length; i++){
            var aux = det[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+aux['tutor']+'</td>';
            row += '<td>'+aux['grupo']+'</td>';
            row += '<td>'+aux['tutoriasGrupales']+'</td>';
            row += '<td>'+aux['tutoriasIndividuales']+'</td>';
            row += '<td>'+aux['estudiantesCanalizados']+'</td>';
            row += '<td>'+aux['areaCanalizada']+'</td>';
            row += '<td><button class="editar">Editar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaReportesSemestralCoordinadorEditar.php"
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
    }
</script>
