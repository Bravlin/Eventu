<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
    
    $consulta = $_REQUEST['consulta'];
    switch ($_REQUEST['filtro']){
        case 'nombre':
            $criterio_query = "e.nombre";
            break;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="/css/item-consulta.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <div class="row">
                    <?php
                        $eventos_query = mysqli_query($db,
                            "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz,
                            dir.calle, dir.altura,
                            ciudades.nombre AS nombreCiudad,
                            provincias.nombre AS nombreProvincia
                            FROM eventos e
                            INNER JOIN direcciones dir ON dir.idDireccion = e.idDireccion
                            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                            WHERE $criterio_query LIKE '%$consulta%';");
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