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
    $idPlan = $_POST['idPlan'];
    $planAccion = $conn->getPlanAccionTutorialDepartamentalPorId($idPlan);
    ?>
    <h2>
        Editar plan de acción tutorial departamental
    </h2>
    <label>
        Nombre del coordinador: 
    </label>
    <input type = "text" value = "<?php echo $planAccion['coordinador']?>" readonly/><br/>
    <h3>
        Datos generales
    </h3>
    <label>
        Nombre del departamento: 
    </label>
    <input type = "text" value = "<?php echo $planAccion['departamento']?>" readonly/><br/>
    <label>
        Fecha: 
    </label>
    <input type = "text" value = "<?php echo $planAccion['fecha']?>" readonly/><br/>
    
    <h3>
        Problemáticas identificadas
    </h3>
    <table id = "tablaProblematicas">
        <tr>
            <th>
                Problemática
            </th>
            <th>
                Valor asignado
            </th>
            <th>
                Objetivos
            </th>
            <th>
                Acciones
            </th>
            <th>
                Editar
            </th>
            <th>
                Eliminar
            </th>
        </tr>
        <?php 
        $problematicas = $planAccion[0];
        $cont1 = 0;
            foreach ($problematicas as $prob) {
                echo '<tr data-indice-tabla = "'.$cont1.'">';
                echo '<td>'.$prob['problematica'].'</td>';
                echo '<td>'.$prob['valor'].'</td>';
                echo '<td>'.$prob['objetivos'].'</td>';
                echo '<td>'.$prob['acciones'].'</td>';
                echo '<td><button class="editar">Editar</button></td>';
                echo '<td><button class="eliminar">Eliminar</button></td>';
                echo '</tr>';
                $cont1++;            
            }
        ?>
    </table>
    <h3>
        Calendarización
    </h3>
    <table id = "tablaCalendarizacion">
        <tr>
            <th>
                Actividades
            </th>
            <th>
                Mes 1
            </th>
            <th>
                Mes 2
            </th>
            <th>
                Mes 3
            </th>
            <th>
                Mes 4
            </th>
            <th>
                Mes 5
            </th>
            <th>
                Mes 6
            </th>
            <th>
                Editar
            </th>
            <th>
                Eliminar
            </th>
        </tr>
        <?php 
            $calendarizacion = $planAccion[1];
            $cont2 = 0;
            foreach ($calendarizacion as $cal) {
                echo '<tr data-indice-tabla="'.$cont2.'">';
                echo '<td>'.$cal['actividad'].'</td>';
                echo '<td>'.$cal['mes1'].'</td>';
                echo '<td>'.$cal['mes2'].'</td>';
                echo '<td>'.$cal['mes3'].'</td>';
                echo '<td>'.$cal['mes4'].'</td>';
                echo '<td>'.$cal['mes5'].'</td>';
                echo '<td>'.$cal['mes6'].'</td>';
                echo '<td><button class="editar">Editar</button></td>';
                echo '<td><button class="eliminar">Eliminar</button></td>';
                echo '</td>';
                $cont2++;
            }
        ?>
    </table>
    <label>
        Evaluación: 
    </label>
    <textarea id = "evaluacion">
        <?php 
            echo $planAccion['evaluacion'];
        ?>
    </textarea>
    <div id = "opcionesGenerales">
        <button id = "aceptar">
            Guardar
        </button>
        <button id = "cancelar">
            Cancelar
        </button>
        <button id = "agregarProblematica">
            Nueva problemática
        </button>
        <button id = "agregarCalendarizacion">
            Nueva calendarización
        </button>
    </div>
    <div id = "formAgregarProblematica" hidden>
        <h3>
            Agregar problemática
        </h3>
        <label>
            Problemática : 
        </label>
        <input type = "text" id = "problematicaAgregar"><br>
        <label>
            Valor asignado :
        </label>
        <input type = "text" id = "valorAgregar"><br>
        <label>
            Objetivos :
        </label>
        <input type = "text" id = "objetivosAgregar"><br>
        <label>
            Acciones :
        </label>
        <input type = "text" id = "accionesAgregar"><br>
        <button id = "aceptarAgregarProblematica">
            Agregar problemática
        </button>
        <button id = "cancelarAgregarProblematica">
            Cancelar
        </button>
    </div>
    <div id = "formEditarProblematica" hidden>
        <h3>
            Editar problemática
        </h3>
        <label>
            Problemática : 
        </label>
        <input type = "text" id = "problematicaEditar"><br>
        <label>
            Valor asignado :
        </label>
        <input type = "text" id = "valorEditar"><br>
        <label>
            Objetivos :
        </label>
        <input type = "text" id = "objetivosEditar"><br>
        <label>
            Acciones :
        </label>
        <input type = "text" id = "accionesEditar"><br>
        <button id = "aceptarEditarProblematica">
            Guardar cambios
        </button>
        <button id = "cancelarEditarProblematica">
            Cancelar
        </button>
    </div>
    <div id = "formAgregarCalendarizacion" hidden>
        <h3>
            Agregar nueva calendarización
        </h3>
        <label>
            Actividad :
        </label>
        <input type = "text" id = "actividadAgregar"><br>
        <p>Marca con una X los meses en los que se llevará a cabo esta actividad</p>
        <label>Mes 1:</label>
        <input type = "text" id = "mes1Agregar"><br>
        <label>Mes 2:</label>
        <input type = "text" id = "mes2Agregar"><br>
        <label>Mes 3:</label>
        <input type = "text" id = "mes3Agregar"><br>
        <label>Mes 4:</label>
        <input type = "text" id = "mes4Agregar"><br>
        <label>Mes 5:</label>
        <input type = "text" id = "mes5Agregar"><br>
        <label>Mes 6:</label>
        <input type = "text" id = "mes6Agregar"><br>
        <button id = "aceptarAgregarCalendarizacion">
            Guardar
        </button>
        <button id = "cancelarAgregarCalendarizacion">
            Cancelar
        </button>
    </div>
    <div id = "formEditarCalendarizacion" hidden>
        <h3>
            Editar calendarización
        </h3>
        <label>
            Actividad :
        </label>
        <input type = "text" id = "actividadEditar"><br>
        <p>Marca con una X los meses en los que se llevará a cabo esta actividad</p>
        <label>Mes 1:</label>
        <input type = "text" id = "mes1Editar"><br>
        <label>Mes 2:</label>
        <input type = "text" id = "mes2Editar"><br>
        <label>Mes 3:</label>
        <input type = "text" id = "mes3Editar"><br>
        <label>Mes 4:</label>
        <input type = "text" id = "mes4Editar"><br>
        <label>Mes 5:</label>
        <input type = "text" id = "mes5Editar"><br>
        <label>Mes 6:</label>
        <input type = "text" id = "mes6Editar"><br>
        <button id = "aceptarEditarCalendarizacion">
            Guardar
        </button>
        <button id = "cancelarEditarCalendarizacion">
            Cancelar
        </button>
    </div>
    <p id = "estado" hidden>
        Cargando ...
    </p>
</div>
<script>
    var problematicas = <?php echo json_encode($problematicas)?>;
    var idProblematicaEditar;
    var problematicaEditar;
    var actividades  = <?php echo json_encode($calendarizacion)?>;
    var idActividadEditar;
    var actividadEditar;
    $('#aceptar').on('click', function(){
        var evaluacion = $('#evaluacion');
        if(problematicas.length>0){
            if(actividades.length>0){
                $('#opcionesGenerales').hide();
                $('#estado').show();
                $.ajax({
                    method: "POST",
                    url: "Conexiones/PlanesAccionTutorialDepartamental/editarPlanAccionTutorialDepartamental.php",
                    data: {problematicas: problematicas, actividades: actividades, idPlan: <?php echo $idPlan?>, evaluacion: evaluacion.val()}
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
                window.alert('Debes agregar al menos una actividad');
            }
        }else{
            window.alert('Debes agregar al menos una problemática');
        }
    });

    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#agregarProblematica').on('click', function(){
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').show();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
        $('#problematicaAgregar').focus();
    });

    $('#agregarCalendarizacion').on('click', function(){
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').show();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
        $('#actividadAgregar').focus();
    });

    $('#cancelarAgregarProblematica').on('click', function(){
        $('#opcionesGenerales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
    });

    function limpiarFormAgregarProblematica(){
        $('#problematicaAgregar').val('');
        $('#valorAgregar').val('');
        $('#objetivosAgregar').val('');
        $('#accionesAgregar').val('');
    }

    $('#aceptarAgregarProblematica').on('click', function(){
        var problematica = $('#problematicaAgregar');
        var valor = $('#valorAgregar');
        var objetivos = $('#objetivosAgregar');
        var acciones = $('#accionesAgregar');
        if(!problematica.val() || !valor.val() || !objetivos.val() || !acciones.val()){
            window.alert('Debes llenar todos los campos');
        }else{
            problematicas.push({problematica: problematica.val(), valor: valor.val(), objetivos: objetivos.val(), acciones: acciones.val()});
            actualizarTablaProblematicas();
            $('#opcionesGenerales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();
            $('#formAgregarCalendarizacion').hide();
            $('#formEditarCalendarizacion').hide();
            limpiarFormAgregarCalendarizacion();
            limpiarFormEditarProblematica();
            limpiarFormAgregarProblematica();
            limpiarFormEditarActividad();
        }
    });

    function actualizarTablaProblematicas(){
        var tabla = $('#tablaProblematicas');
        var cabecera = '<tr>';
        cabecera += '<th>Problemática</th>';
        cabecera += '<th>Valor asignado</th>';
        cabecera += '<th>Objetivos</th>';
        cabecera += '<th>Acciones</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '<th>Eliminar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i < problematicas.length; i++){
            var problematica = problematicas[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+problematica['problematica']+'</td>';
            row += '<td>'+problematica['valor']+'</td>';
            row += '<td>'+problematica['objetivos']+'</td>';
            row += '<td>'+problematica['acciones']+'</td>';
            row += '<td><button class="editar">Editar</button></td>';
            row += '<td><button class="eliminar">Eliminar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    $('#tablaProblematicas').on('click', '.editar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idProblematicaEditar = parseInt(idString);
        problematicaEditar = problematicas[idProblematicaEditar];
        editarProblematica();
    });

    function editarProblematica(){
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').show();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
        $('#problematicaEditar').val(problematicaEditar['problematica']);
        $('#valorEditar').val(problematicaEditar['valor']);
        $('#objetivosEditar').val(problematicaEditar['objetivos']);
        $('#accionesEditar').val(problematicaEditar['acciones']);   
        $('#problematicaEditar').focus();
    }

    $('#cancelarEditarProblematica').on('click', function(){
        $('#opcionesGenerales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
    });

    function limpiarFormEditarProblematica(){
        $('#problematicaEditar').val('');
        $('#valorEditar').val('');
        $('#objetivosEditar').val('');
        $('#accionesEditar').val('');      
    }

    $('#aceptarEditarProblematica').on('click', function(){
        var problematica = $('#problematicaEditar');
        var valor = $('#valorEditar');
        var objetivos = $('#objetivosEditar');
        var acciones = $('#accionesEditar');
        if(!problematica.val() || !valor.val() || !objetivos.val() || !acciones.val()){
            window.alert('Debes llenar todos los campos');
        }else{
            problematicas[idProblematicaEditar]['problematica'] = problematica.val();
            problematicas[idProblematicaEditar]['valor'] = valor.val();
            problematicas[idProblematicaEditar]['objetivos'] = objetivos.val();
            problematicas[idProblematicaEditar]['acciones'] = acciones.val();
            actualizarTablaProblematicas();
            $('#opcionesGenerales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();
            $('#formAgregarCalendarizacion').hide();
            $('#formEditarCalendarizacion').hide();
            limpiarFormAgregarCalendarizacion();
            limpiarFormEditarProblematica();
            limpiarFormAgregarProblematica();
            limpiarFormEditarActividad();
        }         
    });

    $('#tablaProblematicas').on('click', '.eliminar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        var id = parseInt(idString);
        var eliminar = window.confirm('¿Seguro que deseas eliminar este elemento de la lista?');
        if(eliminar){
            problematicas.splice(id, 1);
            actualizarTablaProblematicas();
            $('#opcionesGenerales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();
            $('#formAgregarCalendarizacion').hide();
            $('#formEditarCalendarizacion').hide();
            limpiarFormAgregarCalendarizacion();
            limpiarFormEditarProblematica();
            limpiarFormAgregarProblematica();
            limpiarFormEditarActividad();
        }
    });

    $('#cancelarAgregarCalendarizacion').on('click', function(){
        $('#opcionesGenerales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
    });

    function limpiarFormAgregarCalendarizacion(){
        $('#actividadAgregar').val('');
        $('#mes1Agregar').val('');
        $('#mes2Agregar').val('');
        $('#mes3Agregar').val('');
        $('#mes4Agregar').val('');
        $('#mes5Agregar').val('');
        $('#mes6Agregar').val('');
    }

    $('#aceptarAgregarCalendarizacion').on('click', function(){
        var actividad = $('#actividadAgregar');
        var mes1 = $('#mes1Agregar');
        var mes2 = $('#mes2Agregar');
        var mes3 = $('#mes3Agregar');
        var mes4 = $('#mes4Agregar');
        var mes5 = $('#mes5Agregar');
        var mes6 = $('#mes6Agregar');
        if(!actividad.val()){
            window.alert('Debes especificar la actividad');
        }else{
            if(!mes1.val() && !mes2.val() && !mes3.val() && !mes4.val() && !mes5.val() && !mes6.val()){
                window.alert('Debes especificar al menos un mes para realizar esta actividad');
            }else{
                actividades.push({actividad: actividad.val(), mes1:mes1.val(), mes2: mes2.val(), mes3: mes3.val(), mes4: mes4.val(),
                    mes5: mes5.val(), mes6: mes6.val()});
                actualizarTablaCalendarizacion();
                $('#opcionesGenerales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();
                $('#formAgregarCalendarizacion').hide();
                $('#formEditarCalendarizacion').hide();
                limpiarFormAgregarCalendarizacion();
                limpiarFormEditarProblematica();
                limpiarFormAgregarProblematica();
                limpiarFormEditarActividad();
            }
        }
    });

    function actualizarTablaCalendarizacion(){
        var tabla = $('#tablaCalendarizacion');
        var cabecera = '<tr>';
        cabecera += '<th>Actividades</th>';
        cabecera += '<th>Mes 1</th>';
        cabecera += '<th>Mes 2</th>';
        cabecera += '<th>Mes 3</th>';
        cabecera += '<th>Mes 4</th>';
        cabecera += '<th>Mes 5</th>';
        cabecera += '<th>Mes 6</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i<actividades.length; i++){
            var actividad = actividades[i];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+actividad['actividad']+'</td>';
            row += '<td>'+actividad['mes1']+'</td>';
            row += '<td>'+actividad['mes2']+'</td>';
            row += '<td>'+actividad['mes3']+'</td>';
            row += '<td>'+actividad['mes4']+'</td>';
            row += '<td>'+actividad['mes5']+'</td>';
            row += '<td>'+actividad['mes6']+'</td>';
            row += '<td><button class="editar">Editar</button></td>';
            row += '<td><button class="eliminar">Eliminar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    $('#tablaCalendarizacion').on('click','.editar', function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idActividadEditar = parseInt(idString);
        actividadEditar = actividades[idActividadEditar];
        editarActividad();
    });

    function editarActividad(){
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').show();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
        $('#actividadEditar').focus();
        $('#actividadEditar').val(actividadEditar['actividad']);
        $('#mes1Editar').val(actividadEditar['mes1']);
        $('#mes2Editar').val(actividadEditar['mes2']);
        $('#mes3Editar').val(actividadEditar['mes3']);
        $('#mes4Editar').val(actividadEditar['mes4']);
        $('#mes5Editar').val(actividadEditar['mes5']);
        $('#mes6Editar').val(actividadEditar['mes6']);
    }

    $('#cancelarEditarProblematica').on('click', function(){
        $('#opcionesGenerales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
        $('#formAgregarCalendarizacion').hide();
        $('#formEditarCalendarizacion').hide();
        limpiarFormAgregarCalendarizacion();
        limpiarFormEditarProblematica();
        limpiarFormAgregarProblematica();
        limpiarFormEditarActividad();
    });

    function limpiarFormEditarActividad(){
        $('#actividadEditar').val('');
        $('#mes1Editar').val('');
        $('#mes2Editar').val('');
        $('#mes3Editar').val('');
        $('#mes4Editar').val('');
        $('#mes5Editar').val('');
        $('#mes6Editar').val('');   
    }

    $('#aceptarEditarCalendarizacion').on('click', function(){
        var actividad = $('#actividadEditar');
        var mes1 = $('#mes1Editar');
        var mes2 = $('#mes2Editar');
        var mes3 = $('#mes3Editar');
        var mes4 = $('#mes4Editar');
        var mes5 = $('#mes5Editar');
        var mes6 = $('#mes6Editar');
        if(!actividad.val()){
            window.alert('Debes especificar la actividad');
        }else{
            if(!mes1.val() && !mes2.val() && !mes3.val() && !mes4.val() && !mes5.val() && !mes6.val()){
                window.alert('Debes especificar al menos un mes para realizar esta actividad');
            }else{
                actividades[idActividadEditar]['actividad'] = actividad.val();
                actividades[idActividadEditar]['mes1'] = mes1.val();
                actividades[idActividadEditar]['mes2'] = mes2.val();
                actividades[idActividadEditar]['mes3'] = mes3.val();
                actividades[idActividadEditar]['mes4'] = mes4.val();
                actividades[idActividadEditar]['mes5'] = mes5.val();
                actividades[idActividadEditar]['mes6'] = mes6.val();
                actualizarTablaCalendarizacion();
                $('#opcionesGenerales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();
                $('#formAgregarCalendarizacion').hide();
                $('#formEditarCalendarizacion').hide();
                limpiarFormAgregarCalendarizacion();
                limpiarFormEditarProblematica();
                limpiarFormAgregarProblematica();
                limpiarFormEditarActividad();
            }
        }
    });
    
    $('#tablaCalendarizacion').on('click', '.eliminar',function(e){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        var id = parseInt(idString);
        var eliminar = window.confirm('¿Seguro que deseas eliminar este elemento de la lista?');
        if(eliminar == true){
            actividades.splice(id, 1);
            actualizarTablaCalendarizacion();
            $('#opcionesGenerales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();
            $('#formAgregarCalendarizacion').hide();
            $('#formEditarCalendarizacion').hide();
            limpiarFormAgregarCalendarizacion();
            limpiarFormEditarProblematica();
            limpiarFormAgregarProblematica();
            limpiarFormEditarActividad();
        }
    });

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaPlanesAccionTutorialDepartamentalEditar.php"
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