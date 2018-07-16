<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <?php require('header-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
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
                        <input id="provincia" type="text" class="form-control" placeholder="Provincia">
                    </div>
                    <div class="col-sm-12 col-md-6 elemento-form">
                        <label for="ciudad">Ciudad</label>
                        <input id="ciudad" type="text" class="form-control" placeholder="Ciudad">
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
</body>
</html>