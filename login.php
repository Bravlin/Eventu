<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <?php require('head-comun.php'); ?>
    <link rel="stylesheet" type="text/css" href="css/login.css">
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
            <form class="text-center">
                <h1>Entérate de tus próximos eventos</h1>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email o nombre de usuario">
                <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña">
                <div>
                    <label>
                        <input type="checkbox" value="remember-me"> Recordarme
                    </label>
                    <button class="btn eventuButton" type="submit">Acceder</button>
                </div>
                <p><a href="">¿Olvidaste tu contraseña?</a></p>
                <p><a href="registro.php">Registrate</a></p>
            </form>
        </div>
    </div>
    <?php require('footer-simple.php'); ?>
</body>
</html>