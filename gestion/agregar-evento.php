<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
    require('../php-scripts/funciones-comunes.php');
    
    // Variables de control
    $confirma = $_REQUEST['confirma'];
    $nombre_ok = true;
    $organizador_ok = true;
    $calle_ok = true;
    $callealt_ok = true;
    $provincia_ok = true;
    $ciudad_ok = true;
    $fecreal_ok = true;
    $categoria_ok = true;
    $portada_ok = true;
    
    // Procesamiento del formulario
    if ($confirma == 'si'){
        $nombre = $_REQUEST['nombre'];
        $organizador = $_REQUEST['organizador'];
        $descripcion = $_REQUEST['descripcion'];
        $calle = $_REQUEST['calle'];
        $callealt = $_REQUEST['callealt'];
        $codProvincia = $_REQUEST['provincia'];
        $codCiudad = $_REQUEST['ciudad'];
        $fecreal = $_REQUEST['fecreal'];
        $idCategoria = $_REQUEST['categoria'];
        $etiquetas = $_REQUEST['etiquetas'];
        // Validaciones
        $nombre_ok = $nombre != "";
        $organizador_ok = $organizador != "";
        $calle_ok = $calle != "";
        $callealt_ok = $callealt > 0;
        $provincia_ok = $codProvincia != "";
        $ciudad_ok = $codCiudad != "";
        $fecreal_ok = compararFechas($fecreal, date("Y-m-d h:i:sa")) > 0;
        $categoria_ok = $idCategoria != "";
        $portada_ok = imagenCorrecta('portada');
        if ($nombre_ok && $organizador_ok && $calle_ok && $callealt_ok && $provincia_ok && $ciudad_ok && $fecreal_ok && $categoria_ok){
            mysqli_query($db,
                "INSERT INTO direcciones (calle, altura, codCiudad)
                VALUES ('$calle', '$callealt', '$codCiudad');");
            $direccion = mysqli_insert_id($db);
            $fechaCreac = date("Y-m-d h:i:sa");
            mysqli_query($db,
                "INSERT INTO eventos (nombre, fechaCreac, fechaRealiz, descripcion, idDireccion, idCreador, idCategoria)
                VALUES ('$nombre', '$fechaCreac', '$fecreal', '$descripcion', $direccion, $organizador, $idCategoria);");
            $idEvento = mysqli_insert_id($db);
            $etiquetas = strtolower($etiquetas);
            $etiquetas = preg_split("~\s+~", $etiquetas, -1, PREG_SPLIT_NO_EMPTY);
            actualizarEtiquetas($db, $etiquetas, $idEvento);
            if (is_uploaded_file($_FILES['portada']['tmp_name']))
                subirImagen($idEvento);
            header("location: eventos.php");
        }
    }
    
    // Esta funcion recibe un arreglo de etiquetas
    function actualizarEtiquetas($db, $etiquetas, $idEvento){
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
    
    function subirImagen($idEvento){
        $directorio = "../media/portadas-eventos/";
        $archivo_path = $directorio . $idEvento ."-p";
        if (!move_uploaded_file($_FILES['portada']['tmp_name'], $archivo_path))
            echo '<script language="javascript">alert("Error inesperado al tratar de subir la portada.");</script>'; 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar evento - Eventu</title>
    <?php require('comun/head-navegacion.php'); ?>
    <link rel="stylesheet" type="text/css" href="../css/formulario.css">
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-9 col-lg-10 py-5 row justify-content-center mx-auto">
                <div class="form-container col-10 col-lg-8 py-5 px-1 px-sm-3">
                    <form class="formulario-principal color-blanco" method="POST" enctype="multipart/form-data">
                        <h1 class="text-center">Incorpora un evento</h1>
                        <input type="hidden" name="confirma" value="si"/>
                        <div class="row cuerpo-form">
                            <div class="col-12 elemento-form">
                                <label for="nombre">Nombre del evento</label>
                                <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Mi evento"
                                value="<?php if(isset($_REQUEST['nombre'])) echo $_REQUEST['nombre']; ?>" required>
                                <?php
                                    if (!$nombre_ok)
                                        echo '<p class="alerta">El nombre no puede quedar vacío</p>';
                                ?>
                            </div>
                            <div class="col-12 elemento-form">
                                <label for="organizador">Organizador</label>
                                <select id="organizador" name="organizador" class="form-control" required>
                                    <option value="">Elija quien organizará el evento...</option>
                                    <?php
                                        $usuarios_query = mysqli_query($db,
                                            "SELECT idUsuario, nombres, apellidos
                                            FROM usuarios
                                            WHERE NOT tipo = 'A'
                                            ORDER BY nombres ASC;");
                                        while ($usuario = mysqli_fetch_array($usuarios_query))
                                            echo '<option value="'.$usuario['idUsuario'].'">'.$usuario['nombres'].' '.$usuario['apellidos'].'</option>';
                                    ?>
                                </select>
                                <?php
                                    if (!$organizador_ok)
                                        echo '<p class="alerta">Se requiere un organizador</p>';
                                ?>
                            </div>
                            <div class="col-12 elemento-form">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Describa al evento..."><?php if(isset($_REQUEST['descripcion'])) echo $_REQUEST['descripcion']; ?></textarea>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="categoria">Categoría</label>
                                <select id="categoria" name="categoria" class="form-control" required>
                                    <option value="">Elija una categoría...</option>
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
                                value="<?php if(isset($_REQUEST['fecreal'])) echo $_REQUEST['fecreal']; ?>" required>
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
    </div>
    <?php require('comun/barra-fondo.php'); ?>
    
    <script type="text/javascript" src="../js/manejador-ajax.js"></script>
</body>
</html>