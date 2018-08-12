<?php
    require('../../php-scripts/db.php');
    $estados_validos = array('aprobado', 'rechazado', 'pendiente');
    $idEvento = $_REQUEST['idEvento'];
    $accion = $_REQUEST['accion'];
    if (in_array($accion, $estados_validos))
        mysqli_query($db, "UPDATE eventos SET estado = '$accion' WHERE idEvento = '$idEvento';");
?>