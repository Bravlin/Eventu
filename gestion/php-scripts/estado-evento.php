<?php
    require('../../php-scripts/db.php');
    $idEvento = $_REQUEST['idEvento'];
    $accion = $_REQUEST['accion'];
    switch ($accion){
        case 'aceptar':
            $estado = 'A';
            break;
    }
    mysqli_query($db, "UPDATE eventos SET estado = '$estado' WHERE idEvento = '$idEvento';");
?>