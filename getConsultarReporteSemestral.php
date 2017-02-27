<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor" and $_SESSION['tipo_usuario'] !== "crddpt" and $_SESSION['tipo_usuario']!=="crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $idReporte = $_POST['idReporte'];
    $reporteSemestral = $conn->getReporteSemestralPorId($idReporte);
    ?>
    <h2>Reporte Semestral del tutor</h2>
    <label>
        Nombre del Tutor :
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['tutor']?>" readonly/> </br>
    <label>
        Fecha
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['fecha']?>" readonly/></br>
    <label>
        Grupo
    </label>
    <input type = "text" value = "<?php echo $reporteSemestral['grupo']?>" readonly/><br>
    <label>
        PROGRAMA EDUCATIVO: PROGRAMA INSTITUCIONAL DE TUTORÍAS
    </label></br>
    <table>
        <tr>
            <th>
                Estudiantes
            </th>
            <th>
                Tutoría grupal
            </th>
            <th>
                Tutoría individual
            </th>
            <th>
                Estudiante canalizado
            </th>
            <th>
                Área canalizada
            </th>
        </tr>
        <?php 
            $detReporte = $reporteSemestral[0];
            foreach ($detReporte as $det) {
                echo '<tr>';
                echo '<td>'.$det['alumno'].'</td>';
                echo '<td>'.$det['tutoriaGrupal'].'</td>';
                echo '<td>'.$det['tutoriaIndividual'].'</td>';
                echo '<td>'.$det['canalizado'].'</td>';
                echo '<td>'.$det['areaCanalizada'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <label>
        Observaciones: 
    </label>
    <textarea readonly>
        <?php 
            echo $reporteSemestral['observaciones'];
        ?>
    </textarea>
</div>
