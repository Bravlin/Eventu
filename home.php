<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/tarjeta-evento.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <div class="row">
                    <?php
                        $codCiudad = $_SESSION['codCiudad'];
                        $eventos_query = mysqli_query($db,
                            "SELECT DISTINCT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz,
                            dir.calle, dir.altura,
                            ciudades.nombre AS nombreCiudad,
                            provincias.nombre AS nombreProvincia,
                            u.nombres AS nombresCread, u.apellidos AS apellidosCread, u.idUsuario AS idCread,
                            cat.nombre AS nombreCateg, cat.idCategoria
                            FROM eventos e
                            INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
                            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                            INNER JOIN usuarios u ON u.idUsuario = e.idCreador
                            INNER JOIN categorias cat ON cat.idCategoria = e.idCategoria
                            INNER JOIN etiquetas_eventos et_e ON et_e.idEvento = e.idEvento
                            INNER JOIN etiquetas_usuarios et_u ON et_u.idEtiqueta = et_e.idEtiqueta
                            WHERE et_u.idUsuario = '".$_SESSION['idUsuario']."'
                            ORDER BY e.fechaRealiz ASC;");
                        if (mysqli_num_rows($eventos_query) == 0){
                            $eventos_query = mysqli_query($db,
                                "SELECT DISTINCT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz,
                                dir.calle, dir.altura,
                                ciudades.nombre AS nombreCiudad,
                                provincias.nombre AS nombreProvincia,
                                u.nombres AS nombresCread, u.apellidos AS apellidosCread, u.idUsuario AS idCread,
                                cat.nombre AS nombreCateg, cat.idCategoria
                                FROM eventos e
                                INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
                                INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                                INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                                INNER JOIN usuarios u ON u.idUsuario = e.idCreador
                                INNER JOIN categorias cat ON cat.idCategoria = e.idCategoria
                                WHERE dir.codCiudad = '".$_SESSION['codCiudad']."'
                                ORDER BY e.fechaRealiz ASC;");
                        }
                        while ($evento = mysqli_fetch_array($eventos_query))
                            require('tarjeta-evento.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>