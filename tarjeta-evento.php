<div class="card tarjeta-evento">
    <div class="card-header">
        <a href="catalogo.php?modo=categoria&id=<?php echo $evento['idCategoria']; ?>">
            <h5 class="eventu-pink-text"><?php echo $evento['nombreCateg']; ?></h5>
        </a>
    </div>
    <div class="contenedor-portada">
        <img class="card-img-top" alt="Card image cap"
            src=<?php
                $portada = "media/portadas-eventos/" . $evento['idEvento'] . "-p";
                if (file_exists($portada))
                    echo $portada;
                else
                    echo "media/portadas-eventos/0-p";
            ?>
        >
        <div class="organizador px-2">
            <i class="fa fa-user-circle eventu-pink-text"></i>
            <?php echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?>
        </div>
    </div>
    <div class="card-body eventu-red">
        <a class="enlace-evento" href="evento.php?idEvento=<?php echo $evento['idEvento']; ?>">
            <h3 class="card-title"><?php echo $evento['nombreEvento']; ?></h3>
        </a>
        <ul class="info-evento">
            <li class="info-item">
                <i class="fa fa-map-marker"></i>
                <?php echo $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia']; ?>
            </li>
            <li class="info-item">
                <i class="fa fa-calendar"></i>
                <?php
                    $fechaHora = strtotime($evento['fechaRealiz']);
                    echo date('d/m/Y', $fechaHora);
                ?>
                <i class="fa fa-clock-o pl-3"></i>
                <?php echo date('H:i', $fechaHora); ?>
            </li>
            <li class="info-item">
                <i class="fa fa-hashtag"></i>
                <?php
                    $idEvento = $evento['idEvento'];
                    $etiquetas_query = mysqli_query($db,
                        "SELECT et.idEtiqueta, et.nombre
                        FROM etiquetas et
                        INNER JOIN etiquetas_eventos et_ev ON et.idEtiqueta = et_ev.idEtiqueta
                        WHERE et_ev.idEvento = '$idEvento'
                        ORDER BY et.nombre ASC;");
                    while ($etiqueta = mysqli_fetch_array($etiquetas_query))
                        echo '<a class="etiqueta mr-1" href="catalogo.php?modo=etiqueta&id='.$etiqueta['idEtiqueta'].'">' . $etiqueta['nombre'] . '</a>';
                ?>
            </li>
        </ul>
    </div>
</div>