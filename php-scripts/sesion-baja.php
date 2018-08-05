<?php
    session_start();
    if ($_SESSION['idUsuario'] != ""){
        session_destroy();
        session_write_close();
        $_SESSION = array();
    }
    header("location: /index.php");
?>