<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "admin") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $departamentos = $conn->getListaDepartamentos();
    ?>
    <h2>Agregar Tutor</h2>
        <form id="formulario">
            <label for = "nombres">
                Nombres : *
            </label>
            <input type="text" name = "nombres" id="txtNombre"/></br>
            <label for = "apPaterno">
                Ap. Paterno : *
            </label>
            <input type="text" name = "apPaterno" id="txtApPaterno"/></br>
            <label for = "apMaterno">
                Ap. Materno : *
            </label>
            <input type="text" name = "apMaterno" id="txtApMaterno"/></br>
            <label for = "correo">
                Correo :
            </label>
            <input type="text" name = "correo" id="txtCorreo"/></br>
            <label>
                Departamento : *
            </label>
            <select id= "selectDepartamento">
                <option value = "0">
                    Selecciona una opción
                </option>
                <?php 
                    foreach ($departamentos as $departamento) {
                        echo '<option value = "'.$departamento['id'].'">';
                        echo $departamento['nombre'];
                        echo '</option>';
                    }
                ?>
            </select> </br>
            
            <label for = "telefono">
                Telefono : 
            </label>
            <input type="text" name = "telefono" id="txtTelefono"/></br>
            <label for = "ciudad">
                Ciudad : 
            </label>
            <input type="text" name = "ciudad" id="txtCiudad"/></br>
            <label for = "domicilio">
                Domicilio : 
            </label>
            <input type="text" name = "domicilio" id="txtDomicilio"/></br>
            <label for = "identificador">
                Identificador : *
            </label>
            <input type="text" name = "identificador" id="txtIdentificador"/></br>
            <label for = "nip">
                NIP : *
            </label>
            <input type="password" name = "nip" id="txtNip"/></br>
            <label for = "nipComp">
                NIP (de nuevo) : *
            </label>
            <input type="password" name = "nipComp" id="txtNipComp"/></br>
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
            //nombres, apPat, apMat, idDep, nip, identificador
            var nombre = $("#txtNombre");
            var apPaterno = $("#txtApPaterno");
            var apMaterno = $("#txtApMaterno");
            var correo = $("#txtCorreo");
            var telefono = $("#txtTelefono");
            var ciudad = $("#txtCiudad");
            var domicilio  = $("#txtDomicilio");
            var identificador = $("#txtIdentificador");
            var nip = $("#txtNip");
            var nipComp = $("#txtNipComp");
            if(!nombre.val() || !apPaterno.val() || !apMaterno.val() ||!nip.val() || !identificador.val() || !nipComp.val()){
                window.alert("Todos los campos con * son obligatorios");
            }else{
                if(nip.val().localeCompare(nipComp.val()) == 0){
                    var departamentoSeleccionado = $("#selectDepartamento option:selected");
                    var idDepartamento = parseInt(departamentoSeleccionado.val());
                    if(idDepartamento > 0){
                        var txtEstado = $("#txtEstado");
                        var btnGuardar = $("#btnGuardar");
                        var btnCancelar = $("#btnCancelar");
                        txtEstado.html("Cargando...");
                        txtEstado.show();
                        btnCancelar.hide();
                        btnGuardar.hide();
                        $.ajax({
                            method: "POST",
                            url: "Conexiones/Tutores/guardarTutor.php",
                            data: {nombres: nombre.val(), apPaterno: apPaterno.val(), apMaterno: apMaterno.val(), correo: correo.val(),
                                nip: nip.val(), telefono: telefono.val(), ciudad: ciudad.val(), domicilio: domicilio.val(),
                                identificador: identificador.val(), idDepartamento: idDepartamento}
                        }).done(function (msg) {
                            if(msg.localeCompare("ok") == 0){
                                irALista();
                            }else{
                                alert(msg);
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
                }else{
                    window.alert("EL nip y la comprobación no coinciden");
                }
                
            }
        }
        function irALista(){
             $.ajax({
                method: "POST",
                url: "getListaTutoresEditar.php"
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
