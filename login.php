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
            "SELECT u.idUsuario, u.tipo,
            direcciones.codCiudad
            FROM usuarios u INNER JOIN direcciones
            ON u.idDireccion = direcciones.idDireccion
            WHERE u.email = '$email' AND u.clave = '$contrasena';");
        if (mysqli_num_rows($usuario_query) == 1){
            $usuario = mysqli_fetch_array($usuario_query);
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['tipo'] = $usuario['tipo'];
            $_SESSION['codCiudad'] = $usuario['codCiudad'];
            session_write_close();
            if ($_SESSION['tipo'] == 'A')
                header("location: gestion/home.php");
            else
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
            <div class="logo mt-0">
                <img src="src/imagenes/logo.svg">Eventu
            </div>
        </header>
    </div>
    <div class="contenedor-pagina row justify-content-center py-5">
        <div class="form-container col-10 col-sm-8 col-md-6">
            <form class="text-center py-5 px-1 px-sm-3" method="POST">
                <h1>Entérate de tus próximos eventos</h1>
                <input type="hidden" name="confirma" value="si"/>
                <div class="row justify-content-center">
                    <div class="col-12 row justify-content-center">
                        <div class="col-12 col-sm-9 col-md-6 mb-3">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email o nombre de usuario" required>
                        </div>
                    </div>
                    <div class="col-12 row justify-content-center">
                        <div class="col-12 col-sm-9 col-md-6 mb-3">
                            <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <?php
                        if ($msg_error == 1)
                            echo '<p class="alerta col-12">Email o contraseña inválidos, intente nuevamente</p>';
                    ?>
                    <div class="col-12 col-lg-8 col-xl-6 row justify-content-center">
                        <div class="col-12 col-lg-6">
                            <label>
                                <input type="checkbox" value="remember-me"> Recordarme
                            </label>
                        </div>
                        <div class="col-12 col-lg-6">
                            <button class="btn eventuButton ml-lg-4" type="submit">Acceder</button>
                        </div>
                    </div>
                    <p class="mt-3 col-12"><a href="">¿Olvidaste tu contraseña?</a></p>
                    <p class="col-12"><a href="registro.php">Registrate</a></p>
                </div>
            </form>
        </div>
    </div>
    <?php require('comun/footer-simple.php'); ?>
</body>
</html>