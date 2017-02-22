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
    $plan = $conn->getPlanDesarrollarDiagnosticoDepartamentalPorId($idPlan);
    $nombreCoordinador = $_SESSION['nombre_usuario'];
    $grupos = $conn->getGruposDpto($plan['idDepartamento']);
    ?>
    <h2>
        Planeación para desarrollar el diagnóstico departamental
    </h2>
    <label>
        Departamento : 
    </label>
    <input type = "text" value= "<?php echo $plan['departamento']?>"/>
    <label>
        Fecha :
    </label>
    <input type = "text" value = "<?php echo $plan['fecha']?>"/>
    <table id = "tabla">
        <tr>
            <th>
                Problema
            </th>
            <?php 
                foreach ($grupos as $grupo) {
                    echo '<th>Grupo: '.$grupo['nombre'].'</th>';
                }
            ?>
            <th>
                Editar
            </th>
            <th>
                Eliminar
            </th>
        </tr>
        <?php 
            $problemas = $plan[0];
            $cont = 0;
            foreach ($problemas as $problema) {
                echo '<tr data-indice-tabla="'.$cont.'">';
                echo '<td>'.$problema['problema'].'</td>';
                $det = $problema[0];
                foreach ($grupos as $grupo) {
                    $rowAux = '<td></td>';
                    foreach ($det as $row) {
                        if($grupo['id'] == $row['idGrupo']){
                            $rowAux = '<td>'.$row['valor'].'</td>';
                        }
                    }
                    echo $rowAux;
                }
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
        <button id = "nuevoProblema">
            Agregar nueva problemática
        </button>
    </div>
    <div id = "formAgregarProblematica" hidden>
        <h3>
            Agregar problemática
        </h3>
        <label>
            Problema :
        </label>
        <input type = "text" id = "problemaAgregar"><br>
         <p>
            Indica los valores en los grupos correspondientes
        </p>
        <?php 
            $cont = 0;
            foreach ($grupos as $grupo) {
                echo '<label>'.$grupo['nombre'].' : </label>';
                echo '<input type = "text" class="grupoInput" data-id-grupo="'.$cont.'"><br>';
                $cont++;
            }

        ?>
        <button id = "aceptarAgregar">
            Agregar
        </button>
        <button id = "cancelarAgregar">
            Cancelar
        </button>
    </div>
    <div id = "formEditarProblematica" hidden>
        <h3>
            Editar problemática
        </h3>
        <label>
            Problema :
        </label>
        <input type = "text" id = "problemaEditar"><br>
         <p>
            Indica los valores en los grupos correspondientes
        </p>
        <?php 
            $cont = 0;
            foreach ($grupos as $grupo) {
                echo '<label>'.$grupo['nombre'].' : </label>';
                echo '<input type = "text" class="grupoInput" data-id-grupo="'.$cont.'"><br>';
                $cont++;
            }

        ?>
        <button id = "aceptarEditar">
            Guardar cambios
        </button>
        <button id = "cancelarEditar">
            Cancelar
        </button>
    </div>
</div>
<script>
    var problemas = <?php echo json_encode($problemas)?>;
    var problemasAneriores = <?php echo json_encode($problemas)?>;
    var grupos = <?php echo json_encode($grupos)?>;
    var idProblematicaEditar;
    var problematicaEditar;
    $('#aceptar').on('click', function(){
        if(problemas.length>0){
            $.ajax({
                method: "POST",
                url: "Conexiones/PlanesAccionDesarrollarDiagnosticoDepartamental/editarPlanAccionDesarrollarDiagnosticoDepartamental.php",
                data: {idPlan: <?php echo $idPlan;?>, problematicas: problemas, problematicasAnteriores: problemasAneriores}
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
            window.alert('Debes agregar al menos una problemática');
        }
    });

    $('#cancelar').on('click', function(){
        irALista();
    });

    $('#nuevoProblema').on('click', function(){
        limpiarFormAgregarProblematica();
        limpiarFormEditarProblematica();
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').show();
        $('#formEditarProblematica').hide();
        $('#problemaAgregar').focus();
    });

    $('#aceptarAgregar').on('click', function(){
        var problema = $('#problemaAgregar');
        if(!problema.val()){
            window.alert('Tienes que especificar la problemática');
        }else{
            var seguir = false;
            var gruposInput = $('#formAgregarProblematica .grupoInput');
            gruposInput.each(function(){
                if(seguir == false){
                    if(!$(this).val()){
                        seguir = false;
                    }else{
                        seguir = true;
                    }   
                }
            });
            if(seguir == true){
                var gruposAux = Array();
                gruposInput.each(function(){
                    var input = $(this);
                    var idString = input.attr('data-id-grupo');
                    var id = parseInt(idString);
                    var grupo = grupos[id];
                    if(!(!input.val())){
                        gruposAux.push({idGrupo: grupo['id'], nombreGrupo: grupo['nombre'], valor: input.val()});
                    }
                });
                problemas.push({0: gruposAux, id: 0, problema: problema.val()});
                actualizarTabla();
                limpiarFormAgregarProblematica();
                limpiarFormEditarProblematica();
                $('#opcionesGenerales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();
            }else{
                window.alert('Debes especificar al menos un valor en un grupo');
            }
        }
    });

    function actualizarTabla(){
        var tabla = $('#tabla');
        var cabecera = '<tr>';
        cabecera += '<th>Problema</th>';
        for(var i = 0; i<grupos.length; i++){
            cabecera += '<th>Grupo: '+grupos[i]['nombre']+'</th>';
        }
        cabecera += '<th>Editar</th>';
        cabecera += '<th>Eliminar</th>';
        cabecera += '</tr>';
        tabla.html(cabecera);
        for(var i = 0; i<problemas.length; i++){
            var problema = problemas[i];
            var gruposAux = problema["0"];
            var row = '<tr data-indice-tabla="'+i+'">';
            row += '<td>'+problema['problema']+'</td>';
            for(var j = 0; j<grupos.length; j++){
                var rowAux = '<td></td>';
                for(var k = 0; k<gruposAux.length; k++){
                    if(grupos[j]['id'] == gruposAux[k]['idGrupo']){
                        rowAux = '<td>'+gruposAux[k]['valor']+'</td>';
                    }
                }
                row += rowAux;
            }
            row+= '<td><button class="editar">Editar</button></td>';
            row+= '<td><button class="eliminar">Eliminar</button></td>';
            row+='</tr>';
            tabla.append(row);
        }
    }

    function limpiarFormAgregarProblematica(){
        $('#problemaAgregar').val('');
        $('#formAgregarProblematica .grupoInput').each(function(){
            $(this).val('');
        });
    }

    $('#tabla').on('click', '.editar', function(){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        idProblematicaEditar = parseInt(idString);
        problematicaEditar = problemas[idProblematicaEditar];
        editarProblematica();
    });

    function editarProblematica(){
        limpiarFormAgregarProblematica();
        limpiarFormEditarProblematica();
        $('#opcionesGenerales').hide();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').show();
        $('#problemaEditar').val(problematicaEditar['problema']);
        var gruposAux = problematicaEditar["0"];
        $('#formEditarProblematica .grupoInput').each(function(){
            var input = $(this);
            var id = parseInt(input.attr('data-id-grupo'));
            var grupoAux = grupos[id];
            for(var i = 0; i<gruposAux.length; i++){
                if(gruposAux[i]['idGrupo'] == grupoAux['id']){
                    input.val(gruposAux[i]['valor']);
                    break;
                }
            }
        });
    }

    function limpiarFormEditarProblematica(){
        $('#problemaEditar').val('');
        $('#formEditarProblematica .grupoInput').each(function(){
            $(this).val('');
        });
    }

    $('#cancelarEditar').on('click', function(){
        limpiarFormAgregarProblematica();
        limpiarFormEditarProblematica();
        $('#opcionesGenerales').show();
        $('#formAgregarProblematica').hide();
        $('#formEditarProblematica').hide();
    });

    $('#aceptarEditar').on('click', function(){
       var problema = $('#problemaEditar');
        if(!problema.val()){
            window.alert('Tienes que especificar la problemática');
        }else{
            var seguir = false;
            var gruposInput = $('#formEditarProblematica .grupoInput');
            gruposInput.each(function(){
                if(seguir == false){
                    if(!$(this).val()){
                        seguir = false;
                    }else{
                        seguir = true;
                    }   
                }
            });
            if(seguir == true){
                var gruposAux = Array();
                gruposInput.each(function(){
                    var input = $(this);
                    var idString = input.attr('data-id-grupo');
                    var id = parseInt(idString);
                    var grupo = grupos[id];
                    if(!(!input.val())){
                        gruposAux.push({idGrupo: grupo['id'], nombreGrupo: grupo['nombre'], valor: input.val()});
                    }
                });
                problemas[idProblematicaEditar]["0"] = gruposAux;
                problemas[idProblematicaEditar]["id"] = 0;
                problemas[idProblematicaEditar]["problema"] = problema.val();
                actualizarTabla();
                limpiarFormAgregarProblematica();
                limpiarFormEditarProblematica();
                $('#opcionesGenerales').show();
                $('#formAgregarProblematica').hide();
                $('#formEditarProblematica').hide();
            }else{
                window.alert('Debes especificar al menos un valor en un grupo');
            }
        } 
    });
    
    $('#tabla').on('click', '.eliminar', function(){
        var idString = $(this).parent().parent().attr('data-indice-tabla');
        var id = parseInt(idString);
        var eliminar = window.confirm('¿Estás seguro que deseas eliminar este elemento?');
        if(eliminar == true){
            problemas.splice(id, 1);
            actualizarTabla();
            limpiarFormAgregarProblematica();
            limpiarFormEditarProblematica();
            $('#opcionesGenerales').show();
            $('#formAgregarProblematica').hide();
            $('#formEditarProblematica').hide();
        }
    });

    function irALista(){
        $.ajax({
            method: "POST",
            url: "getListaPlanesDesarrollarDiagnosticoDepartamentalEditar.php"
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
