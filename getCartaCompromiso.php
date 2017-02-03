<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    $idGrupo = intval($_POST['idGrupo']);
    $nombreCarrera = $conn->getCarreraGrupo($idGrupo);
    $nombreGrupo = $conn->getGrupo($idGrupo);
    ?>
    <h2>PROGRAMA INSTITUCIONAL DE TUTORÍAS</h2>
    <h2>CARTA-COMPROMISO<br>DOCENTES TUTORES Y ALUMNOS TUTORADOS</h2>
    <p>Por este conducto, y para efectos de llevar a cabo la acción tutorial, se hace constar los <strong>Compromisos que se establecen</strong> entre los actores principales.</p>

    <p>El <strong>alumno tutorado</strong> se compromete a:</p>

    <ol>
        <li>
            Acudir puntualmente a las reuniones convenidas con el Docente-Tutor.
        </li>
        <li>
            Tener presente que el único responsable de su proceso de formación es el propio alumno.
        </li>
        <li>
            Cumplir con los acuerdos derivados de la actividad tutorial. 
        </li>
        <li>
            Participar en los procesos de evaluación tutorial. 
        </li>
        <li>
            Brindar al profesor tutor la información necesaria para localizarlo con facilidad. 
        </li>
        <li>
            Colaborar en crear un ambiente de confianza, respeto y cordialidad.
        </li>
        <li>
            Asistir a todos los eventos a que sea convocado por su Docente Tutor, la Coordinación de Tutorías y/o Departamento de Desarrollo Académico.
        </li>
    </ol>

    <p>El <strong>Docente Tutor</strong> se compromete a:</p>

    <ol>
        <li>
            Acudir puntualmente a las reuniones convenidas con el alumno.
        </li>
        <li>
            Contar con una información básica que pueda ayudar al mejor desempeño del estudiante como: apoyos institucionales existentes asociados a la orientación educativa, los servicios médicos, el trabajo social, la asistencia psicopedagógica, el programa de servicio social, posibilidades de práctica profesional, existencia de becas, sistema de crédito estudiantil, bolsas de trabajo, etc., 
        </li>
        <li>
            Brindar al tutorando los datos necesarios para localizarlo fácilmente.  
        </li>
        <li>
            Ofrecer siempre la disposición de resolver las dudas del alumno y orientarlo en cuestiones de técnicas de estudio, metodología y otras dificultades que obstaculicen su desempeño como estudiante. 
        </li>
        <li>
            Colaborar en crear un ambiente de confianza, respeto y cordialidad.
        </li>
        <li>
            Acudir a los eventos programados por la Coordinación de Tutorías y/o Departamento de Desarrollo Académico.
        </li>
    </ol>

    <p>NOMBRE Y FIRMA DEL (LOS) TUTORES:</p>
    <?php
    $res = $conn->getTutoresGrupo($idGrupo);
    foreach ($res as $tutor) {
        echo ('<p>' . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . " _____________________________</p>");
    }
    $res = $conn->getLugarTutoria($idGrupo);
    echo ('<p>LUGAR Y HORARIO ESTABLECIDOS PARA TUTORÍAS: ' . $res . '</p>');
    ?>


    <table>
        <tr>
            <th></th>
            <th>NOMBRE DEL ALUMNO TUTORADO</th>
            <th>FIRMA</th>
        </tr>
        <?php
        $res = $conn->getAlumnosGrupo($idGrupo);
        $cnt = 1;
        foreach ($res as $alumno) {
            echo ('<tr>');
            echo ('<td>' . $cnt . '</td>');
            echo ('<td>' . $alumno['nombres'] . ' ' . $alumno['ap_paterno'] . ' ' . $alumno['ap_materno'] . '</td>');
            echo ('<td></td>');
            echo ('</tr>');
            $cnt++;
        }
        ?>
    </table>
</div>