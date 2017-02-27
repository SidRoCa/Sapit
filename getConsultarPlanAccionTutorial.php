<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "tutor" and $_SESSION['tipo_usuario']!=="crddpt" and $_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $idPlan = $_POST['idPlan'];
    $planAccion = $conn->getPlanAccionTutorialPorId($idPlan);
    ?>
    <h2>Plan de acción tutorial</h2>
    <label>
        Fecha:
    </label>
    <input type = "text" value = "<?php echo $planAccion['fecha']?>" readonly/>
    <h3>
        Nombre del(los) tutores
    </h3>
    <label>
        Tutor: 
    </label>
    <input type= "text" value= "<?php echo $planAccion['tutor1']?>" readonly/><br/>
    <label>
        Tutor: 
    </label>
    <input type= "text" value= "<?php echo $planAccion['tutor2']?>" readonly/><br/>
    <h3>
        Unidad académica
    </h3>
    <label>
        Grupo: 
    </label>
    <input type="text" value = "<?php echo $planAccion['nombreGrupo']?>" readonly/><br/>
    <label>
        Número de alumnos
    </label>
    <input type = "text" value = "<?php echo $planAccion['noAlumnos']?>" readonly/><br/>
    <label>
        Semestre
    </label>
    <input type = "text" value = "<?php echo $planAccion['semestre']?>" readonly/><br/>
    <h3>
        Problemáticas identificadas
    </h3>
    <table>
        <tr>
            <th>
                Problematica
            </th>
            <th>
                Valor asignado
            </th>
            <th>
                Objetivos
            </th>
            <th>
                Acciones
            </th>
        </tr>
        <?php 
            $problematicas = $planAccion[0];
            foreach ($problematicas as $problematica) {
                echo '<tr>';
                echo '<td>';
                echo $problematica['problematica'];
                echo '</td>';
                echo '<td>';
                echo $problematica['valor'];
                echo '</td>';
                echo '<td>';
                echo $problematica['objetivos'];
                echo '</td>';
                echo '<td>';
                echo $problematica['acciones'];
                echo '</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <table>
        <?php 
            if($planAccion['semestre'] === 'ene-jun'){
                echo '<tr>';
                echo '<th>Actividades</th>';
                echo '<th>Enero</th>';
                echo '<th>Febrero</th>';
                echo '<th>Marzo</th>';
                echo '<th>Abril</th>';
                echo '<th>Mayo</th>';
                echo '<th>Junio</th>';
                echo '</tr>';
            }else{
                echo '<tr>';
                echo '<th>Actividades</th>';
                echo '<th>Agosto</th>';
                echo '<th>Septiembre</th>';
                echo '<th>Octubre</th>';
                echo '<th>Noviembre</th>';
                echo '<th>Diciembre</th>';
                echo '</tr>';
            }

            $actividades = $planAccion[1];
            if($planAccion['semestre'] === 'ene-jun'){
                foreach ($actividades as $actividad) {
                    echo '<tr>';
                    echo '<td>'.$actividad['accion'].'</td>';
                    echo '<td>'.$actividad['mes1'].'</td>';
                    echo '<td>'.$actividad['mes2'].'</td>';
                    echo '<td>'.$actividad['mes3'].'</td>';
                    echo '<td>'.$actividad['mes4'].'</td>';
                    echo '<td>'.$actividad['mes5'].'</td>';
                    echo '<td>'.$actividad['mes6'].'</td>';
                }
            }else{
                foreach ($actividades as $actividad) {
                    echo '<tr>';
                    echo '<td>'.$actividad['accion'].'</td>';
                    echo '<td>'.$actividad['mes1'].'</td>';
                    echo '<td>'.$actividad['mes2'].'</td>';
                    echo '<td>'.$actividad['mes3'].'</td>';
                    echo '<td>'.$actividad['mes4'].'</td>';
                    echo '<td>'.$actividad['mes5'].'</td>';
                }
            }
        ?>
    </table>
</div>
