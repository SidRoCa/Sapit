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
    $reporteSemestral = $conn->getReporteSemestralCoordinadorInstitucionalPorId($idReporte);
    ?>
    <h2>Reporte Semestral del coordinador institucional de tutoría</h2>
    <h3>Instituto Tecnológico de Parral</h3>
    <label>
        <b>
            Nombre del coordinador institucional de tutorías
        </b>
    </label><br>
    <input type = "text" value = "<?php echo $reporteSemestral['coordinador'];?>" readonly><br>
    <label>
        Fecha: 
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['fecha']?>" readonly><br>
    <label>
        Matrícula del Instituto Teconlógico Actual: *
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['matricula']?>" id = "matriculaInstituto">
    <table id = "tabla">
        <tr>
            <th>
                Programa educativo
            </th>
            <th>
                Cantidad de tutores
            </th>
            <th>
                Tutoría grupal
            </th>
            <th>
                Tutoría individual
            </th>
            <th>
                Estudiantes canalizados en el semestre
            </th>
            <th>
                Área canalizada
            </th>
            <th>
                Matrícula
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
                echo '<td>'.$row['programaEducativo'].'</td>';
                echo '<td>'.$row['cantidadTutores'].'</td>';
                echo '<td>'.$row['tutoriaGrupal'].'</td>';
                echo '<td>'.$row['tutoriaIndividual'].'</td>';
                echo '<td>'.$row['estudiantesCanalizados'].'</td>';
                echo '<td>'.$row['areaCanalizada'].'</td>';
                echo '<td>'.$row['matricula'].'</td>';
                echo '<td><button class="editar">Editar</button></td>';
                echo '</tr>';
                $cont++;
            }
        ?>
    </table>
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
            Editar un elemento
        </h3>
        <label>
            Programa educativo
        </label>
        <input type = "text" id = "programaEducativo" readonly><br>
        <label>
            Cantidad de tutores
        </label>
        <input type = "text" id = "cantidadTutores" readonly><br>
        <label>
            Tutoría grupal
        </label>
        <input type = "text" id = "tutoriaGrupal"><br>
        <label>
            Tutoría individual
        </label>
        <input type = "text" id = "tutoriaIndividual"><br>
        <label>
            Estudiantes canalizados
        </label>
        <input type = "text" id = "estudiantesCanalizados"><br>
        <label>
            Área canalizada
        </label>
        <input type = "text" id = "areaCanalizada"><br>
        <label>
            Matrícula
        </label>
        <input type = "text" id = "matricula"><br>
        <button id = "aceptarEditar">
            Guardar cambios
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
    var det = <?php echo json_encode($det)?>;
    var idDetEditar;
    var detEditar;
    $('#aceptar').on('click', function(){
        var matricula = $('#matriculaInstituto');
        if(!matricula.val()){
            window.alert('Todos los campos con * son obligatorios');
        }else{
            $('#opcionesGenerales').hide();
            $('#estado').show();
            $.ajax({
                method: "POST",
                url: "Conexiones/ReportesSemestralesCoordinadorInstitucional/editarReporteSemestralCoordinadorInstitucional.php",
                data: {idReporte: <?php echo $idReporte;?>, det: det, matriculaInstituto: matricula.val()}
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

    $('#tabla').on('click','.editar',function(){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idDetEditar = parseInt(idString);
        detEditar = det[idDetEditar];
        editarDet();
    });

    function editarDet(){
        $('#opcionesPrincipales').hide();
        $('#formEditarDet').show();
        $('#programaEducativo').val(detEditar['programaEducativo']);
        $('#cantidadTutores').val(detEditar['cantidadTutores']);
        $('#tutoriaGrupal').val(detEditar['tutoriaGrupal']);
        $('#tutoriaIndividual').val(detEditar['tutoriaIndividual']);
        $('#estudiantesCanalizados').val(detEditar['estudiantesCanalizados']);
        $('#areaCanalizada').val(detEditar['areaCanalizada']);
        $('#matricula').val(detEditar['matricula']);
        $('#tutoriaGrupal').focus();
    }

    $('#cancelarEditar').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formEditarDet').hide();
        limpiarFormEditarDet();
    });

    function limpiarFormEditarDet(){
        $('#programaEducativo').val('');
        $('#cantidadTutores').val('');
        $('#tutoriaGrupal').val('');
        $('#tutoriaIndividual').val('');
        $('#estudiantesCanalizados').val('');
        $('#areaCanalizada').val('');
        $('#matricula').val('');
    }

    $('#aceptarEditar').on('click', function(){
        var tutoriaGrupal = $('#tutoriaGrupal');
        var tutoriaIndividual = $('#tutoriaIndividual');
        var estudiantesCanalizados = $('#estudiantesCanalizados');
        var areaCanalizada = $('#areaCanalizada');
        var matricula = $('#matricula');
        if(!tutoriaGrupal.val() || !tutoriaIndividual.val() || !estudiantesCanalizados.val() || !areaCanalizada.val()|| !matricula.val()){
            window.alert('Debes llenar todos los campos para continuar');
        }else{
            det[idDetEditar]['tutoriaGrupal'] = tutoriaGrupal.val();
            det[idDetEditar]['tutoriaIndividual'] = tutoriaIndividual.val();
            det[idDetEditar]['estudiantesCanalizados'] = estudiantesCanalizados.val();
            det[idDetEditar]['areaCanalizada'] = areaCanalizada.val();
            det[idDetEditar]['matricula'] = matricula.val();
            actualizarTabla();
            $('#opcionesPrincipales').show();
            $('#formEditarDet').hide();
            limpiarFormEditarDet();
        }
    });

    function actualizarTabla(){
        var tabla = $('#tabla');
        var cabecera = '<tr>';
        cabecera += '<th>Programa educativo</th>';
        cabecera += '<th>Cantidad de tutores</th>';
        cabecera += '<th>Tutoría grupal</th>';
        cabecera += '<th>Tutoría individual</th>';
        cabecera += '<th>Estudiantes canalizados en el semestre</th>';
        cabecera += '<th>Área canalizada</th>';
        cabecera += '<th>Matrícula</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i < det.length; i++){
            var aux = det[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+aux['programaEducativo']+'</td>';
            row += '<td>'+aux['cantidadTutores']+'</td>';
            row += '<td>'+aux['tutoriaGrupal']+'</td>';
            row += '<td>'+aux['tutoriaIndividual']+'</td>';
            row += '<td>'+aux['estudiantesCanalizados']+'</td>';
            row += '<td>'+aux['areaCanalizada']+'</td>';
            row += '<td>'+aux['matricula']+'</td>';
            row += '<td><button class="editar">Editar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaReportesSemestralesCoordinadorInstitucionalEditar.php"
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
