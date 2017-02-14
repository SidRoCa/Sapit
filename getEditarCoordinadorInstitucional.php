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
    $idCoordinador = $_POST['idCoordinador'];
    $coordinadorInstitucional = $conn->getCoordinadorInstitucionalPorId($idCoordinador);
    ?>
    <h2>Editar Coordinador Institucional</h2>
    <form id="formulario">
        <label for="nombres">Nombre Completo: *</label>
        <input type="text" name = "nombre" id="txtNombre" value="<?php echo($coordinadorInstitucional['nombre']) ?>"/></br>


        <label for = "usuario">
            Usuario : *
        </label>
        <input type="text" name = "usuario" id="txtUsuario" value="<?php echo($coordinadorInstitucional['usuario']) ?>"/></br>
        <label for = "contraseña">
            Contraseña : *
        </label>
        <input type="password" name = "contraseña" id="txtContraseña" value="<?php echo($coordinadorInstitucional['password']) ?>" /></br>
        <label for = "contraseñaComp">
            Contraseña (de nuevo) : *
        </label>
        <input type="password" name = "contraseñaComp" id="txtContraseñaComp" value="<?php echo($coordinadorInstitucional['password']) ?>" /></br>

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
            var idCoordinadorInstitucional = <?php echo($idCoordinador)?>;
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
                            url: "Conexiones/CoordinadoresInstitucionales/editarCoordinadorInstitucional.php",
                            data: {idCoordinador: idCoordinadorInstitucional, nombre: nombre.val(), usuario: usuario.val(), contraseña: contraseña.val()}
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
                                txtEstado.html("Ocurrió un error al guardar el coordinador departamental");
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

