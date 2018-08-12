<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
    
    // Recuperar evento
    $idEvento = $_REQUEST['idEvento'];
    $eventos_query = mysqli_query($db,
        "SELECT e.idEvento, e.nombre, e.descripcion, e.fechaRealiz,
        dir.calle, dir.altura,
        ciudades.nombre AS nombreCiudad,
        provincias.nombre AS nombreProvincia,
        cat.nombre AS nombreCateg, cat.idCategoria
        FROM eventos e
        INNER JOIN direcciones dir ON e.idDireccion = dir.idDireccion
        INNER JOIN ciudades ON ciudades.codCiudad = dir.codCiudad
        INNER JOIN provincias ON provincias.codProvincia = ciudades.codProvincia
        INNER JOIN categorias cat ON cat.idCategoria = e.idCategoria
        WHERE e.idEvento = '$idEvento';");
    if (mysqli_num_rows($eventos_query) == 1)
        $evento = mysqli_fetch_array($eventos_query);
    
    // Variables de control
    $confirma = $_REQUEST['confirma'];
    $nombre_ok = true;
    $calle_ok = true;
    $callealt_ok = true;
    $provincia_ok = true;
    $ciudad_ok = true;
    $fecreal_ok = true;
    $categoria_ok = true;
    $portada_ok = true;
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="/css/formulario.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5">
                <form class="formulario-principal color-blanco" method="POST" enctype="multipart/form-data">
                    <h1 class="text-center">Agrega tu propio evento</h1>
                    <input type="hidden" name="confirma" value="si"/>
                    <div class="row cuerpo-form">
                        <div class="col-12 elemento-form">
                            <label for="nombre">Nombre del evento</label>
                            <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Mi evento"
                                value="<?php 
                                    if (isset($_REQUEST['nombre']))
                                        echo $_REQUEST['nombre'];
                                    else
                                        echo $evento['nombre'];
                                ?>" 
                            required>
                            <?php
                                if (!$nombre_ok)
                                    echo '<p class="alerta">El nombre no puede quedar vacío</p>';
                            ?>
                        </div>
                        <div class="col-12 elemento-form">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Describa al evento...">
                                <?php
                                    if (isset($_REQUEST['descripcion']))
                                        echo $_REQUEST['descripcion'];
                                    else
                                        echo $evento['descripcion'];
                                ?>
                            </textarea>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="categoria">Categoría</label>
                            <select id="categoria" name="categoria" class="form-control" required>
                                <option value="<?php echo $evento['idCategoria']; ?>" selected="selected">
                                    <?php echo $evento['nombreCategoria']; ?>
                                </option>
                                <?php
                                    $categorias_query = mysqli_query($db, "SELECT * FROM categorias ORDER BY nombre ASC;");
                                    while ($categoria = mysqli_fetch_array($categorias_query))
                                        echo "<option value='".$categoria['idCategoria']."'>".$categoria['nombre']."</option>";
                                ?>
                            </select>
                            <?php
                                if (!$categoria_ok)
                                    echo '<p class="alerta">Ninguna categoría ha sido seleccionada</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="fechaReal">Fecha y hora de realización</label>
                            <input id="fechaReal" name="fecreal" type="datetime-local" class="form-control"
                                value="<?php 
                                    if (isset($_REQUEST['fecreal']))
                                        echo $_REQUEST['fecreal'];
                                    else
                                        echo $evento['fechaRealiz'];
                                ?>" 
                            required>
                            <?php
                                if (!$fecreal_ok)
                                    echo '<p class="alerta">Ingrese una fecha válida</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="calle">Calle</label>
                            <input id="calle" name="calle" type="text" class="form-control" placeholder="Calle"
                            value="<?php if(isset($_REQUEST['calle'])) echo $_REQUEST['calle']; ?>" required>
                            <?php
                                if (!$calle_ok)
                                    echo '<p class="alerta">La calle no puede quedar vacía</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="altura">Altura</label>
                            <input id="altura" name="callealt" type="number" class="form-control" placeholder="123"
                            value="<?php if(isset($_REQUEST['callealt'])) echo $_REQUEST['callealt']; ?>" required>
                            <?php
                                if (!$callealt_ok)
                                    echo '<p class="alerta">Altura inválida</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="provincia">Provincia</label>
                            <select id="provincia" name="provincia" class="form-control" required>
                                <option value="">Elija una provincia...</option>
                                <?php
                                    $provincias_query = mysqli_query($db, "SELECT * FROM provincias ORDER BY nombre ASC;");
                                    while ($provincia = mysqli_fetch_array($provincias_query))
                                        echo "<option value='".$provincia['codProvincia']."'>".$provincia['nombre']."</option>";
                                ?>
                            </select>
                            <?php
                                if (!$provincia_ok)
                                    echo '<p class="alerta">Ninguna provincia ha sido seleccionada</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-6 elemento-form">
                            <label for="ciudad">Ciudad</label>
                            <select id="ciudad" name="ciudad" class="form-control" required>
                                <option value="">Primero elija una provincia</option>
                            </select>
                            <?php
                                if (!$ciudad_ok)
                                    echo '<p class="alerta">Ninguna ciudad ha sido seleccionada</p>';
                            ?>
                        </div>
                        <div class="col-12 elemento-form">
                            <label for="etiquetas">Etiquetas</label>
                            <input id="etiquetas" name="etiquetas" type="text" class="form-control" placeholder="Ingrese las etiquetas separadas por espacios"
                            value="<?php if(isset($_REQUEST['etiquetas'])) echo $_REQUEST['etiquetas']; ?>">
                        </div>
                        <div class="col-12 elemento-form">
                            <label for="portada">Portada</label>
                            <input id="portada" name="portada" type="file" class="form-control">
                            <?php
                                if (!$portada_ok)
                                    echo '<p class="alerta">Archivo no válido.</p>';
                            ?>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <button class="btn eventuButton" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>