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
    $idDiagnostico = $_POST['idDiagnostico'];
    $diagnosticoGrupal = $conn->getDiagnosticoGrupalPorId($idDiagnostico);
    ?>
    <h2>Diagnóstico de grupo</h2>
    <label>
        Fecha:
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['fecha']?>" readonly/>
    <h3>
        Nombre del(los) tutores
    </h3>
    <label>
        Tutor 1: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['tutor1']?>" readonly/></br>
    <label>
        Tutor 2: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['tutor2']?>" readonly/><br>
    <h2>
        Unidad académica
    </h2>
    <label>
        Grupo: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['nombre']?>" readonly/></br>
    <label>
        Número de alumnos : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['noAlumnos']?>" readonly/></br>
    <label>
        Semestre: 
    </label>
    <input type= "text" value = "<?php echo $diagnosticoGrupal['semestre']?>" readonly/></br>
    <table id="tablaDet">
        <tr>
            <th>
                Fases de la tutoría
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
            $detDiagnosticos = $diagnosticoGrupal[0];
            $contador = 0;
            foreach ($detDiagnosticos as $diagnostico) {
                echo '<tr data-indice-tabla="'.$contador.'">';
                echo '<td>'.$diagnostico['fase'].'</td>';
                echo '<td>'.$diagnostico['areaEvaluacion'].'</td>';
                echo '<td>'.$diagnostico['instrumento'].'</td>';
                echo '<td>'.$diagnostico['recAnalisis'].'</td>';
                echo '<td>'.$diagnostico['hallazgos'].'</td>';
                echo '<td><button class="editarElemento">Editar</button></td>';
                echo '<td><button class ="eliminarElemento">Eliminar</button></td>';
                echo '</tr>';
                $contador++;
            }
        ?>
    </table>
    <div id = "opcionesGenerales">
        <button id = "aceptar">
            Guardar cambios
        </button>
        <button id = "cancelar">
            Cancelar cambios
        </button>
        <button id = "nuevoElemento">
            Agregar elemento a la tabla
        </button>
    </div>
    <div id = "agregarDet" hidden>
        <h3>Agregar elemento a la tabla</h3>
        <label>Fase : </label><input type = "text" id="fase"/><br/>
        <label>Áreas de evaluación : </label><input type = "text" id="areasEvaluacion"/><br/>
        <label>Instrumento : </label><input type = "text" id="instrumento"/><br/>
        <label>Rec. y análisis de inf. : </label><input type = "text" id="recanalisis"/><br/>
        <label>Hallazgos : </label><input type = "text" id="hallazgos"/><br/>
        <button id = "aceptarAgregar">
            Agregar
        </button>
        <button id = "cancelarAgregar">
            Cancelar
        </button>
    </div>
    <div id="editarDet" hidden>
        <h3>Editar elemento</h3>
        <label>Fase : </label><input type = "text" id="faseEd"/><br/>
        <label>Áreas de evaluación : </label><input type = "text" id="areasEvaluacionEd"/><br/>
        <label>Instrumento : </label><input type = "text" id="instrumentoEd"/><br/>
        <label>Rec. y análisis de inf. : </label><input type = "text" id="recanalisisEd"/><br/>
        <label>Hallazgos : </label><input type = "text" id="hallazgosEd"/><br/>
        <button id = "aceptarEditar">
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
    var detDiagnosticos = <?php echo json_encode($detDiagnosticos)?>;
    var elementoEditar;
    var indiceEditar;
    $('#aceptar').on('click', function(){
        if(detDiagnosticos.length>0){
            $('#opcionesGenerales').hide();
            $('#estado').show();
            $.ajax({
                method: "POST",
                url: "Conexiones/DiagnosticosGrupales/editarDiagnosticoGrupal.php",
                data: {det: detDiagnosticos, idDiagnostico: <?php echo $idDiagnostico?>}
            }).done(function (msg) {
                if(msg.localeCompare('ok') == 0){
                    irALista();
                }else{
                    window.alert('Ocurrió un error, inténtalode nuevo');
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
            window.alert('Debes agregar al menos un elemento para poder continuar');
        }
    });

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaDiagnosticosGruposEditar.php"
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

    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#nuevoElemento').on('click', function(){
        $('#agregarDet').show();
        $('#opcionesGenerales').hide();
    });

    $('#cancelarAgregar').on('click', function(){
        $('#agregarDet').hide();
        $('#opcionesGenerales').show();
        limpiarFormAgregar();
    });

    $('#aceptarAgregar').on('click', function(){
        var fase = $('#fase');
        var areasEvaluacion = $('#areasEvaluacion');
        var instrumento = $('#instrumento');
        var recanalisis = $('#recanalisis');
        var hallazgos = $('#hallazgos');
        if(!fase.val() || !areasEvaluacion.val() || !instrumento.val() || !recanalisis.val() || !hallazgos.val() ){
            window.alert('Debes llenar todos los campos');
        }else{
            detDiagnosticos.push({"fase": fase.val(), "areaEvaluacion": areasEvaluacion.val(), "instrumento": instrumento.val(), "recAnalisis": recanalisis.val(), "hallazgos": hallazgos.val()});
            $('#agregarDet').hide();
            $('#opcionesGenerales').show();
            limpiarFormAgregar();
            actualizarTabla();
        }
    });

    function limpiarFormAgregar(){
        $('#fase').val("");
        $('#areasEvaluacion').val("");
        $('#instrumento').val("");
        $('#recanalisis').val("");
        $('#hallazgos').val("");
    }

    function limpiarFormEditar(){
        $('#faseEd').val("");
        $('#areasEvaluacionEd').val("");
        $('#instrumentoEd').val("");
        $('#recanalisisEd').val("");
        $('#hallazgosEd').val("");   
    }
    function actualizarTabla(){
        var tabla = $('#tablaDet');
        var cabecera = '<tr>';
        cabecera += '<th>Fases de la tutoría</th>';
        cabecera += '<th>Áreas de evaluación</th>';
        cabecera += '<th>Instrumento</th>';
        cabecera += '<th>Recolección y análisis de información</th>';
        cabecera += '<th>Hallazgos</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '<th>Eliminar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i < detDiagnosticos.length; i++){
            var renglon = detDiagnosticos[i];
            var renglonString = '<tr data-indice-tabla="'+i+'">';
            renglonString+= '<td>'+renglon['fase']+'</td>';
            renglonString+= '<td>'+renglon['areaEvaluacion']+'</td>';
            renglonString+= '<td>'+renglon['instrumento']+'</td>';
            renglonString+= '<td>'+renglon['recAnalisis']+'</td>';
            renglonString+= '<td>'+renglon['hallazgos']+'</td>';
            renglonString+= '<td><button class="editarElemento">Editar</button></td>';
            renglonString+= '<td><button class="eliminarElemento">Eliminar</button></td>';
            renglonString+= '</tr>';
            tabla.append(renglonString);
        }

    }

    $('#tablaDet').on('click', '.editarElemento',function(e){
        var indiceString = $(this).parent().parent().attr('data-indice-tabla');
        var indice = parseInt(indiceString);
        indiceEditar = indice;
        elementoEditar = detDiagnosticos[indice];
        editarElemento();
    });
    
    $('#tablaDet').on('click', '.eliminarElemento', function(e){
        var indiceString = $(this).parent().parent().attr('data-indice-tabla');
        var indice = parseInt(indiceString);
        var eliminar = window.confirm("¿Está seguro que desea eliminar este elemento?");
        if(eliminar == true){
            detDiagnosticos.splice(indice, 1);
            actualizarTabla();
            $('#agregarDet').hide();
            $('#opcionesGenerales').show();
            $('#editarDet').hide();
            limpiarFormAgregar();
            limpiarFormEditar();
            window.alert('eliminado correctamente');
        }
    });
    function editarElemento(){
        $('#faseEd').val(elementoEditar['fase']);
        $('#areasEvaluacionEd').val(elementoEditar['areaEvaluacion']);
        $('#instrumentoEd').val(elementoEditar['instrumento']);
        $('#recanalisisEd').val(elementoEditar['recAnalisis']);
        $('#hallazgosEd').val(elementoEditar['hallazgos']);
        $('#agregarDet').hide();
        $('#opcionesGenerales').hide();
        $('#editarDet').show();
    }

    $('#aceptarEditar').on('click', function(){
        var fase = $('#faseEd');
        var areasEvaluacion = $('#areasEvaluacionEd');
        var instrumento = $('#instrumentoEd');
        var recanalisis = $('#recanalisisEd');
        var hallazgos = $('#hallazgosEd');
        if(!fase.val() || !areasEvaluacion.val() || !instrumento.val() || !recanalisis.val() || !hallazgos.val()){
            alert('Debes llenar todos los campos para editar el elemento');
        }else{
            detDiagnosticos[indiceEditar]['fase'] = fase.val();
            detDiagnosticos[indiceEditar]['areaEvaluacion'] = areasEvaluacion.val();
            detDiagnosticos[indiceEditar]['instrumento'] = instrumento.val();
            detDiagnosticos[indiceEditar]['recAnalisis'] = recanalisis.val();
            detDiagnosticos[indiceEditar]['hallazgos'] = hallazgos.val();
            actualizarTabla();
            $('#agregarDet').hide();
            $('#opcionesGenerales').show();
            $('#editarDet').hide();       
        }
    });
    
    $('#cancelarEditar').on('click', function(){
        $('#agregarDet').hide();
        $('#opcionesGenerales').show();
        $('#editarDet').hide();       
        limpiarFormEditar();
    });
</script>