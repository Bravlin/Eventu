<?php
    $requiere_sesion = true;
    $solo_administrador = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
    
    $idUsuario = $_REQUEST['idUsuario'];
    $usuarios_query = mysqli_query($db,
        "SELECT u.nombres AS nombresUsuario, u.apellidos, u.fechaNac, u.email,
        c.nombre AS nombreCiudad,
        prov.nombre AS nombreProvincia
        FROM usuarios u
        INNER JOIN direcciones dir ON dir.idDireccion = u.idDireccion
        INNER JOIN ciudades c ON c.codCiudad = dir.codCiudad
        INNER JOIN provincias prov ON prov.codProvincia = c.codCiudad
        WHERE u.idUsuario = '$idUsuario';");
    if (mysqli_num_rows($usuarios_query) == 1)
        $usuario = mysqli_fetch_array($usuarios_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $usuario['nombresUsuario'] . ' ' . $usuario['apellidos']; ?> - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/perfil.css">
    <link rel="stylesheet" type="text/css" href="css/item-consulta.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <div class=" info-perfil rounded row py-3 mx-2 mb-5 text-center">
                    <div class="col-12">
                        <img class="avatar rounded-circle" alt="perfil" 
                            src=<?php
                                $avatar = "media/perfiles-usuarios/" . $idUsuario . "-perfil";
                                if (file_exists($avatar))
                                    echo $avatar;
                                else
                                    echo "media/perfiles-usuarios/0-perfil";
                            ?>
                        >
                    </div>
                    <div class="col-12 my-5">
                        <h2><?php echo $usuario['nombresUsuario'] . ' ' . $usuario['apellidos']; ?></h2>
                        <?php
                            if ($idUsuario == $_SESSION['idUsuario'])
                                echo '<a class="cerrar-sesion" href="/php-scripts/sesion-baja.php"><i class="fa fa-sign-out mr-1"></i>Cerrar sesión</a>';
                        ?>
                    </div>
                    <div class="col-12">
                        <i class="fa fa-birthday-cake"></i>
                        <?php echo date("d/m/Y", strtotime($usuario['fechaNac'])); ?>
                    </div>
                    <div class="col-12">
                        <i class="fa fa-map-marker"></i>
                        <?php echo $usuario['nombreCiudad'] . ', ' . $usuario['nombreProvincia']; ?>
                    </div>
                    <div class="col-12">
                        <i class="fa fa-envelope"></i>
                        <?php echo $usuario['email']; ?>
                    </div>
                </div>
                <h3>Eventos organizados por <?php echo $usuario['nombresUsuario']; ?></h3>
                <div class="row">
                    <?php
                        $eventos_query = mysqli_query($db, 
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
                            WHERE e.idCreador = '$idUsuario'
                            ORDER BY e.fechaRealiz ASC
                            LIMIT 4;");
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