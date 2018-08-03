<div class="card item-consulta mb-3">
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