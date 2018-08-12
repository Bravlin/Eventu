<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
    
    $modo = $_REQUEST['modo'];
    $id = $_REQUEST['id'];
    switch ($modo){
        case 'categoria':
            $query = mysqli_query($db, "SELECT nombre FROM categorias WHERE idCategoria = '$id';");
            if (mysqli_num_rows($query) != 1)
                $titulo = "";
            else {
                $nombre = mysqli_fetch_array($query)['nombre'];
                $titulo = '<h1 class="text-center categoria">' . $nombre . '</h1>';
                $consulta = 
                    "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz,
                    dir.calle, dir.altura,
                    ciudades.nombre AS nombreCiudad,
                    provincias.nombre AS nombreProvincia,
                    categorias.nombre AS nombreCateg
                    FROM eventos e
                    INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
                    INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                    INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                    INNER JOIN categorias ON categorias.idCategoria = e.idCategoria
                    WHERE e.idCategoria = '$id'
                    ORDER BY e.fechaRealiz ASC;";
            }
            break;
        case 'etiqueta':
            $query = mysqli_query($db, "SELECT nombre FROM etiquetas WHERE idEtiqueta = '$id';");
            if (mysqli_num_rows($query) != 1)
                $titulo = "";
            else {
                $nombre = mysqli_fetch_array($query)['nombre'];
                $sigue_query = mysqli_query($db,
                    "SELECT * FROM etiquetas_usuarios WHERE idEtiqueta = '$id' AND idUsuario = '".$_SESSION['idUsuario']."';");
                if (mysqli_num_rows($sigue_query) == 0)
                    $titulo = '<h1 class="text-center text-primary">#' . $nombre .
                        '<span><button type="button" id="seguir" class="btn btn-primary ml-3">Seguir</button></span>
                        <span><button hidden type="button" id="dejar-seguir" class="btn btn-outline-primary ml-3">Dejar de seguir</button></span>
                        </h1>';
                else
                    $titulo = '<h1 class="text-center text-primary">#' . $nombre .
                        '<span><button hidden type="button" id="seguir" class="btn btn-primary ml-3">Seguir</button></span>
                        <span><button  type="button" id="dejar-seguir" class="btn btn-outline-primary ml-3">Dejar de seguir</button></span>
                        </h1>';
                $consulta =
                    "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaRealiz,
                    dir.calle, dir.altura,
                    ciudades.nombre AS nombreCiudad,
                    provincias.nombre AS nombreProvincia,
                    categorias.nombre AS nombreCateg
                    FROM eventos e
                    INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
                    INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
                    INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
                    INNER JOIN categorias ON categorias.idCategoria = e.idCategoria
                    INNER JOIN etiquetas_eventos et_ev ON et_ev.idEvento = e.idEvento
                    WHERE et_ev.idEtiqueta = '$id'
                    ORDER BY e.fechaRealiz ASC;";
            }
            break;
        default:
            $titulo = "";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo ($nombre != "") ? $nombre : 'Error'; ?> - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/item-consulta.css">
    <style>
        .categoria{
            color: var(--eventu-pink);
        }
    </style>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <?php
                    if ($titulo == "")
                        echo '<p class="text-center">Error</p>';
                    else {
                        echo $titulo;
                    
                ?>
                <div class="row">
                <?php
                        $eventos_query = mysqli_query($db, $consulta);
                        while ($evento = mysqli_fetch_array($eventos_query))
                            require('item-consulta.php');
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
    
    <div id="idElemento" valor="<?php echo $id; ?>" hidden></div>
    <script type="text/javascript" src="js/seguimiento-handler.js"></script>
</body>
</html>