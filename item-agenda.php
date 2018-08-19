<div class="col-12 mb-5 px-0">
    <div class="row item-agenda mx-auto border border-secondary">
        <div class="col-12 info">
            <div>
                <i class="fa fa-calendar"></i>
                <?php
                    $fechaHora = strtotime($evento['fechaRealiz']);
                    echo date('d/m/Y', $fechaHora);
                ?>
                <i class="fa fa-clock-o pl-3"></i>
                <?php echo date('H:i', $fechaHora); ?>
            </div>
            <div>
                <i class="fa fa-map-marker eventu-pink-text"></i>
                <?php echo $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia']; ?>
            </div>
        </div>
        <div class="col-12 contenedor-portada px-0">
            <?php
                $enlaceEvento = "evento.php?idEvento=" . $evento['idEvento'];
            ?>
            <a href="<?php echo $enlaceEvento; ?>">
                <img class="portada" alt="Portada"
                    src=<?php
                        $portada = "media/portadas-eventos/" . $evento['idEvento'] . "-p";
                        if (file_exists($portada))
                            echo $portada;
                        else
                            echo "media/portadas-eventos/0-p";
                    ?>>
            </a>
            <div class="contenedor-nombre px-4 text-center">
                <a class="enlace-evento" href="<?php echo $enlaceEvento; ?>">
                    <h2 class="my-2"><?php echo $evento['nombreEvento']; ?></h2>
                </a>
            </div>
        </div>
    </div>
</div>