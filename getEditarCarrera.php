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
    $idCarrera = $_POST['idCarrera'];
    $carrera = $conn->getCarreraPorId($idCarrera);
    $departamentos = $conn->getListaDepartamentos();
    ?>
    <h2>Editar departamento</h2>
    <form id = "formulario">
        <label for = "nombre">
            Nombre: *
        </label>
        <input type="text" name = "nombre" id="txtNombre" value = "<?php echo $carrera[1] ?>"> </br>
        <select id = "selectDepartamento">
            <?php
            foreach ($departamentos as $departamento) {
                if ($departamento['id'] == $carrera[2]) {
                    echo '<option value = "' . $departamento['id'] . '" selected>';
                } else {
                    echo '<option value = "' . $departamento['id'] . '">';
                }
                echo $departamento['nombre'];
                echo '</option>';
            }
            ?>
        </select></br> 
        <button id="btnGuardar" onclick = "guardar()">
            Guardar
        </button>
        <button id="btnCancelar" onclick = "cancelar()">
            Cancelar
        </button>
        <p id = "txtEstado">

        </p>
    </form>
    <script>

        var carrera = <?php echo json_encode($carrera); ?>;
        $("#formulario").submit(function (e) {
            return false;
        });

        function cancelar() {
            irALista();
        }

        function guardar() {
            var nombre = $("#txtNombre");
            if (!nombre.val()) {
                window.alert("Todos los campos con * son obligatorios");
            } else {
                var departamentoSeleccionado = parseInt($("#selectDepartamento option:selected").val());
                var txtEstado = $("#txtEstado");
                var btnGuardar = $("#btnGuardar");
                var btnCancelar = $("#btnCancelar");
                txtEstado.html("Cargando...");
                txtEstado.show();
                btnCancelar.hide();
                btnGuardar.hide();
                $.ajax({
                    method: "POST",
                    url: "Conexiones/Carreras/editarCarrera.php",
                    data: {idCarrera: carrera[0], nombreCarrera: nombre.val(), idDepartamento: departamentoSeleccionado}
                }).done(function (msg) {
                    if (msg.localeCompare("ok") == 0) {
                        irALista();
                    } else {
                        window.alert(msg);
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
            }
        }

        function irALista() {
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
