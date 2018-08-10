<?php
    $enlaceEvento = "evento.php?idEvento=" . $evento['idEvento'];
?>

<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5 d-flex align-items-stretch">
    <div class="card item-consulta">
        <div class="contenedor-portada">
            <a href="<?php echo $enlaceEvento; ?>">
                <img class="card-img-top" alt="Card image cap"
                    src=<?php
                        $portada = "/media/portadas-eventos/" . $evento['idEvento'] . "-p";
                        if (file_exists($portada))
                            echo $portada;
                        else
                            echo "/media/portadas-eventos/0-p";
                    ?>
                >
            </a>
            <div class="contenedor-nombre px-4">
                <a class="enlace-evento" href="<?php echo $enlaceEvento; ?>">
                    <h5 class="card-title"><?php echo $evento['nombreEvento']; ?></h5>
                </a>
            </div>
        </div>
        <div class="card-body">
            <ul class="contenedor-info pl-0">
                <li class="mb-2">
                    <i class="fa fa-map-marker eventu-pink-text"></i>
                    <?php echo $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad'].', '.$evento['nombreProvincia']; ?>
                </li>
                <li>
                    <i class="fa fa-calendar"></i>
                    <?php
                        $fechaHora = strtotime($evento['fechaRealiz']);
                        echo date('d/m/Y', $fechaHora);
                    ?>
                    <i class="fa fa-clock-o pl-3"></i>
                    <?php echo date('H:i', $fechaHora); ?>
                </li>
            </ul>
        </div>
    </div>
</div>