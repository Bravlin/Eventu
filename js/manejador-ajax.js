/*global $*/

$(document).ready(function(){
    $('#provincia').on('change',function(){
        var codProvincia = $(this).val();
        if (codProvincia){
            $.ajax({
                type: 'POST',
                url: '/php-scripts/recupera-ciudades.php',
                data: {
                    codProvincia: codProvincia
                },
                success:function(html){
                    $('#ciudad').html(html); 
                }
            }); 
        }
        else
            $('#ciudad').html('<option value="">Primero elija una provincia</option>');
    });
});