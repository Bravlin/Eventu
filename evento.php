<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
    
    $idEvento = $_REQUEST['idEvento'];
    $eventos_query = mysqli_query($db,
        "SELECT e.idEvento, e.nombre AS nombreEvento, e.descripcion, e.fechaRealiz,
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
        WHERE e.idEvento = '$idEvento';");
    if (mysqli_num_rows($eventos_query) == 1)
        $evento = mysqli_fetch_array($eventos_query);
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('comun/head-navegacion.php'); ?>
    <title><?php echo $evento['nombreEvento']; ?> - Eventu</title>
    <link rel="stylesheet" type="text/css" href="css/evento.css">
    <link rel="stylesheet" type="text/css" href="css/comentario.css">
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
                        $portada = "media/portadas-eventos/" . $evento['idEvento'] . "-p";
                        if (file_exists($portada))
                            echo $portada;
                        else
                            echo "media/portadas-eventos/0-p";
                    ?>
                    >
                    <div class="contenedor-titulo px-1 px-md-3">
                        <h1 class="nombre-evento my-1 text-center"><?php echo $evento['nombreEvento']; ?></h1>
                    </div>
                </div>
                <h5>Descripción:</h5>
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
                            Organizado por <a class="usuario" href="/perfil.php?idUsuario=<?php echo $evento['idCread']; ?>"><?php 
                                echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?></a>
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
                        <div class="mb-5 mb-sm-0 overflow-auto">
                            <i class="fa fa-hashtag"></i>
                            <b>
                                <?php
                                    $etiquetas_query = mysqli_query($db,
                                        "SELECT et.nombre, et.idEtiqueta
                                        FROM etiquetas et
                                        INNER JOIN etiquetas_eventos et_ev ON et.idEtiqueta = et_ev.idEtiqueta
                                        WHERE et_ev.idEvento = '$idEvento'
                                        ORDER BY et.nombre ASC;");
                                    while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                                        echo '<a class="mr-1" href="catalogo.php?modo=etiqueta&id='.$etiqueta['idEtiqueta'].'">' . $etiqueta['nombre'] . '</a>';
                                ?>
                            </b>
                        </div>
                        <div class="my-auto mx-auto">
                            <?php 
                                $idUsuario = $_SESSION['idUsuario'];
                                if ($idUsuario != $evento['idCread']){
                                    $inscripciones_query = mysqli_query($db,
                                        "SELECT * FROM inscripciones
                                        WHERE idUsuario = $idUsuario AND idEvento = $idEvento;");
                                    if (mysqli_num_rows($inscripciones_query) == 0)
                                        echo
                                            '<button id="inscribirse" class="eventu-button inscribirse rounded px-3">Inscribirse</button>
                                            <button id="desinscribirse" class="eventu-button inscribirse rounded px-3" hidden>Desinscribirse</button>';
                                    else
                                        echo
                                            '<button id="inscribirse" class="eventu-button inscribirse rounded px-3" hidden>Inscribirse</button>
                                            <button id="desinscribirse" class="eventu-button inscribirse rounded px-3">Desinscribirse</button>';
                                }
                                else
                                    echo
                                        '<button class="btn btn-primary" type="submit">Modificar</button>
                                        <a class="btn btn-danger ml-3"
                                            href="php-scripts/eliminar-evento.php?idEvento='.$idEvento.'">
                                            Eliminar
                                        </a>';
                            ?>
                        </div>
                    </div>
                </div>
                <h5 class="mb-5">Comentarios</h5>
                <div class="mb-4">
                    <textarea id="ingresar-comentario" class="form-control mb-3" placeholder="Escribe un comentario..."></textarea>
                    <button id="enviar-comentario" class="button btn-primary" type="button" disabled>Enviar</button>
                </div>
                <div id="comentarios" class="container comentarios">
                    <?php
                        $comentarios_query = mysqli_query($db,
                            "SELECT com.contenido, com.idUsuario, com.fechaCreac,
                            u.nombres AS nombresCread, u.apellidos AS apellidosCread
                            FROM comentarios com
                            INNER JOIN usuarios u ON u.idUsuario = com.idUsuario
                            WHERE com.idEvento = $idEvento
                            ORDER BY com.fechaCreac DESC");
                        while ($comentario = mysqli_fetch_array($comentarios_query))
                            require('comentario.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
    
    <div id="idEvento" valor="<?php echo $idEvento; ?>" hidden></div>
    <script type="text/javascript" src="js/evento-handler.js"></script>
</body>
</html>