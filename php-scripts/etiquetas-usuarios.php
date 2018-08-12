<?php
    session_start();
    require('db.php');
    $idEtiqueta = $_REQUEST['idEtiqueta'];
    $accion = $_REQUEST['accion'];
    $idUsuario = $_SESSION['idUsuario'];
    switch ($accion){
        case 'seguir':
            mysqli_query($db, "INSERT INTO etiquetas_usuarios (idEtiqueta, idUsuario) VALUES ($idEtiqueta, $idUsuario);");
            break;
        case 'dejar':
            mysqli_query($db, "DELETE FROM etiquetas_usuarios WHERE idEtiqueta = $idEtiqueta AND idUsuario = $idUsuario;");
            break;
    }
?>