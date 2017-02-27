<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $idDiagnostico = $_POST['idDiagnostico'];
    $diagnosticoDepartamental = $conn->getDiagnosticoDepartamentalPorId($idDiagnostico);
    $idDepartamento = $diagnosticoDepartamental['idDepartamento'];
    $carreras = $conn->getCarrerasDpto($idDepartamento);
    $semestres = $conn->getSemestresDpto($idDepartamento);
    ?>
    <h2>Diagnóstico departamental</h2>
    <h3>Datos generales</h3>
    <label>
        Nombre del coordinador: 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['coordinador']?>" readonly/>
    <label>
        Fecha : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['fecha']?>" readonly/>
    <h3>
        Unidad académica
    </h3>
    <label>
        Departamento : 
    </label>
    <input type = "text" value = "<?php echo $diagnosticoDepartamental['departamento']?>" readonly/> <br>
    <label>
        Carreras :
    </label>
    <table>
        <tr>
            <th>
                Nombre de la carrera
            </th>
        </tr>
        <?php 
            foreach ($carreras as $carrera) {
                echo '<tr>';
                echo '<td>'.$carrera['nombre'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <label>
        Semestres
    </label>
    <table>
        <tr>
            <th>
                Semestre
            </th>
        </tr>
        <?php 
            foreach ($semestres as $semestre) {
                echo '<tr>';
                echo '<td>'.$semestre['ident'].'</td>';
                echo '</tr>';   
            }
        ?>
    </table>
    <table>
        <tr>
            <th>
                Fase de la tutoría
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
            $det = $diagnosticoDepartamental[0];
            foreach ($det as $row) {
                echo '<tr>';
                echo '<td>'.$row['fase'].'</td>';
                echo '<td>'.$row['areaEvaluacion'].'</td>';
                echo '<td>'.$row['instrumento'].'</td>';
                echo '<td>'.$row['recanalisis'].'</td>';
                echo '<td>'.$row['hallazgos'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
</div>
