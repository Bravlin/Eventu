<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
    
    $idEvento = $_REQUEST['idEvento'];
    $eventos_query = mysqli_query($db,
        "SELECT e.idEvento, e.nombre AS nombreEvento, e.descripcion, e.fechaRealiz, e.estado,
        dir.calle, dir.altura,
        ciudades.nombre AS nombreCiudad,
        provincias.nombre AS nombreProvincia,
        u.nombres AS nombresCread, u.apellidos AS apellidosCread,
        cat.nombre AS nombreCateg, cat.idCategoria
        FROM eventos e
        INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
        INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
        INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
        INNER JOIN usuarios u ON u.idUsuario = e.idCreador
        INNER JOIN categorias cat ON cat.idCategoria = e.idCategoria
        WHERE e.idEvento = '$idEvento';");
    if (mysqli_num_rows($eventos_query) == 1)
        $evento = mysqli_fetch_array($eventos_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $evento['nombreEvento']; ?> - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="/css/evento.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5 px-md-5">
                <a class="categoria" href="catalogo.php?modo=categoria&id=<?php echo $evento['idCategoria']; ?>">
                    <h5><?php echo $evento['nombreCateg']; ?></h5>
                </a>
                <div class="contenedor-portada mb-5">
                    <img class="portada" alt="portada"
                        src=<?php
                            $portada = "../media/portadas-eventos/" . $evento['idEvento'] . "-p";
                            if (file_exists($portada))
                                echo $portada;
                            else
                                echo "../media/portadas-eventos/0-p";
                        ?>
                    >
                    <div class="contenedor-titulo px-1 px-md-3">
                        <h1 class="nombre-evento"><?php echo $evento['nombreEvento']; ?></h1>
                    </div>
                </div>
                <p><?php echo $evento['descripcion']; ?></p>
                <div class="info-general row py-3 my-5">
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                        <i class="fa fa-map-marker"></i>
                        <?php
                            $ubicacion = $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia'];
                            echo $ubicacion;
                        ?>
                        <div class="contenedor-nivel2 mt-3">
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
                    </div>
                    <div class="col-12 col-sm-6 d-flex flex-column">
                        <div class="mb-3">
                            <i class="fa fa-user-circle"></i>
                            Organizado por <?php echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?>
                        </div>
                        <div class="mb-3">
                            <i class="fa fa-calendar"></i>
                            <?php
                                $fechaHora = strtotime($evento['fechaRealiz']);
                                echo date('d/m/Y', $fechaHora);
                            ?>
                            <i class="fa fa-clock-o pl-3"></i>
                            <?php echo date('H:i', $fechaHora); ?>
                        </div>
                        <div class="mb-5 mb-sm-0">
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
                        </div>
                        <div class="text-center my-auto mx-auto">
                            <p id="estado">
                                <?php
                                    switch ($evento['estado']){
                                        case "P":
                                            echo "Pendiente de aprobación";
                                            break;
                                        case "A":
                                            echo "Aprobado";
                                            break;
                                        case "R":
                                            echo "Rechazado";
                                            break;
                                    }
                                ?>
                            </p>
                            <?php
                                switch ($evento['estado']){
                                    case 'P':
                                        echo '<button type="button" id="aceptar" class="btn btn-success rounded px-3 mr-2">Aceptar</button>';
                                        echo '<button type="button" id="rechazar" class="btn btn-danger rounded px-3">Rechazar</button>';
                                        echo '<button type="button" id="modificar" class="btn btn-success rounded px-3 mr-2" hidden>Modificar</button>';
                                        echo '<button type="button" id="eliminar" class="btn btn-danger rounded px-3" hidden>Eliminar</button>';
                                        break;
                                    case 'A':
                                        echo '<button type="button" id="modificar" class="btn btn-success rounded px-3 mr-2">Modificar</button>';
                                        echo '<button type="button" id="eliminar" class="btn btn-danger rounded px-3">Eliminar</button>';
                                        break;
                                    case 'R':
                                        echo '<button type="button" id="aceptar" class="btn btn-success rounded px-3 mr-2">Aceptar</button>';
                                        echo '<button type="button" id="modificar" class="btn btn-success rounded px-3 mr-2" hidden>Modificar</button>';
                                        echo '<button type="button" id="eliminar" class="btn btn-danger rounded px-3">Eliminar</button>';
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
    
    <div id="idEvento" valor="<?php echo $idEvento; ?>" hidden></div>
    <script type="text/javascript" src="js/handler-eventos.js"></script>
</body>
</html>