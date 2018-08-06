<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5">
    <div class="card item-consulta">
        <img class="card-img-top" alt="Card image cap"
            src=<?php
                $portada = "media/portadas-eventos/" . $evento['idEvento'] . "-p";
                if (file_exists($portada))
                    echo $portada;
                else
                    echo "media/portadas-eventos/0-p";
            ?>
        >
        <div class="card-body">
            <a class="enlace-evento" href="evento.php?idEvento=<?php echo $evento['idEvento']; ?>">
                <h5 class="card-title"><?php echo $evento['nombreEvento']; ?></h5>
            </a>
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
        </ul>
    </div>
</div>