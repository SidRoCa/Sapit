<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    $departamentos = $conn->getListaDepartamentos();
    session_start();
    ?>
    <h2>Agregar Carrera</h2>
        <form id="formulario">
            <label for="nombre_carrera: * ">Nombre</label>
            <input type="text" name = "nombre_carrera" id="txtNombre"/></br>
            <select id="selectDepartamento">
                <option value="0">-Selecciona un departamento</option>
                <?php 
                    foreach ($departamentos as $departamento) {
                        echo '<option value="'.$departamento['id'].'">';
                        echo $departamento['nombre'];
                        echo '</option>';
                    }
                ?>
            </select></br>
            <button onclick="guardar()" id="btnGuardar">
                Aceptar
            </button>
            <button onclick="cancelar()" id="btnCancelar">
                Cancelar
            </button>
            <p id="txtEstado" hidden>
            </p>
        </form>
    
    <script>
        $("#formulario").submit(function(e){
            return false;
        });

        function cancelar() {
            irALista();
        }

        function guardar(){
            var nombre = $("#txtNombre");
            if(!nombre.val()){
                window.alert("Todos los campos con * son obligatorios");
            }else{
                var departamentoSeleccionado = $("#selectDepartamento option:selected");
                var idDepartamento = parseInt(departamentoSeleccionado.val());
                if(idDepartamento>0){
                    var txtEstado = $("#txtEstado");
                    var btnGuardar = $("#btnGuardar");
                    var btnCancelar = $("#btnCancelar");
                    txtEstado.html("Cargando...");
                    txtEstado.show();
                    btnCancelar.hide();
                    btnGuardar.hide();
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Carreras/guardarCarrera.php",
                        data: {nombreCarrera: nombre.val(), idDepartamento: idDepartamento}
                    }).done(function (msg) {
                        if(msg.localeCompare("ok") == 0){
                            irALista();
                        }else{
                            txtEstado.html("Ocurrió un error, inténtalo de nuevo");
                            btnCancelar.show();
                            btnGuardar.show();
                        }
                    }).fail(function (jqXHR, textStatus) {
                        if (textStatus === 'timeout') {
                            txtEstado.html("El servidor no responde, inténtalo de nuevo más tarde");
                        } else {
                            txtEstado.html("Ocurrió un error al guardar el departamento");
                        }
                        btnGuardar.show();
                        btnCancelar.show();
                    });
                }else{
                    window.alert("Debes seleccionar un departamento");
                }
                
            }
        }

        function irALista(){
             $.ajax({
                method: "POST",
                url: "getListaCarrerasEditar.php"
            }).done(function (msg) {
                $("#mainContenido").hide();
                $("#actualizarDatosTutor").hide();
                $("#registroAsistenciaIndividual").hide();
                $("#registroAsistenciaGrupal").hide();
                $("#diagnosticoGrupo").hide();
                $("#planAccionTutorial").hide();
                $("#reporteSemestral").hide();
                $("#actaResultadosObtenidos").hide();
                $("#cartaCompromiso").hide();
                $("#fichaAlumnosTutorados").hide();
                $("#mainContenido").html(msg);
                $("#mainContenido").show();
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    $("#mainContenido").html("El servidor está ocupado, inténtalo más tarde.");
                } else {
                    $("#mainContenido").html("Ocurrió un error inesperado, inténtalo más tarde.");
                }
            });
        }

    </script>
</div>
