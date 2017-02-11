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

    <h2>FICHA DE IDENTIFICACIÓN DE LOS ALUMNOS TUTORADOS</h2>
    <p><strong>NOMBRE DEL(LOS) DOCENTE(S) TUTOR(ES)</strong></p> <?php
    $idGrupo = intval($_POST['idGrupo']);
    $res = $conn->getTutoresGrupo($idGrupo);
    foreach ($res as $tutor) {
        echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
    }
    ?>
    <p><strong>Grupo:</strong><?php
        $res = $conn->getGrupo($idGrupo);
        echo($res);
        ?></p>

    <p><strong>Semestre:</strong><?php
        $res = $conn->getPeriodo($idGrupo);
        echo($res);
        ?></p>

    <?php
    echo "<table>
        <tr>
            <th>Nombre del alumno</th>
            <th>Correo electrónico</th>
            <th>No. de control</th>
            <th>NIP</th>
            <th>Teléfono</th>
            <th>Domicilio</th>
            <th>Ciudad</th>    
            <th>Carrera</th>    
            <th>Nombre de los padres y/o tutor</th>
            <th>Domicilio tutor</th>
            <th>teléfono tutor</th>
            <th>Ciudad tutor</th>    
        </tr>";

    $res = $conn->getAlumnosGrupo($idGrupo);
    foreach ($res as $alumno) {
        echo ('<tr>');
        echo ('<td>' . $alumno['nombres'] . ' ' . $alumno['ap_paterno'] . ' ' . $alumno['ap_materno'] . '</td>');
        echo ('<td>' . $alumno['correo'] . '</td>');
        echo ('<td>' . $alumno['no_control'] . '</td>');
        echo ('<td>' . $alumno['nip'] . '</td>');
        echo ('<td>' . $alumno['telefono'] . '</td>');
        echo ('<td>' . $alumno['domicilio'] . '</td>');
        echo ('<td>' . $alumno['ciudad'] . '</td>');
        echo ('<td>' . $alumno['nombre'] . '</td>');
        echo ('<td>' . $alumno['nombres_tutor'] . '</td>');
        echo ('<td>' . $alumno['domicilio_tutor'] . '</td>');
        echo ('<td>' . $alumno['telefono_tutor'] . '</td>');
        echo ('<td>' . $alumno['ciudad_tutor'] . '</td>');
        echo ('</tr>');
    }
    // select alumnos.nombres, alumnos.ap_paterno, alumnos.ap_materno, alumnos.correo, alumnos.no_control, alumnos.nip, alumnos.telefono, alumnos.domicilio, alumnos.ciudad, carreras.nombre, alumnos.nombres_tutor, alumnos.telefono_tutor, alumnos.domicilio_tutor,  alumnos.ciudad_tutor from alumnos, carreras, det_grupos, grupos where alumnos.id = det_grupos.id_alumno and det_grupos.id_grupo = 1

    echo "</table>";
    ?>


</div>