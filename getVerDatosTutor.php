<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();
    ?>
    <h2>DATOS DEL DOCENTE TUTOR</h2>
    <?php
    $idTutor = intval($_POST['idTutor']);
    $tutor = $conn->getTutor($idTutor);
    ?>

    <p><strong>Nombres: </strong><?php echo($tutor['nombres'] . ' ' . $tutor['apPaterno'] . ' ' . $tutor['apMaterno']); ?></p>
    <p><strong>Correo electrónico: </strong><?php echo($tutor['correo']); ?></p>
    <p><strong>Departamento al que está adscrito: </strong><?php echo($tutor['nombreDpto']); ?></p>
    <p><strong>Teléfono: </strong><?php echo($tutor['telefono']); ?></p>
    <p><strong>Lugar tutorías: </strong><?php echo($tutor['lugarTutoria']); ?></p>
    <p><strong>Horario tutorías: </strong><?php echo($tutor['horario']); ?></p>
    <p><strong>Grupo tutorado: </strong><?php echo($tutor['nombreGrupo']); ?></p>
    <button onclick="cancelar()">Volver</button>
    <script>

        function cancelar() {
            $("#mainContenido").hide();
        }
    </script>
</div>
