<?php
    require('db.php');
    if (!empty($_REQUEST["codProvincia"])){
        //Recupera las ciudades según la provincia
        $ciudades_query = mysqli_query($db, "SELECT * FROM ciudades WHERE codProvincia = ".$_REQUEST['codProvincia']." ORDER BY nombre ASC");
        while ($ciudad = mysqli_fetch_array($ciudades_query))
            echo '<option value="'.$ciudad['codCiudad'].'">'.$ciudad['nombre'].'</option>';
    }
    else {
        echo '<option value="">Primero elija una provincia</option>';
    }
?>