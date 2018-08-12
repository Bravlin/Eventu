/*global $*/

$(document).ready(function(){
    $('#aceptar').on('click', function(){
        var idEvento = $('#idEvento').attr('valor');
        $.ajax({
            type: 'POST',
            url: '/gestion/php-scripts/estado-evento.php',
            data: {
                idEvento: idEvento,
                accion: 'aprobado'
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
    
    $('#rechazar').on('click', function(){
        var idEvento = $('#idEvento').attr('valor');
        $.ajax({
            type: 'POST',
            url: '/gestion/php-scripts/estado-evento.php',
            data: {
                idEvento: idEvento,
                accion: 'rechazado'
            },
            success:function(html){
                $('#estado').html('Rechazado');
                $('#aceptar').prop('hidden', false);
                $('#rechazar').prop('hidden', true);
                $('#modificar').prop('hidden', true);
                $('#eliminar').prop('hidden', false);
            }
        });  
    });
});