<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crddpt") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    $idPlan = $_POST['idPlan'];
    $planAccion = $conn->getPlanAccionTutorialDepartamentalPorId($idPlan);
    $nombreCoordinador = $_SESSION['nombre_usuario'];
    $idDepartamento = $planAccion['idDepartamento'];
    $carreras = $conn->getCarrerasDpto($idDepartamento);
    $grupos = $conn->getGruposDpto($idDepartamento);
    $semestres = $conn->getSemestresDpto($idDepartamento);
    ?>
    <h2>
        Plan de acción tutorial departamental
    </h2>
    <label>
        Nombre del coordinador: 
    </label>
    <input type = "text" value = "<?php echo $nombreCoordinador?>" readonly/><br/>
    <h3>
        Datos generales
    </h3>
    <label>
        Nombre del departamento: 
    </label>
    <input type = "text" value = "<?php echo $planAccion['departamento']?>" readonly/><br/>
    <label>
        Fecha: 
    </label>
    <input type = "text" value = "<?php echo $planAccion['fecha']?>" readonly/><br/>
    <h3>
        Unidad académica
    </h3>
    <table>
        <tr>
            <th>
                Carreras
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
    <table>
        <tr>
            <th>
                Grupos
            </th>
        </tr>
        <?php 
            foreach ($grupos as $grupo) {
                echo '<tr>';
                echo '<td>'.$grupo['nombre'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <table>
        <tr>
            <th>
                Periodos
            </th>
        </tr>
        <?php 
            foreach ($semestres as $semestre) {
                echo '<tr>';
                echo '<td>'. $semestre['ident'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <h3>
        Problemáticas identificadas
    </h3>
    <table>
        <tr>
            <th>
                Problemática
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
            foreach ($problematicas as $prob) {
                echo '<tr>';
                echo '<td>'.$prob['problematica'].'</td>';
                echo '<td>'.$prob['valor'].'</td>';
                echo '<td>'.$prob['objetivos'].'</td>';
                echo '<td>'.$prob['acciones'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>
    <h3>
        Calendarización
    </h3>
    <table>
        <tr>
            <th>
                Actividades
            </th>
            <th>
                Mes 1
            </th>
            <th>
                Mes 2
            </th>
            <th>
                Mes 3
            </th>
            <th>
                Mes 4
            </th>
            <th>
                Mes 5
            </th>
            <th>
                Mes 6
            </th>
        </tr>
        <?php 
            $calendarizacion = $planAccion[1];
            foreach ($calendarizacion as $cal) {
                echo '<tr>';
                echo '<td>'.$cal['actividad'].'</td>';
                echo '<td>'.$cal['mes1'].'</td>';
                echo '<td>'.$cal['mes2'].'</td>';
                echo '<td>'.$cal['mes3'].'</td>';
                echo '<td>'.$cal['mes4'].'</td>';
                echo '<td>'.$cal['mes5'].'</td>';
                echo '<td>'.$cal['mes6'].'</td>';
                echo '</td>';
            }
        ?>
    </table>
    <label>
        Evaluación: 
    </label>
    <textarea readonly>
        <?php 
            echo $planAccion['evaluacion'];
        ?>
    </textarea>
</div>
