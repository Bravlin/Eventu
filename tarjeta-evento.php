<div class="card tarjeta-evento">
    <div class="card-header"><h5 class="eventu-pink-text"><?php echo $evento['nombreCateg']; ?></h3></div>
    <img class="card-img-top" alt="Card image cap"
        src=<?php
            $portada = "media/portadas-eventos/" . $evento['idEvento'] . "-p";
            if (file_exists($portada))
                echo $portada;
            else
                echo "media/portadas-eventos/0-p";
        ?>
    >
    <div class="card-body eventu-red">
        <a class="enlace-evento" href="evento.php?idEvento=<?php echo $evento['idEvento']; ?>">
            <h3 class="card-title"><?php echo $evento['nombreEvento']; ?></h3>
        </a>
        <p class="card-text"><?php echo $evento['descripcion']; ?></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <i class="fa fa-map-marker eventu-pink-text"></i>
            <?php echo $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia']; ?>
        </li>
        <li class="list-group-item">
            <i class="fa fa-clock-o eventu-pink-text"></i>
            <?php echo date('d/m/Y H:i', strtotime($evento['fechaRealiz'])); ?>
        </li>
        <li class="list-group-item">
            <i class="fa fa-user-circle eventu-pink-text"></i>
            <?php echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?>
        </li>
        <li class="list-group-item">
            <i class="fa fa-hashtag eventu-pink-text"></i>
            <b>
                <?php
                    $idEvento = $evento['idEvento'];
                    $etiquetas_query = mysqli_query($db,
                        "SELECT et.nombre
                        FROM etiquetas et
                        INNER JOIN etiquetas_eventos et_ev ON et.idEtiqueta = et_ev.idEtiqueta
                        WHERE et_ev.idEvento = '$idEvento'
                        ORDER BY et.nombre ASC;");
                    while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                        echo $etiqueta['nombre'].' ';
                ?>
            </b>
        </li>
    </ul>
</div>