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
    $idPlan = $_POST['idPlan'];
    $planAccion = $conn->getPlanAccionTutorialPorId($idPlan);
    ?>
    <h2>Plan de acción tutorial</h2>
    <label>
        Fecha:
    </label>
    <input type = "text" value = "<?php echo $planAccion['fecha']?>" readonly/>
    <h3>
        Nombre del(los) tutores
    </h3>
    <label>
        Tutor: 
    </label>
    <input type= "text" value= "<?php echo $planAccion['tutor1']?>" readonly/><br/>
    <label>
        Tutor: 
    </label>
    <input type= "text" value= "<?php echo $planAccion['tutor2']?>" readonly/><br/>
    <h3>
        Unidad académica
    </h3>
    <label>
        Grupo: 
    </label>
    <input type="text" value = "<?php echo $planAccion['nombreGrupo']?>" readonly/><br/>
    <label>
        Número de alumnos
    </label>
    <input type = "text" value = "<?php echo $planAccion['noAlumnos']?>" readonly/><br/>
    <label>
        Semestre
    </label>
    <input type = "text" value = "<?php echo $planAccion['semestre']?>" readonly/><br/>
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
            foreach ($problematicas as $problematica) {
                echo '<tr data-id-tabla ="'.$cont1.'">';
                echo '<td>';
                echo $problematica['problematica'];
                echo '</td>';
                echo '<td>';
                echo $problematica['valor'];
                echo '</td>';
                echo '<td>';
                echo $problematica['objetivos'];
                echo '</td>';
                echo '<td>';
                echo $problematica['acciones'];
                echo '</td>';
                echo '<td><button class="editarProb">Editar</button></td>';
                echo '<td><button class="eliminarProb">Eliminar</button></td>';
                echo '</tr>';
                $cont1++;
            }
        ?>
    </table>
    <table id = "tablaActividades">
        <?php 
            echo '<tr>';
            echo '<th>Actividades</th>';
            echo '<th>Mes 1</th>';
            echo '<th>Mes 2</th>';
            echo '<th>Mes 3</th>';
            echo '<th>Mes 4</th>';
            echo '<th>Mes 5</th>';
            echo '<th>Mes 6</th>';
            echo '<th>Editar</th>';
            echo '<th>Eliminar</th>';
            echo '</tr>';
            $actividades = $planAccion[1];
            $cont2 = 0;
            foreach ($actividades as $actividad) {
                echo '<tr data-id-tabla="'.$cont2.'">';
                echo '<td>'.$actividad['accion'].'</td>';
                echo '<td>'.$actividad['mes1'].'</td>';
                echo '<td>'.$actividad['mes2'].'</td>';
                echo '<td>'.$actividad['mes3'].'</td>';
                echo '<td>'.$actividad['mes4'].'</td>';
                echo '<td>'.$actividad['mes5'].'</td>';
                echo '<td>'.$actividad['mes6'].'</td>';
                echo '<td><button class="editarAct">Editar</button></td>';
                echo '<td><button class="eliminarAct">Eliminar</button></td>';
                echo '</tr>';
                $cont2++;
            }
            
        ?>
    </table>
    <div id = "opcionesPrincipales">
        <button id = "aceptar">
            Guardar cambios
        </button>
        <button id = "cancelar">
            Cancelar
        </button>
        <button id = "agregarProblematica">
            Nueva problemática
        </button>
        <button id = "agregarActividad">
            Nueva actividad
        </button>
    </div>
    <div id = "formAgregarProblematica" hidden>
        <h3>
            Nueva problemática
        </h3>
        <label>
            Problemática
        </label>
        <input type = "text" id = "problematicaAgregar"/></br>
        <label>
            Valor asignado
        </label>
        <input type = "text" id = "valorAgregar"/></br>
        <label>
            Objetivos
        </label>
        <input type = "text" id = "objetivosAgregar"/></br>
        <label>
            Acciones
        </label>
        <input type = "text" id = "accionesAgregar"/></br>
        <button id = "aceptarAgregarProblematica">
            Agregar
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
            Problemática
        </label>
        <input type = "text" id = "problematicaEditar"/></br>
        <label>
            Valor asignado
        </label>
        <input type = "text" id = "valorEditar"/></br>
        <label>
            Objetivos
        </label>
        <input type = "text" id = "objetivosEditar"/></br>
        <label>
            Acciones
        </label>
        <input type = "text" id = "accionesEditar"/></br>
        <button id = "aceptarEditarProblematica">
            Editar
        </button>
        <button id = "cancelarEditarProblematica">
            Cancelar
        </button>
    </div>
    <div id = "formAgregarActividad" hidden>
        <h3>
            Agregar actividad
        </h3>
        <label>
            Actividad :
        </label>
        <input type = "text" id = "actividadAgregar"/></br>
        <p>
            Marca con una X los meses en que se llevará a cabo la actividad
        </p>
        <label>
            Mes 1 :
        </label>
        <input type = "text" id = "mes1Agregar"/></br>
        <label>
            Mes 2 :
        </label>
        <input type = "text" id = "mes2Agregar"/></br>
        <label>
            Mes 3 :
        </label>
        <input type = "text" id = "mes3Agregar"/></br>
        <label>
            Mes 4 :
        </label>
        <input type = "text" id = "mes4Agregar"/></br>
        <label>
            Mes 5 :
        </label>
        <input type = "text" id = "mes5Agregar"/></br>
        <label>
            Mes 6 :
        </label>
        <input type = "text" id = "mes6Agregar"/></br>
        <button id = "aceptarAgregarActividad">
            Agregar
        </button>
        <button id = "cancelarAgregarActividad">
            Cancelar
        </button>
    </div>
    <div id = "formEditarActividad" hidden>
        <h3>
            Editar actividad
        </h3>
        <label>
            Actividad :
        </label>
        <input type = "text" id = "actividadEditar"/></br>
        <p>
            Marca con una X los meses en que se llevará a cabo la actividad
        </p>
        <label>
            Mes 1 :
        </label>
        <input type = "text" id = "mes1Editar"/></br>
        <label>
            Mes 2 :
        </label>
        <input type = "text" id = "mes2Editar"/></br>
        <label>
            Mes 3 :
        </label>
        <input type = "text" id = "mes3Editar"/></br>
        <label>
            Mes 4 :
        </label>
        <input type = "text" id = "mes4Editar"/></br>
        <label>
            Mes 5 :
        </label>
        <input type = "text" id = "mes5Editar"/></br>
        <label>
            Mes 6 :
        </label>
        <input type = "text" id = "mes6Editar"/></br>
        <button id = "aceptarEditarActividad">
            Guardar edición
        </button>
        <button id = "cancelarEditarActividad">
            Cancelar
        </button>
    </div>
    <p id = "estado" hidden>
        Cargando...
    </p>
</div>
<script>
    var problematicas = <?php echo json_encode($problematicas)?>;
    var actividades = <?php echo json_encode($actividades)?>;
    var problematicaEditar;
    var idProblematicaEditar;
    var actividadEditar;
    var idActividadEditar;
    $('#aceptar').on('click', function(){
        if(problematicas.length>0){
            if(actividades.length>0){
                $('#opcionesGenerales').hide();
                $('#estado').show();
                $.ajax({
                    method: "POST",
                    url: "Conexiones/PlanesAccionTutorial/editarPlanAccionTutorial.php",
                    data: {problematicas: problematicas, actividades: actividades, idPlan: <?php echo $idPlan?>}
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
        $('#opcionesPrincipales').hide();
        $('#formAgregarProblematica').show();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').hide();
        $('#problematicaAgregar').focus();
    });

    $('#agregarActividad').on('click', function(){
        $('#opcionesPrincipales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').show();
        $('#formEditarActividad').hide();
        $('#actividadAgregar').focus(); 
    });

    $('#aceptarAgregarProblematica').on('click', function(){
        var problematica = $('#problematicaAgregar');
        var valor = $('#valorAgregar');
        var objetivos = $('#objetivosAgregar');
        var acciones = $('#accionesAgregar');
        if(!problematica.val() || !valor.val() || !objetivos.val() || !acciones.val()){
            window.alert('Debes llenar todos los campos para agregar una problemática');
        }else{
            problematicas.push({problematica: problematica.val(), valor: valor.val(), objetivos: objetivos.val(), acciones: acciones.val()});
            limpiarFormAgregarProblematica();
            actualizarTablaProblematicas();
            $('#opcionesPrincipales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();       
            $('#formAgregarActividad').hide();
            $('#formEditarActividad').hide();
        }
    });

    $('#cancelarAgregarProblematica').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').hide();
        limpiarFormAgregarProblematica();
    });

    function actualizarTablaProblematicas(){
        var tabla = $('#tablaProblematicas');
        var cabecera = '<tr>';
        cabecera += '<th>Problemática</th>';
        cabecera += '<th>Valor asignado</th>';
        cabecera += '<th>Objetivos</th>';
        cabecera += '<th>Acciones</th>';
        tabla.html(cabecera);
        for(var i = 0; i<problematicas.length; i++){
            var problematica = problematicas[i];
            var row = '<tr data-id-tabla="'+i+'">';
            row += '<td>'+problematica['problematica']+'</td>';
            row += '<td>'+problematica['valor']+'</td>';
            row += '<td>'+problematica['objetivos']+'</td>';
            row += '<td>'+problematica['acciones']+'</td>';
            row += '<td><button class="editarProb"> Editar</button></td>';
            row += '<td><button class="eliminarProb"> Eliminar</button></td>';
            tabla.append(row);
        }
    }

    function limpiarFormAgregarProblematica(){
        $('#problematicaAgregar').val('');
        $('#valorAgregar').val('');
        $('#objetivosAgregar').val('');
        $('#accionesAgregar').val('');
    }

    $('#tablaProblematicas').on('click', '.editarProb', function(e){
        var idString = $(this).parent().parent().attr('data-id-tabla');
        idProblematicaEditar = parseInt(idString);
        problematicaEditar = problematicas[idProblematicaEditar];
        editarProblematica();
    });

    function editarProblematica(){
        $('#opcionesPrincipales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').show();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').hide();
        $('#problematicaEditar').val(problematicaEditar['problematica']);
        $('#valorEditar').val(problematicaEditar['valor']);
        $('#objetivosEditar').val(problematicaEditar['objetivos']);
        $('#accionesEditar').val(problematicaEditar['acciones']);
        $('#problematicaEditar').focus();
    }

    $('#aceptarEditarProblematica').on('click', function(){
        var problematica = $('#problematicaEditar');
        var valor = $('#valorEditar');
        var objetivos = $('#objetivosEditar');
        var acciones = $('#accionesEditar');
        if(!problematica.val() || !valor.val() || !objetivos.val() || !acciones.val()){
            window.alert('Debes llenar todos los campos para editar la problemática');
        }else{
            problematicas[idProblematicaEditar]['problematica'] = problematica.val();
            problematicas[idProblematicaEditar]['valor'] = valor.val();
            problematicas[idProblematicaEditar]['objetivos'] = objetivos.val();
            problematicas[idProblematicaEditar]['acciones'] = acciones.val();
            actualizarTablaProblematicas();
            $('#opcionesPrincipales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();       
            $('#formAgregarActividad').hide();
            $('#formEditarActividad').hide();
            limpiarFormEditarProblematica();
        }
    });

    $('#cancelarEditarProblematica').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').hide();
        limpiarFormEditarProblematica();
    });

    function limpiarFormEditarProblematica(){
        $('#problematicaEditar').val('');
        $('#valorEditar').val('');
        $('#objetivosEditar').val('');
        $('#accionesEditar').val('');
    }

    $('#tablaProblematicas').on('click', '.eliminarProb', function(e){
        var idString = $(this).parent().parent().attr('data-id-tabla');
        var id = parseInt(idString);
        var eliminar = window.confirm('¿Estás seguro que deseas eliminar este elemento de la lista?');
        if(eliminar == true){
            problematicas.splice(id, 1);
            actualizarTablaProblematicas();
            limpiarFormEditarProblematica();
            limpiarFormAgregarProblematica();
            $('#opcionesPrincipales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();       
            $('#formAgregarActividad').hide();
            $('#formEditarActividad').hide();
        }
    });

    $('#aceptarAgregarActividad').on('click', function(){
        var actividad = $('#actividadAgregar');
        var mes1 = $('#mes1Agregar');
        var mes2 = $('#mes2Agregar');
        var mes3 = $('#mes3Agregar');
        var mes4 = $('#mes4Agregar');
        var mes5 = $('#mes5Agregar');
        var mes6 = $('#mes6Agregar');
        if(!actividad.val()){
            window.alert('Tienes que especificar la actividad');
        }else{
            if(!mes1.val() && !mes2.val() && !mes3.val() && !mes4.val() && !mes5.val() && !mes6.val()){
                window.alert('Tienes que seleccionar al menos un mes para realizar la actividad');
            }else{
                actividades.push({accion: actividad.val(), mes1: mes1.val(), mes2: mes2.val(), mes3: mes3.val(), 
                    mes4: mes4.val(), mes5: mes5.val(), mes6: mes6.val()});
                $('#opcionesPrincipales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();       
                $('#formAgregarActividad').hide();
                $('#formEditarActividad').hide();
                actualizarTablaActividades();
                limpiarFormAgregarActividad();
            }   
        }
    });

    function actualizarTablaActividades(){
        var tabla = $('#tablaActividades');
        var cabecera = '<tr>';
        cabecera += '<th>Actividades</th>';
        cabecera += '<th>Mes 1</th>';
        cabecera += '<th>Mes 2</th>';
        cabecera += '<th>Mes 3</th>';
        cabecera += '<th>Mes 4</th>';
        cabecera += '<th>Mes 5</th>';
        cabecera += '<th>Mes 6</th>';
        cabecera += '<th>Editar</th>';
        cabecera += '<th>Eliminar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i <actividades.length; i++){
            var row = '<tr data-id-tabla="'+i+'">';
            row += '<td>'+actividades[i]['accion']+'</td>';
            row += '<td>'+actividades[i]['mes1']+'</td>';
            row += '<td>'+actividades[i]['mes2']+'</td>';
            row += '<td>'+actividades[i]['mes3']+'</td>';
            row += '<td>'+actividades[i]['mes4']+'</td>';
            row += '<td>'+actividades[i]['mes5']+'</td>';
            row += '<td>'+actividades[i]['mes6']+'</td>';
            row += '<td><button class="editarAct">Editar</button></td>';
            row += '<td><button class="eliminarAct">Eliminar</button></td>';
            row += '</tr>';
            tabla.append(row);
        }
    }

    function limpiarFormAgregarActividad(){
        $('#actividadAgregar').val('');
        $('#mes1Agregar').val('');
        $('#mes2Agregar').val('');
        $('#mes3Agregar').val('');
        $('#mes4Agregar').val('');
        $('#mes5Agregar').val('');
        $('#mes6Agregar').val('');
    }

    $('#tablaActividades').on('click', '.editarAct', function(e){
        var idString = $(this).parent().parent().attr('data-id-tabla');
        idActividadEditar = parseInt(idString);
        actividadEditar = actividades[idActividadEditar];
        editarActividad();
    });

    function editarActividad(){
        $('#actividadEditar').val(actividadEditar['accion']);
        $('#mes1Editar').val(actividadEditar['mes1']);
        $('#mes2Editar').val(actividadEditar['mes2']);
        $('#mes3Editar').val(actividadEditar['mes3']);
        $('#mes4Editar').val(actividadEditar['mes4']);
        $('#mes5Editar').val(actividadEditar['mes5']);
        $('#mes6Editar').val(actividadEditar['mes6']);
        $('#opcionesPrincipales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').show();
        $('#actividadEditar').focus();
    }

    $('#cancelarEditarActividad').on('click', function(){
        $('#opcionesPrincipales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();       
        $('#formAgregarActividad').hide();
        $('#formEditarActividad').hide();   
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

    $('#aceptarEditarActividad').on('click', function(){
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
                window.alert('Tienes que seleccionar al menos un mes para la actividad');
            }else{
                actividades[idActividadEditar]['accion'] = actividad.val();
                actividades[idActividadEditar]['mes1'] = mes1.val();
                actividades[idActividadEditar]['mes2'] = mes2.val();
                actividades[idActividadEditar]['mes3'] = mes3.val();
                actividades[idActividadEditar]['mes4'] = mes4.val();
                actividades[idActividadEditar]['mes5'] = mes5.val();
                actividades[idActividadEditar]['mes6'] = mes6.val();
                $('#opcionesPrincipales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();       
                $('#formAgregarActividad').hide();
                $('#formEditarActividad').hide();   
                limpiarFormEditarActividad();
                actualizarTablaActividades();
            }
        }
    });

    $('#tablaActividades').on('click', '.eliminarAct', function(e){
        var idString = $(this).parent().parent().attr('data-id-tabla');
        var indice = parseInt(idString);
        var eliminar = window.confirm('¿Estás seguro que deseas eliminar este elemento de la lista?');
        if(eliminar == true){
            actividades.splice(indice,1);
            actualizarTablaActividades();
            $('#opcionesPrincipales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();       
            $('#formAgregarActividad').hide();
            $('#formEditarActividad').hide();   
        }
    });

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaPlanesAccionTutorialEditar.php"
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
