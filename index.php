<?php
    $requiere_sesion = false;
    require('php-scripts/sesion-redireccion.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventu</title>
    <?php require('comun/head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/bienvenida.css">
</head>
<body>
    <div class="container-fluid px-0">
        <header>
            <div class="jumbotron text-center bienvenida pt-0">
                <div class="logo mb-5 mt-0">
                    <img src="src/imagenes/logo.svg">Eventu
                </div>
                <h1>Los momentos que importan, siempre con vos</h1>
                <div class="mt-5 mb-3"><a class="btn eventuButton px-5 py-2" href="registro.php">Registrarse</a></div>
                <div class="mb-5"><a href="login.php">¿Ya tienes una cuenta?</a></div>
            </div>
        </header>
        <div class="container presentacion">
            <h2 class="text-center">¿Qué es Eventu?</h2>
            <div class="row">
                <p class="col-sm-12 col-md-6">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                </p>
                <div class="col-sm-12 col-md-6">
                    <div class="contenedor-video">
                        <iframe class="video" width="854" height="480" src="https://www.youtube.com/embed/MeM6UZ4Y_wY" frameborder="0"
                            allow="autoplay; encrypted-media" allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/footer-simple.php'); ?>
</body>
</html>