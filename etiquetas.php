<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Etiquetas - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <h1 class="text-center mb-5 text-primary">Etiquetas</h1>
                <ul class="row">
                    <?php
                        $etiquetas_query = mysqli_query($db, "SELECT * FROM etiquetas ORDER BY nombre ASC;");
                        while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                            echo '<li class="px-0 mb-2 col-12 col-sm-6 col-md-4 col-lg-2">
                                <a href="catalogo.php?modo=etiqueta&id='.$etiqueta['idEtiqueta'].'">' . $etiqueta['nombre'] . '</a></li>';
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>