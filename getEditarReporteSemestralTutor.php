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
    $conn = new Connection();
    $idReporte = $_POST['idReporte'];
    $reporteSemestral = $conn->getReporteSemestralPorId($idReporte);
    ?>
    <h2>Reporte Semestral del tutor</h2>
    <label>
        Nombre del Tutor :
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['tutor']?>" readonly/> </br>
    <label>
        Fecha
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['fecha']?>" readonly/></br>
    <label>
        Grupo
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['grupo']?>" readonly/><br>
    <label>
        PROGRAMA EDUCATIVO: PROGRAMA INSTITUCIONAL DE TUTORÍAS
    </label></br>
    <table id = "tabla">
        <tr>
            <th>
                Estudiantes
            </th>
            <th>
                Tutoría grupal
            </th>
            <th>
                Tutoría individual
            </th>
            <th>
                Estudiante canalizado
            </th>
            <th>
                Área canalizada
            </th>
            <th>
                Editar
            </th>
        </tr>
        <?php 
            $detReporte = $reporteSemestral[0];
            $cont = 0;
            foreach ($detReporte as $det) {
                echo '<tr data-indice-tabla="'.$cont.'">';
                echo '<td>'.$det['alumno'].'</td>';
                echo '<td>'.$det['tutoriaGrupal'].'</td>';
                echo '<td>'.$det['tutoriaIndividual'].'</td>';
                echo '<td>'.$det['canalizado'].'</td>';
                echo '<td>'.$det['areaCanalizada'].'</td>';
                echo '<td><button class= "editar">Editar</button></td>';
                echo '</tr>';
                $cont++;
            }
        ?>
    </table>
    <label>
        Observaciones: 
    </label>
    <textarea id = "observaciones">
        <?php 
            echo $reporteSemestral['observaciones'];
        ?>
    </textarea>
    <div id = "opcionesPrincipales">
        <button id = "aceptar">
            Guardar cambios
        </button>
        <button id = "cancelar">
            Cancelar
        </button>
    </div>
    <div id = "formEditarDetalle" hidden>
        <h3>Editar</h3>
        <label id = "alumnoNombre">

        </label>
        <p>
            Indica con una X si el alumno recibió las siguientes tutorías:
        </p>
        <label>
            Tutoría grupal :
        </label>
        <input type="text" id = "tutoriaGrupal"><br>
        <label>
            Tutoría individual :
        </label>
        <input type = "text" id = "tutoriaIndividual"><br>
        <label>
            Canalizado :
        </label>
        <input type = "text" id = "canalizado"><br>
        <label>
            Área canalizada :
        </label>
        <input type = "text" id = "areaCanalizada"><br>
        <button id = "aceptarEditar">
            Guardar
        </button>
        <button id = "cancelarEditar">
            Cancelar
        </button>
    </div>
    <p id ="estado" hidden>
        Cargando...
    </p>
</div>
<script>
    var detReporte = <?php echo json_encode($detReporte)?>;
    var idDetEditar;
    var detEditar
    $('#aceptar').on('click', function(){
        var observaciones = $('#observaciones');
        $('#opcionesGenerales').hide();
        $('#estado').show();
        $.ajax({
            method: "POST",
            url: "Conexiones/ReportesSemestralesTutor/editarReporteSemestralTutor.php",
            data: {idReporte: <?php echo $idReporte?>, det: detReporte, observaciones: observaciones.val()}
        }).done(function (msg) {
            if(msg.localeCompare('ok') == 0){
                irALista();
            }else{
                window.alert('Ocurrió un error, inténtalo de nuevo');
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
    });
    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#tabla').on('click', '.editar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idDetEditar = parseInt(idString);
        detEditar = detReporte[idDetEditar];
        editarDet();
    });

    function editarDet(){
        $('#alumnoNombre').html(detEditar['alumno']);
        $('#tutoriaGrupal').val(detEditar['tutoriaGrupal']);
        $('#tutoriaIndividual').val(detEditar['tutoriaIndividual']);
        $('#canalizado').val(detEditar['canalizado']);
        $('#areaCanalizada').val(detEditar['areaCanalizada']);
        $('#opcionesPrincipales').hide();
        $('#formEditarDetalle').show();
    }

    $('#cancelarEditar').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formEditarDetalle').hide();   
        limpiarFormEditarDet();
    });

    function limpiarFormEditarDet(){
        $('#alumnoNombre').html('');
        $('#tutoriaGrupal').val('');
        $('#tutoriaIndividual').val('');
        $('#canalizado').val('');
        $('#areaCanalizada').val('');
    }

    $('#aceptarEditar').on('click', function(){
        var tutoriaIndividual = $('#tutoriaIndividual');
        var tutoriaGrupal = $('#tutoriaGrupal');
        var canalizado = $('#canalizado');
        var areaCanalizada = $('#areaCanalizada');
        detReporte[idDetEditar]['tutoriaIndividual'] = tutoriaIndividual.val();
        detReporte[idDetEditar]['tutoriaGrupal'] = tutoriaGrupal.val();
        detReporte[idDetEditar]['canalizado'] = canalizado.val();
        detReporte[idDetEditar]['areaCanalizada'] = areaCanalizada.val();
        limpiarFormEditarDet();
        actualizarTabla();
        $('#opcionesPrincipales').show();
        $('#formEditarDetalle').hide();   
    });

    function actualizarTabla(){
        var tabla = $('#tabla');
        var cabecera = '<tr>';
        cabecera += '<th>Estudiantes</th>';
        cabecera += '<th>Tutoría grupal</th>';
        cabecera += '<th>Tutoría individual</th>';
        cabecera += '<th>Estudiante canalizado</th>';
        cabecera += '<th>Área canalizada</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i<detReporte.length; i++){
            var det = detReporte[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row+='<td>'+det['alumno']+'</td>';
            row+='<td>'+det['tutoriaGrupal']+'</td>';
            row+='<td>'+det['tutoriaIndividual']+'</td>';
            row+='<td>'+det['canalizado']+'</td>';
            row+='<td>'+det['areaCanalizada']+'</td>';
            row+= '<td><button class="editar">Editar</button></td>';
            row+='</tr>';
            tabla.append(row);
        }
    }

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaReportesTutorEditar.php"
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
