<?php
    require('db.php');
    $idComentario = $_REQUEST['idComentario'];
    mysqli_query($db, "DELETE FROM comentarios WHERE idComentario = $idComentario;");
?>