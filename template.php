<?php
    $requiere_sesion = true;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('comun/head-navegacion.php'); ?>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-10 py-5">
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>