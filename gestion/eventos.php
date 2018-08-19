<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventos - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="/css/item-consulta.css">
    <style>
        .agregar-evento{
            color: var(--eventu-red);
            text-decoration: none;
            font-size: 1.75em;
        }
        
        .agregar-evento:hover{
            color: var(--eventu-pink);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <h1 class="mb-5 text-center">Administrador de eventos</h1>
                <div class="mb-3">
                    <a href="agregar-evento.php" class="agregar-evento"><i class="fa fa-plus-circle mr-1"></i>Agregar evento</a>
                </div>
                <div class="row">
                    <?php
                        $eventos_query = mysqli_query($db,
                            "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz, e.fechaCreac, e.fechaCreac,
                            dir.calle, dir.altura,
                            ciudades.nombre AS nombreCiudad,
                            provincias.nombre AS nombreProvincia
                            FROM eventos e
                            INNER JOIN direcciones dir ON dir.idDireccion = e.idDireccion
                            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                            ORDER BY e.nombre ASC;");
                        while ($evento = mysqli_fetch_array($eventos_query))
                            require('item-consulta.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>