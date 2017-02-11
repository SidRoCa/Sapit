<?php

require "../../conexion.php";
$conn = new Connection();
if (filter_input(INPUT_POST, 'idGrupo') and filter_input(INPUT_POST, 'nombre') and filter_input(INPUT_POST, 'lugarTutoria') and filter_input(INPUT_POST, 'idPeriodo') and filter_input(INPUT_POST, 'idTutor1') and filter_input(INPUT_POST, 'idTutor2') and filter_input(INPUT_POST, 'horario')) {
    $idGrupo = $_POST['idGrupo'];
    $nombre = $_POST['nombre'];
    $lugarTutoria = $_POST['lugarTutoria'];
    $idPeriodo = $_POST['idPeriodo'];
    $idTutor1 = $_POST['idTutor1'];
    $idTutor2 = $_POST['idTutor2'];
    $horario = $_POST['horario'];
    $conn->conectar();
    $query = 'update grupos set nombre = \'' . $nombre . '\' , lugar_tutoria = \'' . $lugarTutoria . '\',id_periodo = ' . $idPeriodo . ', id_tutor1 = ' . $idTutor1 . ', id_tutor2 = ' . $idTutor2 . ',horario = \'' . $horario . '\'  where id = ' . $idGrupo;
    $res = pg_query($query);
    if ($res) {
        echo "ok";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
