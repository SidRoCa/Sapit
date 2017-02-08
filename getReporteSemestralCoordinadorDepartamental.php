<div>
    <?php
    require "conexion.php";
    $conn = new Connection();
    session_start();
    date_default_timezone_set('America/Denver');
    ?>
    <table id="tablaDatos">
        <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR DEPARTAMENTAL DE TUTORÍAS</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR DE TUTORÍAS DEL DEPARTAMENTO ACADÉMICO:</strong> <input type="text" id="nombreCrdTutoDpto" value="<?php echo($_SESSION["nombre_usuario"]); ?>">
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO: <input type="text" id="programaEducativo"></td>
            <td>
                HORA: <input type="text" id="hora">
            </td>
        </tr>
        <tr>
            <td>LISTA DE TUTORES</td>
            <td>GRUPO</td>
            <td>TUTORÍA GRUPAL</td>
            <td>TUTORÍA INDIVIDUAL</td>
            <td>ESTUDIANTES CANALIZADOS EN EL SEMESTRE</td>
            <td>ÁREA CANALIZADA</td>
        </tr>
        <?php
        $idDpto = $conn->getIdDpto($_SESSION["id_usuario"]);
        $listaTutores = $conn->getTutoresDpto($idDpto);
        $cnt = 1;
        foreach ($listaTutores as $tutor) {
            echo ('<tr>');
            echo ('<td>' . $cnt . '. ' . $tutor['nombre'] . ' ID: '. $tutor['id'] .'</td>');

            $grupoNombre = $conn->getGrupoTutor($tutor['id']);
            echo ('<td> ' . $grupoNombre . '</td>');

            $numeroEstudiantesGrupalTutor = $conn->getCantidadEstudiantesGrupalTutor($tutor['id']);
            echo ('<td> ' . $numeroEstudiantesGrupalTutor . '</td>');
            
            $numeroEstudiantesIndividualTutor = $conn->getCantidadEstudiantesIndividualTutor($tutor['id']);
            echo ('<td> ' . $numeroEstudiantesIndividualTutor . '</td>');

            

            echo ('<td> <input type="text"> </td>');
            echo ('<td> <input type="text"> </td>');

            echo ('<tr>');
            $cnt = $cnt + 1;
        }
        ?>
    </table>

    <div>
        <button onclick="imprimir()">Imprimir</button>
        <button onclick="cancelar()">Cancelar</button>
    </div>
</div>
<script>

    function cancelar() {
        $("#reporteSemestral").show();
        $("#mainContenido").hide();
    }

    function imprimir() {
        alert('Not supported yet');
    }

</script>
