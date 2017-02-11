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
    $idGrupo = $_POST['idGrupo'];
    $grupo = $conn->getGrupoporId($idGrupo);
    $periodos = $conn->getListaPeriodos();
    $tutores = $conn->getListaTutores();
    ?>

    <h2>Editar Grupo</h2>
    <form id="formulario">
        <label for = "nombre">
            Nombre : *
        </label>
        <input type="text" name = "nombre" id="txtNombre" value="<?php echo($grupo[1]) ?>"/></br>
        <label for = "lugarTutoria">
            Lugar tutoría : 
        </label>
        <input type="text" name = "lugarTutoria" id="txtLugarTutoria" value="<?php echo($grupo[2]) ?>"/></br>
        <label>
            Periodo : *
        </label>
        <select id= "selectPeriodo">
            <option value = "0">
                Selecciona una opción
            </option>
            <?php
            foreach ($periodos as $periodo) {
                if ($periodo['id'] == $grupo[3]) {
                    echo '<option value = "' . $periodo['id'] . '" selected>';
                } else {
                    echo '<option value = "' . $periodo['id'] . '">';
                }
                echo $periodo['identificador'];
                echo '</option>';
            }
            ?>
        </select> </br>

        <label for = "selectTutor1">
            Primer tutor : 
        </label>
        <select id= "selectTutor1">
            <option value = "0">
                Selecciona una opción
            </option>
            <?php
            foreach ($tutores as $tutor) {
                if ($tutor['id'] == $grupo[4]) {
                    echo '<option value = "' . $tutor['id'] . '" selected>';
                } else {
                    echo '<option value = "' . $tutor['id'] . '">';
                }
                echo $tutor['nombre'] . ' ';
                echo $tutor['apPaterno'] . ' ';
                echo $tutor['apMaterno'];
                echo '</option>';
            }
            ?>
        </select> </br>
        <label for = "selectTutor2">
            Segundo tutor : 
        </label>
        <select id= "selectTutor2">
            <option value = "0">
                Selecciona una opción
            </option>
            <?php
            foreach ($tutores as $tutor) {
                if ($tutor['id'] == $grupo[5]) {
                    echo '<option value = "' . $tutor['id'] . '" selected>';
                } else {
                    echo '<option value = "' . $tutor['id'] . '">';
                }
                echo $tutor['nombre'] . ' ';
                echo $tutor['apPaterno'] . ' ';
                echo $tutor['apMaterno'];
                echo '</option>';
            }
            ?>
        </select> </br>
        <label for = "horario">
            Horario : 
        </label>
        <input type="text" name = "horario" id="txtHorario" value="<?php echo($grupo[6]) ?>"/></br> 
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

        var grupo = <?php echo json_encode($grupo); ?>;
        $("#formulario").submit(function (e) {
            return false;
        });

        function cancelar() {
            irALista();
        }

        function guardar() {
            var nombre = $("#txtNombre");
            var lugarTutoria = $("#txtLugarTutoria");
            var periodoSeleccionado = $("#selectPeriodo option:selected");
            var tutor1Seleccionado = $("#selectTutor1 option:selected");
            var tutor2Seleccionado = $("#selectTutor2 option:selected");
            var horario = $("#txtHorario");
            if (!nombre.val() || !periodoSeleccionado.val()) {
                window.alert("Todos los campos con * son obligatorios");
            } else {
                var idPeriodo = parseInt(periodoSeleccionado.val());
                var idTutor1 = parseInt(tutor1Seleccionado.val());
                var idTutor2 = parseInt(tutor2Seleccionado.val());

                if (idPeriodo > 0) {

                    var txtEstado = $("#txtEstado");
                    var btnGuardar = $("#btnGuardar");
                    var btnCancelar = $("#btnCancelar");
                    txtEstado.html("Cargando...");
                    txtEstado.show();
                    btnCancelar.hide();
                    btnGuardar.hide();
                    $.ajax({
                        method: "POST",
                        url: "Conexiones/Grupos/editarGrupo.php",
                        data: {idGrupo: <?php echo($idGrupo)?> , nombre: nombre.val(), lugarTutoria: lugarTutoria.val(), idPeriodo: idPeriodo, idTutor1: idTutor1,
                            idTutor2: idTutor2, horario: horario.val()}
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
                } else {
                    window.alert("Debes seleccionar un periodo");
                }
            }
        }

        function irALista() {
            $.ajax({
                method: "POST",
                url: "getListaGruposEditar.php"
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

