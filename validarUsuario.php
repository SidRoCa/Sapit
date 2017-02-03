<?php
$conex = "host=localhost port=5432 dbname=sapitbd user=admin password=admin";
$cnx = pg_connect($conex) or die("<h1>Error de conexion.</h1> " . pg_last_error());
session_start();

//function quitar($mensaje) {
//    $nopermitidos = array("'", '\\', '<', '>', "\"");
//    $mensaje = str_replace($nopermitidos, "", $mensaje);
//    return $mensaje;
//}

if (trim($_POST["usuario"]) != "" && trim($_POST["password"]) != "") {
    //eliminar algun caracter en especifico
    //$usuario = strtolower(quitar($HTTP_POST_VARS["usuario"]));
    //$password = $HTTP_POST_VARS["password"];
    $usuario = strtolower(htmlentities($_POST["usuario"], ENT_QUOTES));
    $password = $_POST["password"];
    $result = pg_query('SELECT id, password, usuario, tipo, nombre FROM usuarios WHERE usuario=\'' . $usuario . '\'');
    if ($row = pg_fetch_array($result)) {
        if ($row["password"] == $password) {
            $_SESSION["k_username"] = $row['usuario'];
            $_SESSION["nombre_usuario"] = $row['nombre'];
            $_SESSION["id_usuario"] = $row['id'];

            echo 'Has sido logueado correctamente ' . $_SESSION['nombre_usuario'] . ' <p>';
            echo '<p> Ingreso exitoso, ahora sera dirigido a la página principal.</p>';

            if ($row['tipo'] == 'alumno') {
                $_SESSION["tipo_usuario"] = "alumno";
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "alumno.php";
                </SCRIPT> 
                <?php
            }
            if ($row['tipo'] == 'tutor') {
                $_SESSION["tipo_usuario"] = "tutor";
                $result2 = pg_query('select id from tutores where identificador = \'' . $row['usuario'] . '\'');
                $row2 = pg_fetch_array($result2);
                $_SESSION["id_usuario"] = $row2['id'];
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "tutor.php";
                </SCRIPT> 
                <?php
            }
            if ($row['tipo'] == 'crddepartamental') {
                $_SESSION["tipo_usuario"] = "crddpt";
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "crdDepartamental.php";
                </SCRIPT> 
                <?php
            }
            if ($row['tipo'] == 'crdinstitucional') {
                $_SESSION["tipo_usuario"] = "crdinst";
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "crdinstitucional.php";
                </SCRIPT> 
                <?php
            }
        } else {
            echo 'Password incorrecto';
        }
    } else {
        echo 'Usuario no existente en la base de datos';
    }
    pg_free_result($result);
} else {
    echo 'Debe especificar un usuario y password';
}
pg_close();
?>