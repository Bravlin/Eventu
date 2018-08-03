<?php
    $requiere_sesion = true;
    require('sesion-redireccion.php');
    require('db.php');
    
    $idEvento = $_REQUEST['idEvento'];
    $eventos_query = mysqli_query($db,
        "SELECT e.idEvento, e.nombre AS nombreEvento, e.descripcion, e.fechaRealiz,
        dir.calle, dir.altura,
        ciudades.nombre AS nombreCiudad,
        provincias.nombre AS nombreProvincia,
        u.nombres AS nombresCread, u.apellidos AS apellidosCread,
        categorias.nombre AS nombreCateg
        FROM eventos e
        INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
        INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
        INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
        INNER JOIN usuarios u ON u.idUsuario = e.idCreador
        INNER JOIN categorias ON categorias.idCategoria = e.idCategoria
        WHERE e.idEvento = '$idEvento';");
    if (mysqli_num_rows($eventos_query) == 1)
        $evento = mysqli_fetch_array($eventos_query);
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('head-navegacion.php'); ?>
    <title><?php echo $evento['nombreEvento']; ?> - Eventu</title>
    <link rel="stylesheet" type="text/css" href="css/evento.css">
</head>
<body>
    <?php require ('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('barra-vertical.php'); ?>
            <div class="col-12 col-md-10 py-5">
                <h5 class="categoria"><?php echo $evento['nombreCateg']; ?></h5>
                <h1 class="nombre-evento"><?php echo $evento['nombreEvento']; ?></h1>
                <p><?php echo $evento['descripcion']; ?></p>
                <ul class="info-general">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <?php
                            $ubicacion = $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia'];
                            echo $ubicacion;
                        ?>
                        <div class="contenedor-nivel2">
                            <div class="contenedor-mapa">
                                <iframe class="mapa"
                                    width="400"
                                    height="350"
                                    frameborder="0"
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBMTPQ8KW_7vtE_nChnfCgM-AsJTSbwQ1k&q=<?php echo urlencode($ubicacion); ?>"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </li>
                    <li>
                        <i class="fa fa-clock-o"></i>
                        <?php echo date('d/m/Y H:i', strtotime($evento['fechaRealiz'])); ?>
                    </li>
                    <li>
                        <i class="fa fa-user-circle"></i>
                        <?php echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?>
                    </li>
                    <li>
                        <i class="fa fa-hashtag"></i>
                        <b>
                            <?php
                                $etiquetas_query = mysqli_query($db,
                                    "SELECT et.nombre
                                    FROM etiquetas et
                                    INNER JOIN etiquetas_eventos et_ev ON et.idEtiqueta = et_ev.idEtiqueta
                                    WHERE et_ev.idEvento = '$idEvento'
                                    ORDER BY et.nombre ASC;");
                                while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                                    echo $etiqueta['nombre'].' ';
                            ?>
                        </b>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php require('barra-fondo.php'); ?>
</body>
</html>