<div id="nnn">
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
    
    $idGrupo = intval($_POST['idGrupo']);
    $nombreCarrera = $conn->getCarreraGrupo($idGrupo);
    $nombreGrupo = $conn->getGrupo($idGrupo);
    ?>
    <h2>PROGRAMA INSTITUCIONAL DE TUTORÍAS<br>ACTA DE RESULTADOS OBTENIDOS</h2>
    <p>Carrera: <?php echo($nombreCarrera); ?> Grupo: <?php echo($nombreGrupo); ?> </p>
    <table>
        <tr>
            <th></th>
            <th>Número de control</th>
            <th>Nombre del estudiante</th>
            <th>Ago-Dic</th>
            <th>Ene-Jun</th>
            <th>Calificación final </th>    
        </tr>
        <?php
        $res = $conn->getAlumnosGrupo($idGrupo);
        $cnt = 1;
        foreach ($res as $alumno) {
            echo ('<tr>');
            echo ('<td>' . $cnt . '</td>');
            echo ('<td>' . $alumno['no_control'] . '</td>');
            echo ('<td>' . $alumno['nombres'] . ' ' . $alumno['ap_paterno'] . ' ' . $alumno['ap_materno'] . '</td>');
            if($alumno['calificacion_final_1'] != null){
                echo ('<td><input type = "text" value = "'.$alumno['calificacion_final_1'].'" disabled></td>');
            }else{
                echo ('<td><input type = "text"></td>');
            }
            if($alumno['calificacion_final_2'] != null){
                echo ('<td><input type = "text" value = "'.$alumno['calificacion_final_2'].'" disabled></td>');
            }else{
                echo ('<td><input type = "text"></td>');
            }
            echo ('<td><input type = "text"></td>');
            echo ('</tr>');
            $cnt++;
        }
        // select alumnos.nombres, alumnos.ap_paterno, alumnos.ap_materno, alumnos.correo, alumnos.no_control, alumnos.nip, alumnos.telefono, alumnos.domicilio, alumnos.ciudad, carreras.nombre, alumnos.nombres_tutor, alumnos.telefono_tutor, alumnos.domicilio_tutor,  alumnos.ciudad_tutor from alumnos, carreras, det_grupos, grupos where alumnos.id = det_grupos.id_alumno and det_grupos.id_grupo = 1
        ?>
    </table>
    <p>Firma del tutor                                 Firma del tutor</p>
    <p>_______________                                 _______________</p>

    <button onclick="volver()">Volver</button>

    <script>
        function volver() {
            $("#nnn").hide();
            $("#actaResultadosObtenidos").show();
        }
    </script>
</div>