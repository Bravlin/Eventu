<div class="card">
    <div class="card-header"><h5 class="eventu-pink-text"><?php echo $evento['nombreCateg']; ?></h3></div>
    <img class="card-img-top" src="/src/imagenes/tedx-sydney-events-in-sydney-andy-dexterity-472x233.jpg" alt="Card image cap">
    <div class="card-body eventu-red">
        <h3 class="card-title"><?php echo $evento['nombreEvento']; ?></h5>
        <p class="card-text"><?php echo $evento['descripcion']; ?></p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <i class="fa fa-map-marker eventu-pink-text"></i>
            <?php echo $evento['calle'].' '.$evento['altura'].', '.$evento['nombreCiudad']; ?>
        </li>
        <li class="list-group-item">
            <i class="fa fa-clock-o eventu-pink-text"></i>
            <?php echo $evento['fechaRealiz']; ?>
        </li>
        <li class="list-group-item">
            <i class="fa fa-user-circle eventu-pink-text"></i>
            <?php echo $evento['nombresCread'].' '.$evento['apellidosCread']; ?>
        </li>
    </ul>
</div>