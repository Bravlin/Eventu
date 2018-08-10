<?php
    session_start();
    if ($requiere_sesion){
        if ($_SESSION['idUsuario'] == ""){
            header("location: /index.php");
            die();
        }
        elseif ($solo_administrador){
            if ($_SESSION['tipo'] != 'A'){
                header("location: /home.php");
                die();
            }
        }
        elseif ($_SESSION['tipo'] == 'A'){
            header("location: /gestion/home.php");
            die();
        }
    }
    elseif ($_SESSION['idUsuario'] != ""){
        if ($_SESSION['tipo'] == 'A'){
            header("location: /gestion/home.php");
            die();
        }
        else {
            header("location: /home.php");
            die();
        }
       
    }
?>