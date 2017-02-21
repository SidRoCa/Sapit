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
    $idDiagnostico = $_POST['idDiagnostico'];
    $diagnosticoDepartamental = $conn->getDiagnosticoDepartamentalPorId($idDiagnostico);
    ?>
    <h2>Diagnóstico departamental</h2>
    <h3>Datos generales</h3>
    <label>
        Nombre del coordinador: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['coordinador']?>" readonly/>
    <label>
        Fecha : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['fecha']?>" readonly/>
    <h3>
        Unidad académica
    </h3>
    <label>
        Departamento : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['departamento']?>" readonly/> <br>
        <table id = "tabla">
        <tr>
            <th>
                Fase de la tutoría
            </th>
            <th>
                Áreas de evaluación
            </th>
            <th>
                Instrumento
            </th>
            <th>
                Recolección y análisis de información
            </th>
            <th>
                Hallazgos
            </th>
            <th>
                Editar
            </th>
            <th>
                Eliminar
            </th>   
        </tr>
        <?php 
            $det = $diagnosticoDepartamental[0];
            $cont = 0;
            foreach ($det as $row) {
                echo '<tr data-indice-tabla="'.$cont.'">';
                echo '<td>'.$row['fase'].'</td>';
                echo '<td>'.$row['areaEvaluacion'].'</td>';
                echo '<td>'.$row['instrumento'].'</td>';
                echo '<td>'.$row['recanalisis'].'</td>';
                echo '<td>'.$row['hallazgos'].'</td>';
                echo '<td><button class="editar">Editar</button></td>';
                echo '<td><button class="eliminar">Eliminar</button></td>';
                echo '</tr>';
                $cont++;
            }
        ?>
    </table>
    <div id = "opcionesGenerales">
        <button id = "aceptar">
            Guardar
        </button>   
        <button id = "cancelar">
            Cancelar
        </button>
        <button id = "agregarElemento">
            Agregar elemento
        </button>
    </div>
    <div id = "fromAgregarDet" hidden>
        <h3>
            Agregar elemento a la lista
        </h3>
        <label>
            Fase de la tutoría :
        </label>
        <input type = "text" id = "faseAgregar"><br>
        <label>
            Áreas de evaluación :
        </label>
        <input type = "text" id = "areaEvaluacionAgregar"><br>
        <label>
            Instrumento :
        </label>
        <input type = "text" id = "instrumentoAgregar"><br>
        <label>
            Recolección y análisis de información : 
        </label>
        <input type = "text" id = "recanalisisAgregar"><br>
        <label>
            Hallazgos : 
        </label>
        <input type = "text" id = "hallazgosAgregar"><br>
        <button id = "aceptarAgregar">
            Agregar
        </button>
        <button id = "cancelarAgregar">
            Cancelar
        </button>
    </div>
    <div id = "fromEditarDet" hidden>
        <h3>
            Editar elemento de la lista
        </h3>
        <label>
            Fase de la tutoría :
        </label>
        <input type = "text" id = "faseEditar"><br>
        <label>
            Áreas de evaluación :
        </label>
        <input type = "text" id = "areaEvaluacionEditar"><br>
        <label>
            Instrumento :
        </label>
        <input type = "text" id = "instrumentoEditar"><br>
        <label>
            Recolección y análisis de información : 
        </label>
        <input type = "text" id = "recanalisisEditar"><br>
        <label>
            Hallazgos : 
        </label>
        <input type = "text" id = "hallazgosEditar"><br>
        <button id = "aceptarEditar">
            Guardar cambios
        </button>
        <button id = "cancelarEditar">
            Cancelar
        </button>
    </div>
    <p id = "estado" hidden>
        Cargando ...
    </p>
</div>
<script>
    var detDiagnostico = <?php echo json_encode($det)?>;
    var idElementoEditar;
    var elementoEditar;
    $('#aceptar').on('click', function(){
        if(detDiagnostico.length>0){
            $('#opcionesGenerales').hide();
            $('#estado').show();
            $.ajax({
                method: "POST",
                url: "Conexiones/DiagnosticosDepartamentales/editarDiagnosticoDepartamental.php",
                data: {idDiagnostico: <?php echo $idDiagnostico?>, det: detDiagnostico}
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
        }else{
            window.alert('Debes agregar al menos un elemento a la lista para continuar');
        }
    });

    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#agregarElemento').on('click', function(){
        $('#opcionesGenerales').hide();
        $('#fromAgregarDet').show();
        $('#faseAgregar').focus();
    });

    $('#cancelarAgregar').on('click', function(){
       $('#opcionesGenerales').show();
       $('#fromAgregarDet').hide(); 
       limpiarFormAgregar();
    });

    function limpiarFormAgregar(){
        $('#faseAgregar').val('');
        $('#areaEvaluacionAgregar').val('');
        $('#instrumentoAgregar').val('');
        $('#recanalisisAgregar').val('');
        $('#hallazgosAgregar').val('');
    }

    $('#aceptarAgregar').on('click', function(){
        var fase = $('#faseAgregar');
        var areaEvaluacion = $('#areaEvaluacionAgregar');
        var instrumento = $('#instrumentoAgregar');
        var recanalisis = $('#recanalisisAgregar');
        var hallazgos = $('#hallazgosAgregar');
        if(!fase.val() || !areaEvaluacion.val() || !instrumento.val() || !recanalisis.val() || !hallazgos.val()){
            window.alert('Debes llenar todos los campos');
        }else{
            detDiagnostico.push({fase: fase.val(), areaEvaluacion: areaEvaluacion.val(), instrumento: instrumento.val(), recanalisis: recanalisis.val(), hallazgos: hallazgos.val()});
            actualizarTabla();
            $('#opcionesGenerales').show();
            $('#fromAgregarDet').hide(); 
            limpiarFormAgregar();
        }
    });

    function actualizarTabla(){
        var tabla = $('#tabla');
        var cabecera = '<tr>';
        cabecera += '<th>Fase de la tutoría</th>';
        cabecera += '<th>Áreas de evaluación</th>';
        cabecera += '<th>Instrumento</th>';
        cabecera += '<th>Recolección y análisis de información</th>';
        cabecera += '<th>Hallazgos</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '<th>Eliminar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i<detDiagnostico.length; i++){
            var elemento = detDiagnostico[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+elemento['fase']+'</td>';
            row += '<td>'+elemento['areaEvaluacion']+'</td>';
            row += '<td>'+elemento['instrumento']+'</td>';
            row += '<td>'+elemento['recanalisis']+'</td>';
            row += '<td>'+elemento['hallazgos']+'</td>';
            row += '<td><button class="editar">Editar</button></td>';
            row += '<td><button class="eliminar">Eliminar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    $('#tabla').on('click','.editar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idElementoEditar = parseInt(idString);
        elementoEditar = detDiagnostico[idElementoEditar];
        editarElemento();
    });

    function editarElemento(){
        $('#opcionesGenerales').hide();
        $('#fromAgregarDet').hide(); 
        $('#fromEditarDet').show();
        $('#faseEditar').val(elementoEditar['fase']);
        $('#areaEvaluacionEditar').val(elementoEditar['areaEvaluacion']);
        $('#instrumentoEditar').val(elementoEditar['instrumento']);
        $('#recanalisisEditar').val(elementoEditar['recanalisis']);
        $('#hallazgosEditar').val(elementoEditar['hallazgos']);
        $('#faseEditar').focus();
    }

    $('#cancelarEditar').on('click', function(){
        $('#opcionesGenerales').show();
        $('#fromAgregarDet').hide(); 
        $('#fromEditarDet').hide();
        limpiarFormEditar();
    });

    function limpiarFormEditar(){
        $('#faseEditar').val('');
        $('#areaEvaluacionEditar').val('');
        $('#instrumentoEditar').val('');
        $('#recanalisisEditar').val('');
        $('#hallazgosEditar').val('');
    }

    $('#aceptarEditar').on('click', function(){
        var fase = $('#faseEditar');
        var areaEvaluacion = $('#areaEvaluacionEditar');
        var instrumento = $('#instrumentoEditar');
        var recanalisis = $('#recanalisisEditar');
        var hallazgos = $('#hallazgosEditar');
        if(!fase.val() || !areaEvaluacion.val() || !instrumento.val() || !recanalisis.val() || !hallazgos.val()){
            window.alert('Debes llenar todos los campos');
        }else{
            detDiagnostico[idElementoEditar]['fase'] = fase.val();
            detDiagnostico[idElementoEditar]['areaEvaluacion'] = areaEvaluacion.val();
            detDiagnostico[idElementoEditar]['instrumento'] = instrumento.val();
            detDiagnostico[idElementoEditar]['recanalisis'] = recanalisis.val();
            detDiagnostico[idElementoEditar]['hallazgos'] = hallazgos.val();
            limpiarFormEditar();
            actualizarTabla();
            $('#opcionesGenerales').show();
            $('#fromAgregarDet').hide(); 
            $('#fromEditarDet').hide();
        }
    });

    $('#tabla').on('click','.eliminar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        var id = parseInt(idString);
        var eliminar = window.confirm('¿Estás seguro que deseas eliminar este elemento de la lista?');
        if(eliminar == true){
            detDiagnostico.splice(id, 1);
            limpiarFormAgregar();
            limpiarFormEditar();
            actualizarTabla();
            $('#opcionesGenerales').show();
            $('#fromAgregarDet').hide(); 
            $('#fromEditarDet').hide();
        }
    });

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosDepartamentalesEditar.php"
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
