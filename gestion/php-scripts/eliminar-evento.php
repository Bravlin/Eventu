<?php
    require('../../php-scripts/db.php');
    $idEvento = $_REQUEST['idEvento'];
    mysqli_query($db, "DELETE FROM etiquetas_eventos WHERE idEvento = $idEvento;");
    mysqli_query($db, "DELETE FROM eventos WHERE idEvento = $idEvento;");
    header("location: ../home.php");
?>