<?php
    $requiere_sesion = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
    $msg_error = -1;
    $confirma = $_REQUEST['confirma'];
    if ($confirma == 'si'){
        $email = $_REQUEST['email'];
        $contrasena = $_REQUEST['contrasena'];
        $contrasena = md5($contrasena);
        $usuario_query = mysqli_query($db,
            "SELECT usuarios.idUsuario, direcciones.codCiudad
            FROM usuarios INNER JOIN direcciones
            ON usuarios.idDireccion = direcciones.idDireccion
            WHERE usuarios.email = '$email' AND usuarios.clave = '$contrasena';");
        if (mysqli_num_rows($usuario_query) == 1){
            $usuario = mysqli_fetch_array($usuario_query);
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['codCiudad'] = $usuario['codCiudad'];
            session_write_close();
            header("location: home.php");
        }
        else
            $msg_error = 1;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Eventu</title>
    <?php require('comun/head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div class="container-fluid">
        <header>
            <div class="logo">
                <img src="src/imagenes/logo.svg">Eventu
            </div>
        </header>
    </div>
    <div class="contenedor-pagina">
        <div class="form-container">
            <form class="text-center px-3" method="POST">
                <h1>Entérate de tus próximos eventos</h1>
                <input type="hidden" name="confirma" value="si"/>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email o nombre de usuario" required>
                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                <?php
                    if ($msg_error == 1)
                        echo '<p class="alerta">Email o contraseña inválidos, intente nuevamente</p>';
                ?>
                <div>
                    <label>
                        <input type="checkbox" value="remember-me"> Recordarme
                    </label>
                    <button class="btn eventuButton" type="submit">Acceder</button>
                </div>
                <p class="bis"><a href="">¿Olvidaste tu contraseña?</a></p>
                <p class="bis"><a href="registro.php">Registrate</a></p>
            </form>
        </div>
    </div>
    <?php require('comun/footer-simple.php'); ?>
</body>
</html>