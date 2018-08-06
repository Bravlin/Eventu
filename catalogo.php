<?php
    $requiere_sesion = true;
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
                $titulo = mysqli_fetch_array($query)['nombre'];
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
                $titulo = '#' . mysqli_fetch_array($query)['nombre'];
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
    <title><?php echo ($titulo != "") ? $titulo : 'Error'; ?> - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-10 py-5">
                <?php
                    if ($titulo == "")
                        echo "<p>Error</p>";
                    else {
                        $eventos_query = mysqli_query($db, $consulta);
                        while ($evento = mysqli_fetch_array($eventos_query))
                            require('item-consulta.php');
                    }
                ?>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>