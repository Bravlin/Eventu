<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
    require('../php-scripts/funciones-comunes.php');
    
    // Variables de control
    $nombre_ok = true;
    $calle_ok = true;
    $callealt_ok = true;
    $provincia_ok = true;
    $ciudad_ok = true;
    $provincia_ok = true;
    $ciudad_ok = true;
    $fecreal_ok = true;
    $categoria_ok = true;
    $estado_ok = true;
    
    $confirma = $_REQUEST['confirma'];
    $idEvento = $_REQUEST['idEvento'];
    if ($confirma != 'si'){
        $eventos_query = mysqli_query($db,
            "SELECT e.idEvento, e.nombre AS nombreEvento, e.descripcion, e.fechaRealiz, e.estado,
            dir.calle, dir.altura,
            ciudades.nombre AS nombreCiudad, ciudades.codCiudad,
            provincias.nombre AS nombreProvincia, provincias.codProvincia,
            u.nombres AS nombresCread, u.apellidos AS apellidosCread,
            cat.nombre AS nombreCateg, cat.idCategoria
            FROM eventos e
            INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
            INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
            INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
            INNER JOIN usuarios u ON u.idUsuario = e.idCreador
            INNER JOIN categorias cat ON cat.idCategoria = e.idCategoria
            WHERE e.idEvento = '$idEvento';");
        if (mysqli_num_rows($eventos_query) == 1){
            $evento = mysqli_fetch_array($eventos_query);
            $idCategoria = $evento['idCategoria'];
            $nombreEvento = $evento['nombreEvento'];
            $descripcion = $evento['descripcion'];
            $calle = $evento['calle'];
            $altura = $evento['altura'];
            $codProvincia = $evento['codProvincia'];
            $codCiudad = $evento['codCiudad'];
            $fechaRealiz = $evento['fechaRealiz'];
            $estado = $evento['estado'];
            $etiquetas = '';
            $etiquetas_query = mysqli_query($db,
                "SELECT et.nombre
                FROM etiquetas et
                INNER JOIN etiquetas_eventos et_ev ON et.idEtiqueta = et_ev.idEtiqueta
                WHERE et_ev.idEvento = '$idEvento'
                ORDER BY et.nombre ASC;");
            while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                $etiquetas = $etiquetas . $etiqueta['nombre'] . " ";
        }
    }
    else {
        // Procesamiento del formulario
        $idCategoria = $_REQUEST['categoria'];
        $nombreEvento = $_REQUEST['nombre'];
        $descripcion = $_REQUEST['descripcion'];
        $calle = $_REQUEST['calle'];
        $altura = $_REQUEST['callealt'];
        $codProvincia = $_REQUEST['provincia'];
        $codCiudad = $_REQUEST['ciudad'];
        $fechaRealiz = $_REQUEST['fecreal'];
        $estado = $_REQUEST['estado'];
        $etiquetas = $_REQUEST['etiquetas'];
        // Validaciones
        $nombre_ok = $nombreEvento != "";
        $calle_ok = $calle != "";
        $callealt_ok = $altura > 0;
        $provincia_ok = $codProvincia != "";
        $ciudad_ok = $codCiudad != "";
        $fecreal_ok = compararFechas($fechaRealiz, date("Y-m-d h:i:sa")) > 0;
        $categoria_ok = $idCategoria != "";
        $estado_ok = $estado == 'pendiente' || $estado == 'aprobado' || $estado == 'rechazado';
        if ($nombre_ok && $calle_ok && $callealt_ok && $provincia_ok && $ciudad_ok && $fecreal_ok && $categoria_ok && $estado_ok){
            $eventos_query = mysqli_query($db, "SELECT idDireccion FROM eventos WHERE idEvento = $idEvento;");
            $idDireccion = mysqli_fetch_array($eventos_query)['idDireccion'];
            mysqli_query($db,
                "UPDATE direcciones
                SET calle = '$calle', altura = $altura, codCiudad = $codCiudad
                WHERE idDireccion = $idDireccion;");
            mysqli_query($db,
                "UPDATE eventos
                SET idCategoria = $idCategoria, nombre = '$nombreEvento', descripcion = '$descripcion',
                fechaRealiz = '$fechaRealiz', estado = '$estado'
                WHERE idEvento = $idEvento;");
            $etiquetas = strtolower($etiquetas);
            $etiquetas = preg_split("~\s+~", $etiquetas, -1, PREG_SPLIT_NO_EMPTY);
            actualizarEtiquetas($db, $etiquetas, $idEvento);
            header("location: evento.php?idEvento=$idEvento");
        }
    }
    
    // Esta funcion recibe un arreglo de etiquetas
    function actualizarEtiquetas($db, $etiquetas, $idEvento){
        $etiquetas_existentes_query = mysqli_query($db,
            "SELECT et.nombre, et.idEtiqueta, et_ev.idEtiquetaEvento
            FROM etiquetas et
            INNER JOIN etiquetas_eventos et_ev ON et_ev.idEtiqueta = et.idEtiqueta
            WHERE et_ev.idEvento = $idEvento;");
        while ($etiqueta_existente = mysqli_fetch_array($etiquetas_existentes_query))
            if (!in_array($etiqueta_existente['nombre'], $etiquetas))
                mysqli_query($db, "DELETE FROM etiquetas_eventos WHERE idEtiquetaEvento = ".$etiqueta_existente['idEtiquetaEvento'].";");
            else {
                $pos = array_search($etiqueta_existente['nombre'], $etiquetas);
                array_splice($etiquetas, $pos, 1);
            }
        foreach ($etiquetas as $nombreEtiqueta){
            $etiquetas_query = mysqli_query($db, "SELECT * FROM etiquetas WHERE nombre = '$nombreEtiqueta';");
            if (mysqli_num_rows($etiquetas_query) == 0){
                mysqli_query($db,
                    "INSERT INTO etiquetas (nombre)
                    VALUES ('$nombreEtiqueta');");
                $idEtiqueta = mysqli_insert_id($db);
            }
            else {
                $etiqueta = mysqli_fetch_array($etiquetas_query);
                $idEtiqueta = $etiqueta['idEtiqueta'];
            }
            mysqli_query($db,
                "INSERT INTO etiquetas_eventos (idEtiqueta, idEvento)
                VALUES ('$idEtiqueta', '$idEvento');");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $nombreEvento; ?> - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="/css/evento.css">
    <link rel="stylesheet" type="text/css" href="css/edicion-evento.css">
    <link rel="stylesheet" type="text/css" href="/css/comentario.css">
    <style>
        .alerta{
            color: red;
        }
    </style>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5 px-md-5">
                <form method="POST" enctype="multipart/form-data">
                    <select id="categoria" name="categoria" class="editable ed-categoria mb-2" required>
                        <?php
                            $categorias_query = mysqli_query($db, "SELECT * FROM categorias ORDER BY nombre ASC;");
                            while ($categoria = mysqli_fetch_array($categorias_query))
                                if ($categoria['idCategoria'] == $idCategoria)
                                    echo '<option value="'.$categoria['idCategoria'].'" selected>'.$categoria['nombre'].'</option>';
                                else
                                    echo '<option value="'.$categoria['idCategoria'].'">'.$categoria['nombre'].'</option>';
                        ?>
                    </select>
                    <?php
                        if (!$categoria_ok)
                            echo '<p class="alerta">Ninguna categoría ha sido seleccionada</p>';
                    ?>
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
                            <input id="nombre" name="nombre" type="text" class="editable ed-nombre" value="<?php echo $nombreEvento; ?>" required>
                        </div>
                        <?php
                            if (!$nombre_ok)
                                echo '<p class="alerta">El nombre no puede quedar vacío</p>';
                        ?>
                    </div>
                    <h5>Descripción:</h5>
                    <textarea id="descripcion" name="descripcion" class="editable ed-descripcion"><?php echo $descripcion; ?></textarea>
                    <div class="info-general row py-3 my-5">
                        <div class="col-12 col-sm-6 mb-3 mb-sm-0 row">
                            <div class="col-12 mb-3">
                                <i class="fa fa-map-marker"></i> Ubicación
                            </div>
                            <div class="col-sm-12 col-lg-6 elemento-form mb-2">
                                <label for="calle">Calle</label>
                                <input id="calle" name="calle" type="text" class="form-control"
                                    value="<?php echo $calle; ?>" required>
                                <?php
                                    if (!$calle_ok)
                                        echo '<p class="alerta">La calle no puede quedar vacía</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-lg-6 elemento-form mb-2">
                                <label for="altura">Altura</label>
                                <input id="altura" name="callealt" type="number" class="form-control"
                                    value="<?php echo $altura; ?>" required>
                                <?php
                                    if (!$callealt_ok)
                                        echo '<p class="alerta">Altura inválida</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-lg-6 elemento-form mb-2">
                                <label for="provincia">Provincia</label>
                                <select id="provincia" name="provincia" class="form-control" required>
                                    <?php
                                        $provincias_query = mysqli_query($db, "SELECT * FROM provincias ORDER BY nombre ASC;");
                                        while ($provincia = mysqli_fetch_array($provincias_query))
                                            if ($provincia['codProvincia'] == $codProvincia)
                                                echo "<option value='".$provincia['codProvincia']."' selected>".$provincia['nombre']."</option>";
                                            else
                                                echo "<option value='".$provincia['codProvincia']."'>".$provincia['nombre']."</option>";
                                    ?>
                                </select>
                                <?php
                                    if (!$provincia_ok)
                                        echo '<p class="alerta">Ninguna provincia ha sido seleccionada</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-lg-6 elemento-form mb-2">
                                <label for="ciudad">Ciudad</label>
                                <select id="ciudad" name="ciudad" class="form-control" required>
                                    <?php
                                        $ciudades_query = mysqli_query($db,
                                            "SELECT * FROM ciudades
                                            WHERE codProvincia =".$codProvincia." ORDER BY nombre ASC;");
                                        while ($ciudad = mysqli_fetch_array($ciudades_query))
                                            if ($ciudad['codCiudad'] == $codCiudad)
                                                echo "<option value='".$ciudad['codCiudad']."' selected>".$ciudad['nombre']."</option>";
                                            else
                                                echo "<option value='".$ciudad['codCiudad']."'>".$ciudad['nombre']."</option>";
                                    ?>
                                </select>
                                <?php
                                    if (!$ciudad_ok)
                                        echo '<p class="alerta">Ninguna ciudad ha sido seleccionada</p>';
                                ?>
                            </div>
                            <div class="contenedor-nivel2 mt-3 col-12">
                                <div class="contenedor-mapa">
                                    <?php
                                        $ubicacion = $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia'];
                                    ?>
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
                            <div class="mb-2">
                                <label for="fechaReal"><i class="fa fa-calendar"></i> Fecha y <i class="fa fa-clock-o"></i> hora</label>
                                <input id="fechaReal" name="fecreal" type="datetime-local" class="form-control"
                                    value="<?php echo date('Y-m-d\TH:i', strtotime($fechaRealiz)); ?>" required>
                                <?php
                                    if (!$fecreal_ok)
                                        echo '<p class="alerta">Ingrese una fecha válida</p>';
                                ?>
                            </div>
                            <div class="mb-5 mb-sm-0">
                                <label for="etiquetas"><i class="fa fa-hashtag"></i> Etiquetas</label>
                                <input id="etiquetas" name="etiquetas" type="text" class="form-control"
                                    value = "<?php echo $etiquetas; ?>">
                            </div>
                            <div class="text-center my-auto mx-auto">
                                <div class="d-inline-flex align-items-center">
                                    <label for="estado" class="mr-3 my-0">Estado:</label>
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="pendiente" <?php if ($estado == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="aprobado" <?php if ($estado == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                                        <option value="rechazado" <?php if ($estado == 'rechazado') echo 'selected'; ?>>Rechazado</option>
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <input type="hidden" name="confirma" value="si"/>
                                    <button class="btn btn-primary" type="submit">Modificar</button>
                                    <a class="btn btn-danger ml-3"
                                        href="php-scripts/eliminar-evento.php?idEvento=<?php echo $idEvento; ?>">
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    
    <script type="text/javascript" src="/js/manejador-ajax.js"></script>
</body>
</html>