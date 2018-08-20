<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agenda - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/item-agenda.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <h1 class="mb-5 text-center">Tu agenda</h1>
                <div class="row px-2">
                    <?php
                        $eventos_query = mysqli_query($db,
                            "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz, e.idCreador,
                            dir.calle, dir.altura,
                            ciudades.nombre AS nombreCiudad,
                            provincias.nombre AS nombreProvincia
                            FROM eventos e
                            INNER JOIN direcciones dir ON dir.idDireccion = e.idDireccion
                            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                            WHERE e.idCreador = ".$_SESSION['idUsuario']." AND e.estado = 'aprobado'
                            UNION
                            SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz, e.idCreador,
                            dir.calle, dir.altura,
                            ciudades.nombre AS nombreCiudad,
                            provincias.nombre AS nombreProvincia
                            FROM eventos e
                            INNER JOIN direcciones dir ON dir.idDireccion = e.idDireccion
                            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                            INNER JOIN inscripciones ON inscripciones.idEvento = e.idEvento
                            WHERE inscripciones.idUsuario = ".$_SESSION['idUsuario']."
                            ORDER BY fechaRealiz ASC;");
                        while ($evento = mysqli_fetch_array($eventos_query))
                            require('item-agenda.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>