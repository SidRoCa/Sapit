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
    ?>
    <h2>Agregar Coordinador Institucional</h2>
    <form id="formulario">
        <label for="nombre">Nombre Completo: *</label>
        <input type="text" name = "nombre" id="txtNombre"/></br>

        <label for = "usuario">
            Usuario : *
        </label>
        <input type="text" name = "usuario" id="txtUsuario"/></br>
        <label for = "contraseña">
            Contraseña : *
        </label>
        <input type="password" name = "contraseña" id="txtContraseña"/></br>
        <label for = "contraseñaComp">
            Contraseña (de nuevo) : *
        </label>
        <input type="password" name = "contraseñaComp" id="txtContraseñaComp"/></br>

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
        $("#formulario").submit(function (e) {
            return false;
        });

        function cancelar() {
            irALista();
        }

        function guardar() {
            var nombre = $("#txtNombre");
            var usuario = $("#txtUsuario");
            var contraseña = $("#txtContraseña");
            var contraseñaComp = $("#txtContraseñaComp");
            if (!nombre.val() || !usuario.val() || !contraseña.val() || !contraseñaComp.val() ){ 
                window.alert("Todos los campos con * son obligatorios");
            } else {
                if (contraseña.val().localeCompare(contraseñaComp.val()) == 0) {
                    

                        var txtEstado = $("#txtEstado");
                        var btnGuardar = $("#btnGuardar");
                        var btnCancelar = $("#btnCancelar");
                        txtEstado.html("Cargando...");
                        txtEstado.show();
                        btnCancelar.hide();
                        btnGuardar.hide();
                        $.ajax({
                            method: "POST",
                            url: "Conexiones/CoordinadoresInstitucionales/guardarCoordinadorInstitucional.php",
                            data: {nombre: nombre.val(), usuario: usuario.val(), contraseña: contraseña.val()}
                        }).done(function (msg) {
                            if (msg.localeCompare("ok") == 0) {
                                irALista();
                            } else {
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
                    
                } else {
                    window.alert("La contraseña y la comprobación no coinciden");
                }
            }
        }
        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaCoordinadoresInstitucionalesEditar.php"
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
