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
    <h2>Agregar Periodo</h2>
        <form id="formulario">
            <label for="nombre_periodo">Nombre: </label>
            <input type="text" name = "nombre_periodo" id="txtNombre" required/><br>
            <label for="fecha_inicio">Fecha de inicio: </label>
            <input type="date" name = "fecha_inicio" id="dteFechaInicio" required/><br>
            <label for="fecha_fin">Fecha de fin: </label>
            <input type="date" name = "fecha_fin" id="dteFechaFin" required/><br>
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
            var fechaInicio = $("#dteFechaInicio");
            var fechaFin = $("#dteFechaFin");
            
            if(!nombre.val() || !fechaInicio.val() || !fechaFin.val()){
                window.alert("Todos los campos con * son obligatorios");
            }else{
                var txtEstado = $("#txtEstado");
                var btnGuardar = $("#btnGuardar");
                var btnCancelar = $("#btnCancelar");
                txtEstado.html("Cargando...");
                txtEstado.show();
                btnCancelar.hide();
                btnGuardar.hide();
                
                $.ajax({
                    method: "POST",
                    url: "Conexiones/Periodos/guardarPeriodo.php",
                    data: {nombrePeriodo: nombre.val(), fechaInicio: fechaInicio.val(), fechaFin: fechaFin.val()}
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
                        txtEstado.html("Ocurrió un error al guardar el periodo");
                    }
                    btnGuardar.show();
                    btnCancelar.show();
                });
            }
        }
        function irALista(){
             $.ajax({
                method: "POST",
                url: "getListaPeriodosEditar.php"
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
