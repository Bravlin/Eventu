/*global $*/

$(document).ready(function(){
    $('#provincia').on('change',function(){
        var codProvincia = $(this).val();
        if (codProvincia){
            $.ajax({
                type:'POST',
                url:'/ajaxData.php',
                data:'codProvincia='+codProvincia,
                success:function(html){
                    $('#ciudad').html(html); 
                }
            }); 
        }
        else
            $('#ciudad').html('<option value="">Primero elija una provincia</option>');
    });
    
    $('#contrasena, #contrasenaVerificacion').on('change', function(){
        var contrasena = $('#contrasena').val();
        var contrasenaCheck = $('#contrasenaVerificacion').val();
        if (contrasena == contrasenaCheck){
           $('#contrasenaVerificacion').toggleClass('erroneo', false);
           $('#contrasenaVerificacion').toggleClass('valido', true);
        }
        else {
           $('#contrasenaVerificacion').toggleClass('valido', false);
           $('#contrasenaVerificacion').toggleClass('erroneo', true);
        }
    });
});