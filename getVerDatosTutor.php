<div>
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
    ?>
    <h2>DATOS DEL DOCENTE TUTOR</h2>
    <?php
    $idTutor = intval($_POST['idTutor']);
    $tutor = $conn->getTutorporId($idTutor);
    ?>
   
    <div>
        Nombre : <?php echo($tutor['nombre'].' '.$tutor['apPaterno'].' '.$tutor['apMaterno']); ?></br>
        Correo : <?php echo($tutor['correo']); ?></br>
        Telefono : <?php echo($tutor['telefono']); ?></br>
        Ciudad : <?php echo($tutor['ciudad']); ?></br>
        Domicilio : <?php echo($tutor['domicilio']); ?></br>
        Identificador : <?php echo($tutor['identificador']); ?></br>
    </div>
    <button onclick="cancelar()">Volver</button>
    <script>

        function cancelar() {
            $("#mainContenido").hide();
        }
    </script>
</div>
