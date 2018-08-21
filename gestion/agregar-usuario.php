<?php
    $requiere_sesion = true;
    $solo_administrador = true;
    require('../php-scripts/sesion-redireccion.php');
    require('../php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar usuario - Eventu</title>
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
                        <h1 class="text-center">Agrega un usuario</h1>
                        <input type="hidden" name="confirma" value="si"/>
                        <div class="row cuerpo-form">
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="nombres">Nombres</label>
                                <input id="nombres" name="nombres" type="text" class="form-control" placeholder="Juan Martín"
                                value="<?php if(isset($_REQUEST['nombres'])) echo $_REQUEST['nombres']; ?>" required>
                                <?php
                                    if (!$nombres_ok)
                                        echo '<p class="alerta">El nombre no puede quedar vacío</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="apellidos">Apellidos</label>
                                <input id="apellidos" name="apellidos" type="text" class="form-control" placeholder="Pérez González"
                                value="<?php if(isset($_REQUEST['apellidos'])) echo $_REQUEST['apellidos']; ?>" required>
                                <?php
                                    if (!$apellidos_ok)
                                        echo '<p class="alerta">El apellido no puede quedar vacío</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="fechaNac">Fecha de nacimiento</label>
                                <input id="fechaNac" name="fecnac" type="date" class="form-control"
                                value="<?php if(isset($_REQUEST['fecnac'])) echo $_REQUEST['fecnac']; ?>" required>
                                <?php
                                    if (!$fecnac_ok)
                                        echo '<p class="alerta">Ingrese una fecha válida</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="email">E-mail</label>
                                <input id="email" name="email" type="email" class="form-control" placeholder="xxx@xxx.xxx"
                                value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>" required>
                                <?php
                                    if (!$email_ok)
                                        echo '<p class="alerta">Email inválido</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="calle">Calle del domicilio</label>
                                <input id="calle" name="calle" type="text" class="form-control" placeholder="Calle"
                                value="<?php if(isset($_REQUEST['calle'])) echo $_REQUEST['calle']; ?>" required>
                                <?php
                                    if (!$calle_ok)
                                        echo '<p class="alerta">La calle no puede quedar vacía</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="altura">Altura del domicilio</label>
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
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="contrasena">Contraseña</label>
                                <input id="contrasena" name="contrasena" type="password" class="form-control" placeholder="*****"
                                value="<?php if(isset($_REQUEST['contrasena'])) echo $_REQUEST['contrasena']; ?>" required>
                                <?php
                                    if (!$contrasena_ok)
                                        echo '<p class="alerta">La contraseña no puede quedar vacía</p>';
                                ?>
                            </div>
                            <div class="col-sm-12 col-md-6 elemento-form">
                                <label for="contrasenaVerificacion">Verifique la contraseña</label>
                                <input id="contrasenaVerificacion" name="contrasverif" type="password" class="form-control" placeholder="*****"
                                value="<?php if(isset($_REQUEST['contrasverif'])) echo $_REQUEST['contrasverif']; ?>" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <button id="enviar" class="btn eventuButton" type="submit" disabled>Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>