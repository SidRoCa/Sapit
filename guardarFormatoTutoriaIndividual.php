<div>
    <?php
    require "conexion.php";
    $conn = new Connection();


    $idGrupo = intval($_POST['idGrupo']);
    $fecha = ($_POST['fecha']);
    $solicPor = ($_POST['solicPor']);
    $motivos = ($_POST['motivos']);
    $aspectos = ($_POST['aspectos']);
    $conclusiones = ($_POST['conclusiones']);
    $observaciones = ($_POST['observaciones']);
    $proxFecha = ($_POST['proxFecha']);
    $idAlumno = ($_POST['idAlumno']);




    $res = $conn->guardarTutoriasIndividual($idGrupo, $fecha, $solicPor, $motivos, $aspectos, $conclusiones, $observaciones,  $proxFecha, $idAlumno);
    if ($res) {
        echo('<p>Éxito!</p>');
    } else {
        echo('<p>Error!</p>');
    }
    ?>

    <h2>Formato para el registro de tutoría individual</h2>
    <p>TUTORÍA INDIVIDUAL</p> 
    <p><strong>Fecha: </strong><?php echo ($fecha) ?></p>
    <p><strong>tutores: </strong><?php
        $res = $conn->getTutoresGrupo($idGrupo);
        foreach ($res as $tutor) {
            echo ('<p>' . $tutor['id'] . " " . $tutor['nombres'] . " " . $tutor['ap_paterno'] . " " . $tutor['ap_materno'] . "</p>");
        }
        ?></p>
    <h3>INFORME DE UNA ENTREVISTA TUTORIAL</h3>  
    <p><strong>Nombre del alumno: </strong><?php
        $idGrupo = intval($_POST['idGrupo']);

        $res = $conn->getAlumno($idGrupo);
        echo ($res);
        ?></p>
    <p><strong>Entrevista solicitada por: </strong><?php echo($solicPor) ?></p>
    <ol>
        <li><strong>Motivos: </strong><?php echo($motivos) ?></li> 
        <li><strong>Apsectos Tratados: </strong><?php echo($aspectos) ?></li> 
        <li><strong>Conclusiones y compromisos establecidos: </strong><?php echo($conclusiones) ?></li> 
        <li><strong>Observaciones: </strong><?php echo($observaciones) ?></li> 
        <li><strong>Fecha próxima visita: </strong><?php echo($proxFecha) ?></li> 
    </ol>
    <button onclick="imprimir()">imprimir</button>
    <button onclick="volver()">Volver</button>

</div>
<script>
    function volver() {
        $("#registroAsistenciaIndividual").show();
        $("#mainContenido").hide();
    }
    function imprimir() {
        alert('Not supported yet');
    }
</script>