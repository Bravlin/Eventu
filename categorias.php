<?php
    $requiere_sesion = true;
    require('php-scripts/sesion-redireccion.php');
    require('php-scripts/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <?php require('comun/head-navegacion.php'); ?>
    <title>Categorías - Eventu</title>
    
    <style>
        .categoria{
            text-decoration: none;
            color: var(--eventu-pink);
        }
        
        .categoria:hover{
            color: var(--eventu-pink);
        }
    </style>
</head>
<body>
    <?php require('comun/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php require('comun/barra-vertical.php'); ?>
            <div class="col-12 col-md-10 py-5 row">
                <?php
                    $categorias_query = mysqli_query($db, "SELECT * FROM categorias ORDER BY nombre ASC;");
                    while ($categoria = mysqli_fetch_array($categorias_query))
                        require('panel-categoria.php');
                ?>
            </div>
        </div>
    </div>
    <?php require('comun/barra-fondo.php'); ?>
</body>
</html>