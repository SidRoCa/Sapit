<?php
session_start();

if ($_SESSION["tipo_usuario"] == "alumno") {
    ?>
    <SCRIPT LANGUAGE="javascript">
        location.href = "alumno.php";
    </SCRIPT> 
    <?php
} else {
    if ($_SESSION["tipo_usuario"] == "tutor") {
        ?>
        <SCRIPT LANGUAGE="javascript">
            location.href = "tutor.php";
        </SCRIPT> 
        <?php
    } else {
        if ($_SESSION["tipo_usuario"] == "crddpt") {
            ?>
            <SCRIPT LANGUAGE="javascript">
                location.href = "crdDepartamental.php";
            </SCRIPT> 
            <?php
        } else {
            if ($_SESSION["tipo_usuario"] == "crdinst") {
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "crdInstitucional.php";
                </SCRIPT> 
                <?php
            } else {
                ?>
                <SCRIPT LANGUAGE="javascript">
                    location.href = "login.php";
                </SCRIPT> 
                <?php
            }
        }
    }
}
?>
