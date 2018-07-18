<?php
    require('db.php');
    $provincias_query = mysqli_query($db, "SELECT * FROM provincias ORDER BY nombre ASC;");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <?php require('head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <header>
            <div class="logo">
                <img src="src/imagenes/logo.svg">Eventu
            </div>
        </header>
    </div>
    <div class="contenedor-pagina">
        <div class="form-container">
            <form>
                <h1 class="text-center">¡Únete para no volver a perderte un evento!</h1>
                <div class="row">
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="nombres">Nombres</label>
                        <input id="nombres" type="text" class="form-control" placeholder="Juan Martín">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="apellidos">Apellidos</label>
                        <input id="apellidos" type="text" class="form-control" placeholder="Pérez González">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="fechaNac">Fecha de nacimiento</label>
                        <input id="fechaNac" type="date" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" class="form-control" placeholder="xxx@xxx.xxx">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="calle">Calle del domicilio</label>
                        <input id="calle" type="text" class="form-control" placeholder="Calle">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="altura">Altura del domicilio</label>
                        <input id="altura" type="number" class="form-control" placeholder="123">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="provincia">Provincia</label>
                        <select id="provincia" class="form-control">
                            <option value="">Elija una provincia...</option>
                            <?php
                                while ($provincia = mysqli_fetch_array($provincias_query))
                                    echo "<option value='".$provincia['codProvincia']."'>".$provincia['nombre']."</option>";
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="ciudad">Ciudad</label>
                        <select id="ciudad" class="form-control">
                            <option value="">Primero elija una provincia</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="contrasena">Contraseña</label>
                        <input id="contrasena" type="password" class="form-control" placeholder="*****">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="contrasenaVerificacion">Verifique la contraseña</label>
                        <input id="contrasenaVerificacion" type="password" class="form-control" placeholder="*****">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn eventuButton" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    <?php require('footer-simple.php'); ?>
    
    <script type="text/javascript">
        /*global $*/
        $(document).ready(function(){
            $('#provincia').on('change',function(){
                var codProvincia = $(this).val();
                if (codProvincia){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'codProvincia='+codProvincia,
                        success:function(html){
                            $('#ciudad').html(html); 
                        }
                    }); 
                }
                else
                    $('#ciudad').html('<option value="">Primero elija una provincia</option>');
            });
        });
    </script>
</body>
</html>