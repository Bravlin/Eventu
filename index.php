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
                <a class="logo mb-5 mt-0" href="index.php">
                    <img src="src/imagenes/logo.svg">Eventu
                </a>
                <h1 class="mt-5">Los momentos que importan, siempre con vos</h1>
                <div class="mt-5 mb-3"><a class="btn eventuButton px-5 py-2" href="registro.php">Registrarse</a></div>
                <div class="mb-5"><a href="login.php">¿Ya tienes una cuenta?</a></div>
            </div>
        </header>
        <div class="container presentacion">
            <h2 class="text-center">¿Qué es Eventu?</h2>
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-6">
                    <p>
                        Eventu es una nueva forma de estar al tanto de los acontecimientos que te interesan. ¿No te pasó que vino a tu localidad esa
                        banda que tanto te gusta pero lo descubriste recién al día siguiente de que tocaron mediante una foto? ¿O dio una charla esa
                        eminencia de tu área de interés y solo te enteraste porque un amigo que asistió te lo contó y se olvidó de comentarte?
                    </p>
                    <p>
                        Eso ya es parte del pasado. Con Eventu te mantendrás al tanto de aquellos eventos de tus tópicos preferidos, inscribirte a
                        ellos, compartir tus opiniones e incluso podrás organizar tus propios grandes momentos. 
                    </p>
                    <p>
                        ¿A qué estás esperando? ¡Entra y descubre cuál será tu próximo evento!
                    </p>
                </div>
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