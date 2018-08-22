<?php
    $requiere_sesion = false;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
    require('php-scripts/funciones-comunes.php');
    
    // Verificadores
    $confirma = $_REQUEST['confirma'];
    $nombres_ok = true;
    $apellidos_ok = true;
    $fecnac_ok = true;
    $email_ok = true;
    $calle_ok = true;
    $callealt_ok = true;
    $provincia_ok = true;
    $ciudad_ok = true;
    $contrasena_ok = true;
    $perfil_ok = true;
    
    // Procesamiento del formulario
    if ($confirma == 'si'){
        $nombres = $_REQUEST['nombres'];
        $apellidos = $_REQUEST['apellidos'];
        $fecnac = $_REQUEST['fecnac'];
        $email = $_REQUEST['email'];
        $calle = $_REQUEST['calle'];
        $callealt = $_REQUEST['callealt'];
        $codProvincia = $_REQUEST['provincia'];
        $codCiudad = $_REQUEST['ciudad'];
        $contrasena = $_REQUEST['contrasena'];
        $contrasVerif = $_REQUEST['contrasverif'];
        // Validaciones
        $nombres_ok = $nombres != '';
        $apellidos_ok = $apellidos != '';
        $fecnac_ok = compararFechas($fecnac, date("Y-m-d")) < 0;
        $email_ok = validaEmail($email, $db);
        $calle_ok = $calle != '';
        $callealt_ok = $callealt > 0;
        $provincia_ok = $codProvincia > 0;
        $ciudad_ok = $codCiudad > 0;
        $contrasena_ok = $contrasena != '' && $contrasena == $contrasVerif;
        $perfil_ok = imagenCorrecta('perfil');
        if ($nombres_ok && $apellidos_ok && $fecnac_ok && $email_ok && $calle_ok && $callealt_ok && $provincia_ok && $ciudad_ok && $contrasena_ok && $perfil_ok){
            $contrasena = md5($contrasena);
            mysqli_query($db, "INSERT INTO direcciones (calle, altura, codCiudad) VALUES ('$calle', '$callealt', '$codCiudad');");
            $direccion = mysqli_insert_id($db);
            mysqli_query($db, "INSERT INTO usuarios (nombres, apellidos, fechaNac, email, clave, idDireccion)
                VALUES ('$nombres', '$apellidos', '$fecnac', '$email', '$contrasena', '$direccion');");
            if (is_uploaded_file($_FILES['perfil']['tmp_name']))
                subirImagen(mysqli_insert_id($db));
            header("location: login.php");
        }
    }
    
    function validaEmail($email, $db){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $query_verificacion = mysqli_query($db, "SELECT * FROM usuarios WHERE email = '$email';");
            return mysqli_num_rows($query_verificacion) == 0;
        }
        else
            return false;
    }
    
    function subirImagen($idUsuario){
        $directorio = "media/perfiles-usuarios/";
        $archivo_path = $directorio . $idUsuario ."-perfil";
        if (!move_uploaded_file($_FILES['perfil']['tmp_name'], $archivo_path))
            echo '<script language="javascript">alert("Error inesperado al tratar de subir la imagen de perfil.");</script>'; 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro - Eventu</title>
    <?php require('comun/head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/formulario.css">
    <script src="/js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <header>
        <div class="container-fluid text-center">
            <a class="logo mb-5 mt-0" href="index.php">
                <img src="src/imagenes/logo.svg">Eventu
            </a>
        </div>
    </header>
    <div class="contenedor-pagina row justify-content-center color-eventu-red mx-0">
        <div class="form-container col-10 col-lg-8">
            <form class="formulario-principal color-blanco py-5 px-1 px-sm-3" method="POST" enctype="multipart/form-data">
                <h1 class="text-center">¡Únete para no volver a perderte un evento!</h1>
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
                    <div class="col-12 elemento-form">
                        <label for="perfil">Foto de perfil (no obligatorio)</label>
                        <input id="perfil" name="perfil" type="file" class="form-control">
                        <?php
                            if (!$perfil_ok)
                                echo '<p class="alerta">Archivo no válido.</p>';
                        ?>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button id="enviar" class="btn eventuButton" type="submit" disabled>Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <?php require('comun/footer-simple.php'); ?>
    
    <script type="text/javascript" src="js/manejador-ajax.js"></script>
    <script>
        /*global $*/
        
        $(document).ready(function(){
            $('#contrasena, #contrasenaVerificacion').on('keyup blur', function(){
                var contrasena = $('#contrasena').val();
                var contrasenaCheck = $('#contrasenaVerificacion').val();
                if (contrasena == contrasenaCheck){
                   $('#contrasenaVerificacion').toggleClass('erroneo', false);
                   $('#contrasenaVerificacion').toggleClass('valido', true);
                   $('#enviar').prop("disabled", false);
                }
                else {
                   $('#contrasenaVerificacion').toggleClass('valido', false);
                   $('#contrasenaVerificacion').toggleClass('erroneo', true);
                   $('#enviar').prop("disabled", true);
                }
            });
        });
    </script>
</body>
</html>