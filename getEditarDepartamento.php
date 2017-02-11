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
    session_start();
    $idDepartamento = $_POST['idDepartamento'];
    $departamento = $conn->getDepartamentoPorId($idDepartamento);
    ?>
    <h2>Editar departamento</h2>
    <form id = "formulario">
        <input type="text" id="txtNombre" value = "<?php echo $departamento[1] ?>">
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

        var departamento = <?php echo json_encode($departamento); ?>;
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
                var txtEstado = $("#txtEstado");
                var btnGuardar = $("#btnGuardar");
                var btnCancelar = $("#btnCancelar");
                txtEstado.html("Cargando...");
                txtEstado.show();
                btnCancelar.hide();
                btnGuardar.hide();
                $.ajax({
                    method: "POST",
                    url: "Conexiones/Departamentos/editarDepartamento.php",
                    data: {idDepartamento: departamento[0], nombreDepartamento: nombre.val()}
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
            }
        }

        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaDepartamentosEditar.php"
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
