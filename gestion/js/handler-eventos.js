/*global $*/

$(document).ready(function(){
    $('#aceptar').on('click', function(){
        var idEvento = $('#idEvento').attr('valor');
        $.ajax({
            type: 'POST',
            url: '/gestion/php-scripts/estado-evento.php',
            data: {
                idEvento: idEvento,
                accion: 'aceptar'
            },
            success:function(html){
                $('#estado').html('Aprobado');
                $('#aceptar').prop('hidden', true);
                $('#rechazar').prop('hidden', true);
                $('#modificar').prop('hidden', false);
                $('#eliminar').prop('hidden', false);
            }
        });  
    });
});