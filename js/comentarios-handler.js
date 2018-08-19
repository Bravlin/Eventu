/*global $*/
        
$(document).ready(function(){
    $('#ingresar-comentario').on('keyup blur', function(){
        if ($('#ingresar-comentario').val() != "")
            $('#enviar-comentario').prop("disabled", false);
        else
            $('#enviar-comentario').prop("disabled", true);
    });
    
    $('#enviar-comentario').on('click', function(){
        var contenido = $('#ingresar-comentario').val();
        var idEvento = $('#idEvento').attr('valor');
        $.ajax({
            type: 'POST',
            url: '/php-scripts/agregar-comentario.php',
            data: {
                idEvento: idEvento,
                contenido: contenido
            },
            success:function(html){
                $('#ingresar-comentario').val("");
                $('#enviar-comentario').prop("disabled", true);
                $('#comentarios').prepend(html);
            }
        }); 
    });
});