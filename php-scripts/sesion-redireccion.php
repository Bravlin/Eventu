<?php
    session_start();
    if ($requiere_sesion){
        if ($_SESSION['idUsuario'] == ""){
            header("location: /index.php");
            die();
        }
    }
    elseif ($_SESSION['idUsuario'] != ""){
        header("location: /home.php");
        die();
    }
?>