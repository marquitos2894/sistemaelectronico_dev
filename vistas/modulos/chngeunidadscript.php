<script>

document.querySelector('#dropdown_cuenta').addEventListener("click", async function(ev){

    if(ev.target.dataset.cuenta){
        console.log(ev.target.dataset.cuenta);
        //id_unidad
        $id_cuenta = ev.target.dataset.cuenta;
        datos = new FormData();
        datos.append("chngecuenta",$id_cuenta);

        <?php
        if(isset($_GET['views'])){         
            ?>
            <?php if($_GET['views']=="inicio"){?>
                let response = await fetch('ajax/unidadAjax.php',{
                method : "POST",
                body : datos
                });
            <?php }else{?>
                let response = await fetch('../ajax/unidadAjax.php',{
                method : "POST",
                body : datos
                });
                <?php } ?>
        <?php 
        }else{?>

        let response = await fetch('ajax/unidadAjax.php',{
        method : "POST",
        body : datos
        });
        <?php 
        } ?>
        
    //localStorage.clear();

    location.reload();
    }

});


</script>