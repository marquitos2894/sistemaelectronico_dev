<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    
});

$(document).ready(function(){
 $('#btnlogout').on('click',function(e){
        e.preventDefault();
        var Token=$(this).attr('href');
            Swal.fire({
        title: '¿Estas seguro?',
        text: "La sesion actual se cerrara y deberas iniciar sesion nuevamente.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cerrar sesion!'
        }).then((result) => {
        if (result.value) {
            $.ajax({
                url:'<?php echo SERVERURL; ?>ajax/loginAjax.php?Token='+Token,
                success:function(data){
                   
                    if(data=="true"){
                        localStorage.clear();
                        window.location.href="<?php echo SERVERURL; ?>login"; 
                    }else{
                        Swal.fire(
                            "Ocurrio un errror",
                            "No se pudo cerrar la sesion",
                            "error" 
                        );
                    }
                }
            })
        }
        })
 });
});
</script>