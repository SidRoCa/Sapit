<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $idDiagnostico = $_POST['idDiagnostico'];
    $diagnosticoGrupal = $conn->getDiagnosticoGrupalPorId($idDiagnostico);
    ?>
    <h2>Diagnóstico de grupo</h2>
    <label>
        Fecha:
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['fecha']?>" readonly/>
    <h3>
        Nombre del(los) tutores
    </h3>
    <label>
        Tutor 1: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['tutor1']?>" readonly/></br>
    <label>
        Tutor 2: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['tutor2']?>" readonly/><br>
    <h2>
        Unidad académica
    </h2>
    <label>
        Grupo: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['nombre']?>" readonly/></br>
    <label>
        Número de alumnos : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoGrupal['noAlumnos']?>" readonly/></br>
    <label>
        Semestre: 
    </label>
    <input type= "text" value = "<?php echo $diagnosticoGrupal['semestre']?>" readonly/></br>
    <table>
        <tr>
            <th>
                Fases de la tutoría
            </th>
            <th>
                Áreas de evaluación
            </th>
            <th>
                Instrumento
            </th>
            <th>
                Recolección y análisis de información
            </th>
            <th>
                Hallazgos
            </th>
        </tr>
        <?php 
            $detDiagnosticos = $diagnosticoGrupal[0];
            foreach ($detDiagnosticos as $diagnostico) {
                echo '<tr>';
                echo '<td>'.$diagnostico['fase'].'</td>';
                echo '<td>'.$diagnostico['areaEvaluacion'].'</td>';
                echo '<td>'.$diagnostico['instrumento'].'</td>';
                echo '<td>'.$diagnostico['recAnalisis'].'</td>';
                echo '<td>'.$diagnostico['hallazgos'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
</div>
