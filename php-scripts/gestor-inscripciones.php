<?php
    session_start();
    require('db.php');
    $idEvento = $_REQUEST['idEvento'];
    $idUsuario = $_SESSION['idUsuario'];
    $accion = $_REQUEST['accion'];
    switch ($accion){
        case 'inscribir':
            mysqli_query($db, "INSERT INTO inscripciones (idUsuario, idEvento) VALUES ($idUsuario, $idEvento);");
            break;
        case 'desinscribir':
            mysqli_query($db, "DELETE FROM inscripciones WHERE idUsuario = $idUsuario AND idEvento = $idEvento;");
            break; 
    }
?>