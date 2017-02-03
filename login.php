<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <title>Sapit</title>
    </head>
    <body>
        <h1>Login sapit</h1>
        <form action="validarUsuario.php" method="post">
            Usuario:<input type="text" name="usuario"  required  /> <!-- pattern="\d{1,8}" -->
            <br />
            Contraseña:<input type="password" name="password" required pattern="\S+" />
            <br />
            <input type="submit" value="Ingresar" />
        </form>
    </body>
</html>