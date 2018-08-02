<?php
    $requiere_sesion = true;
    require('sesion-redireccion.php');
    require('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('head-navegacion.php'); ?>
</head>
<body>
    <?php require ('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('barra-vertical.php'); ?>
            <div class="col-12 col-md-10">
            </div>
        </div>
    </div>
    <?php require('barra-fondo.php'); ?>
</body>
</html>