<?php
    session_start();
    if ($_SESSION['idUsuario'] != ""){
        session_destroy();
        $_SESSION = array();
    }
    header("location: index.php");
?>