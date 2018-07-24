<?php
    $requiere_sesion = false;
    require('sesion-redireccion.php');
    require('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventu</title>
    <?php require('head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/bienvenida.css">
</head>
<body>
    <div class="container-fluid">
        <header>
            <div class="logo">
                <img src="src/imagenes/logo.svg">Eventu
            </div>
        </header>
        <div class="jumbotron text-center bienvenida">
            <h1>Los momentos que importan, siempre con vos</h1>
            <div><a class="btn eventuButton" href="registro.php">Registrarse</a></div>
            <div><a href="login.php">¿Ya tienes una cuenta?</a></div>
        </div>
        <div class="container presentacion">
            <h2 class="text-center">¿Qué es Eventu?</h2>
            <div class="row">
                <p class="col-sm-12 col-md-6">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                </p>
                <div class="col-sm-12 col-md-6">
                    <img src="src/imagenes/tedx-sydney-events-in-sydney-andy-dexterity-472x233.jpg">
                </div>
            </div>
        </div>
    </div>
    <?php require('footer-simple.php'); ?>
</body>
</html>