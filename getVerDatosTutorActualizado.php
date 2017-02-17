<div id="mainContenido">
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }

    $idTutor = ($_POST['idTutor']);
    $nombres = ($_POST['nombre']);
    $apPaterno = ($_POST['apPaterno']);
    $apMaterno = ($_POST['apMaterno']);
    $correo = ($_POST['correo']);
    $telefono = ($_POST['telefono']);
    $ciudad = ($_POST['ciudad']);
    $domicilio = ($_POST['domicilio']);
    $identificador = ($_POST['identificador']);
    $nip = ($_POST['nip']);
    $identificadorAnterior = ($_POST['identificadorAnterior']);
    $nipAnterior = ($_POST['nipAnterior']);

    $res = $conn->actualizarDatosTutor($idTutor, $nombres, $apPaterno, $apMaterno, $correo, $telefono, $ciudad, $domicilio, $identificador, $nip, $identificadorAnterior, $nipAnterior);
    if ($res) {
        echo('Exito!');
    } else {
        echo('Error');
    }
    ?>
    Nombre : <?php echo($nombres . ' ' . $apPaterno . ' ' . $apMaterno); ?></br>
    Correo : <?php echo($correo); ?></br>
    Telefono : <?php echo($telefono); ?></br>
    Ciudad : <?php echo($ciudad); ?></br>
    Domicilio : <?php echo($domicilio); ?></br>
    Identificador : <?php echo($identificador); ?></br>
    
    <button onclick="volver()">Volver</button>
    <script>

        function volver() {
            $("#mainContenido").hide();
        }

    </script>
</div>
