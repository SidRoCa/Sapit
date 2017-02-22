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
    $plan = $conn->getPlanDesarrollarDiagnosticoDepartamentalPorId($idPlan);
    $nombreCoordinador = $_SESSION['nombre_usuario'];
    $grupos = $conn->getGruposDpto($plan['idDepartamento']);
    ?>
    <h2>
        Planeación para desarrollar el diagnóstico departamental
    </h2>
    <label>
        Departamento : 
    </label>
    <input type = "text" value= "<?php echo $plan['departamento']?>"/>
    <label>
        Fecha :
    </label>
    <input type = "text" value = "<?php echo $plan['fecha']?>"/>
    <table>
        <tr>
            <th>
                Problema
            </th>
            <?php 
                foreach ($grupos as $grupo) {
                    echo '<th>Grupo: '.$grupo['nombre'].'</th>';
                }
            ?>
        </tr>
        <?php 
            $problemas = $plan[0];
            foreach ($problemas as $problema) {
                echo '<tr>';
                echo '<td>'.$problema['problema'].'</td>';
                $det = $problema[0];
                foreach ($grupos as $grupo) {
                    $rowAux = '<td></td>';
                    foreach ($det as $row) {
                        if($grupo['id'] == $row['idGrupo']){
                            $rowAux = '<td>'.$row['valor'].'</td>';
                        }
                    }
                    echo $rowAux;
                }
                echo '</tr>';
            }
        ?>
    </table>
</div>

