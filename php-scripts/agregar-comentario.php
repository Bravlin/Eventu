<?php
    session_start();
    require('db.php');
    $idEvento = $_REQUEST['idEvento'];
    $contenido = $_REQUEST['contenido'];
    $fechaCreac = date("Y-m-d h:i:sa");
    $idUsuario = $_SESSION['idUsuario'];
    mysqli_query($db,
        "INSERT INTO comentarios (contenido, fechaCreac, idUsuario, idEvento)
        VALUES ('$contenido', '$fechaCreac', $idUsuario, $idEvento);");
    $idComentario = mysqli_insert_id($db);
    $comentarios_query = mysqli_query($db,
        "SELECT com.contenido, com.idUsuario, com.fechaCreac,
        u.nombres AS nombresCread, u.apellidos AS apellidosCread
        FROM comentarios com
        INNER JOIN usuarios u ON u.idUsuario = com.idUsuario
        WHERE com.idComentario = $idComentario");
    $comentario = mysqli_fetch_array($comentarios_query);
    require('../comentario.php');
?>