<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    $carreras = $conn->getListaCarreras();
    $grupos = $conn->getListaGrupos();
    session_start();
    ?>
    <h2>Agregar Alumno</h2>
        <form id="formulario">
            <label for="nombres">Nombres : *</label>
            <input type="text" name = "nombres" id="txtNombre"/></br>
            <label for="apPaterno">Ap. Paterno : *</label>
            <input type="text" name = "apPaterno" id="txtApPaterno"/></br>
            <label for="apMaterno">Ap. Materno : *</label>
            <input type="text" name = "apMaterno" id="txtApMaterno"/></br>
            <label for="correo">Correo : </label>
            <input type="text" name = "correo" id="txtCorreo"/></br>
            <label for="noControl">Número de control : *</label>
            <input type="text" name = "noControl" id="txtNoControl"/></br>
            <label for="nip">NIP : *</label>
            <input type="password" name = "nip" id="txtNip"/></br>
            <label for="nipComp">NIP (de nuevo) : *</label>
            <input type="password" name = "nipComp" id="txtNipComp"/></br>
            <label for="telefono">Teléfono : </label>
            <input type="text" name = "telefono" id="txtTelefono"/></br>
            <label for="ciudad">Ciudad : </label>
            <input type="text" name = "ciudad" id="txtCiudad"/></br>
            <label for="domicilio">Domicilio : </label>
            <input type="text" name = "domicilio" id="txtDomicilio"/></br>
            <label>
                Carrera : *
            </label>
            <select id="selectCarreras">
                <option value="0">-Selecciona una carrera</option>
                <?php 
                    foreach ($carreras as $carrera) {
                        echo '<option value="'.$carrera['id'].'">';
                        echo $carrera['nombre'];
                        echo '</option>';
                    }
                ?>
            </select></br>
            <label>
                Grupo: *
            </label>
            <select id = "selectGrupos">
                <option value = "0">
                    -Selecciona un grupo
                </option>
                <?php 
                    foreach ($grupos as $grupo) {
                        echo '<option value= "'.$grupo['id'].'">';
                        echo $grupo['nombre'];
                        echo '</option>';
                    }
                ?>
            </select></br>
            <h3>
                Datos del Tutor del alumno
            </h3>
            <label for="nombresTutor">Nombre Tutor : </label>
            <input type="text" name = "nombresTutor" id="txtNombreTutor"/></br>
            <label for="domicilioTutor">Domicilio tutor : </label>
            <input type="text" name = "domicilioTutor" id="txtDomicilioTutor"/></br>
            <label for="telefonoTutor">Teléfono Tutor : </label>
            <input type="text" name = "telefonoTutor" id="txtTelefonoTutor"/></br>
            <label for="ciudadTutor">Ciudad Tutor : </label>
            <input type="text" name = "ciudadTutor" id="txtCiudadTutor"/></br>
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
            var apPaterno = $("#txtApPaterno");
            var apMaterno = $("#txtApMaterno");
            var correo = $("#txtCorreo");
            var noControl = $("#txtNoControl");
            var nip = $("#txtNip");
            var nipComp = $("#txtNipComp");
            var telefono = $("#txtTelefono");
            var ciudad = $("#txtCiudad");
            var domicilio = $("#txtDomicilio");
            var nombreTutor = $("#txtNombreTutor");
            var domicilioTutor = $("#txtDomicilioTutor");
            var telefonoTutor = $("#txtTelefonoTutor");
            var ciudadTutor = $("#txtCiudadTutor");
            //nombres, apPat, apMat, nip, idCarrera 
            if(!nombre.val() || !apPaterno.val() || !apMaterno.val() || !nip.val() || !nipComp.val()){
                window.alert("Todos los campos con * son obligatorios");
            }else{
                var carreraSeleccionado = $("#selectCarreras option:selected");
                var idCarrera = parseInt(carreraSeleccionado.val());
                if(idCarrera>0){
                    var grupoSeleccionado = $("#selectGrupos option:selected");
                    var idGrupo = parseInt(grupoSeleccionado.val());
                    if(idGrupo>0){
                        if(nip.val().localeCompare(nipComp.val()) == 0){
                            var txtEstado = $("#txtEstado");
                            var btnGuardar = $("#btnGuardar");
                            var btnCancelar = $("#btnCancelar");
                            txtEstado.html("Cargando...");
                            txtEstado.show();
                            btnCancelar.hide();
                            btnGuardar.hide();
                            $.ajax({
                                method: "POST",
                                url: "Conexiones/Alumnos/guardarAlumno.php",
                                data: {nombre: nombre.val(), apPaterno: apPaterno.val(), apMaterno: apMaterno.val(), 
                                    correo: correo.val(), noControl: noControl.val(), nip: nip.val(), telefono: telefono.val(),
                                    ciudad: ciudad.val(), domicilio: domicilio.val(), nombreTutor: nombreTutor.val(), 
                                    domicilioTutor: domicilioTutor.val(), telefonoTutor: telefonoTutor.val(), ciudadTutor: ciudadTutor.val(),
                                    idCarrera: idCarrera, idGrupo: idGrupo}
                            }).done(function (msg) {
                                alert(msg);
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
                            window.alert("El NIP y la comprobación no concuerdan");
                        }
                    }else{
                        window.alert("Debes seleccionar un grupo");
                    }
                }else{
                    window.alert("Debes seleccionar una carrera");
                }
                
            }
        }

        function irALista(){
             $.ajax({
                method: "POST",
                url: "getListaAlumnosEditar.php"
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
