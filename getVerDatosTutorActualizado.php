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
    $nombres = ($_POST['nombres']);
    $apPaterno = ($_POST['apPaterno']);
    $apMaterno = ($_POST['apMaterno']);
    $correo = ($_POST['correo']);
    $telefono = ($_POST['telefono']);
    $lugar = ($_POST['lugar']);
    $horario = ($_POST['horario']);

    $res = $conn->actualizarDatosTutor($idTutor, $nombres, $apPaterno, $apMaterno, $correo, $telefono, $lugar, $horario);
    if ($res) {
        echo('Exito!');
        $idTutor = intval($_POST['idTutor']);
        $tutor = $conn->getTutor($idTutor);
    } else {
        echo('Error');
    }
    ?>


    <h2>DATOS DEL DOCENTE TUTOR</h2>
    <p><strong>Nombres: </strong><?php echo($tutor['nombres'] . ' ' . $tutor['apPaterno'] . ' ' . $tutor['apMaterno']); ?></p>
    <p><strong>Correo electrónico: </strong><?php echo($tutor['correo']); ?></p>
    <p><strong>Departamento al que está adscrito: </strong><?php echo($tutor['nombreDpto']); ?></p>
    <p><strong>Teléfono: </strong><?php echo($tutor['telefono']); ?></p>
    <p><strong>Lugar tutorías: </strong><?php echo($tutor['lugarTutoria']); ?></p>
    <p><strong>Horario tutorías: </strong><?php echo($tutor['horario']); ?></p>
    <p><strong>Grupo tutorado: </strong><?php echo($tutor['nombreGrupo']); ?></p>
    <button onclick="volver()">Volver</button>
    <script>

        function volver() {
            $("#mainContenido").hide();
        }

    </script>
</div>
