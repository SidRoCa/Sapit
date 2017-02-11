<div>
    <?php
    session_start();
    if ($_SESSION['tipo_usuario'] !== "crdinst") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "validarSesion.php";
        </SCRIPT> 
        <?php
    }
    require "conexion.php";
    $conn = new Connection();
    date_default_timezone_set('America/Denver');
    ?>
    <table id="tablaDatos">
        <tr>
            <td>REPORTE SEMESTRAL DEL COORDINADOR INSTITUCIONAL DE TUTORÍA</td>
        </tr>
        <tr>
            <td>Instituto Tecnológico de Parral</td>
        </tr>
        <tr>
            <td>
                <strong>NOMBRE DEL COORDINADOR INSTITUCIONAL DE TUTORÍAS</strong> <input type="text" id="nombreCrdTutoDpto" value="<?php echo($_SESSION["nombre_usuario"]); ?>">
            </td>
            <td>
                <strong>Fecha:</strong><input type="date" id="fecha" value="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <td>Matrícula del Instituto Tecnológico Actual: <input type="text" id="programaEducativo"></td>
            <td></td>
        </tr>
        <tr>
            <td>PROGRAMA EDUCATIVO</td>
            <td>Cantidad de Tutores</td>
            <td>Tutoría Grupal</td>
            <td>Tutoría Individual</td>
            <td>Estudiantes Canalizados en el semestre</td>
            <td>Área canalizada</td>
            <td>Matrícula</td>
        </tr>
        <?php
        $res = $conn->getCarreras();
        $listaCarreras = array();
        foreach ($res as $carrera) {
            echo ('<td>' . $carrera['nombre'] . ' </td>');
            array_push($listaCarreras, array('id' => $grupo['id'], 'nombre' => $grupo['nombre']));
            //Aquí voy. Sigue leer el número de tutores por carrera, el número de tutoría grupal de los reportes de los tutores e igual con la individual.
        }



        foreach ($listaCarreras as $res) {
            echo ('<tr>');
            echo ('<td>' . $cnt . '. ' . $tutor['nombre'] . '</td>');

            $grupoNombre = $conn->getGrupoTutor($tutor['id']);
            echo ('<td> ' . $grupoNombre . '</td>');

            $numeroEstudiantesIndividualTutor = $conn->getCantidadEstudiantesIndividualTutor($tutor['id']);
            echo ('<td> ' . $numeroEstudiantesIndividualTutor . '</td>');

            $numeroEstudiantesGrupalTutor = $conn->getCantidadEstudiantesGrupalTutor($tutor['id']);
            echo ('<td> ' . $numeroEstudiantesGrupalTutor . '</td>');

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
