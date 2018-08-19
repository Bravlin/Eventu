<div class="row mb-3 border comentario">
    <div class="col-3 col-sm-2 px-3">
        <img class="imagen-perfil rounded-circle mx-auto my-1" alt="perfil"
            src=<?php
                $avatar = "/media/perfiles-usuarios/" . $comentario['idUsuario'] . "-perfil";
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$avatar))
                    echo $avatar;
                else
                    echo "/media/perfiles-usuarios/0-perfil";
            ?>>
    </div>
    <div class="col-9 col-sm-10 px-3">
        <div class="row justify-content-between">
            <div class="col-12 col-sm-6">
                <a class="usuario" href="perfil.php?idUsuario=<?php echo $comentario['idUsuario']; ?>">
                    <?php echo $comentario['nombresCread'] . ' ' . $comentario['apellidosCread'];?>
                </a>
            </div>
            <div class="col-12 col-sm-6 text-sm-right"><?php echo date("h:i d/m/Y", strtotime($comentario['fechaCreac'])); ?></div>
        </div>
        <p class="my-3"><?php echo $comentario['contenido']; ?></p>
    </div>
</div>