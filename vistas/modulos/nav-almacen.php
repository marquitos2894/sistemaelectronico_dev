    <nav class="navbar navbar-dark bg-primary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $_SESSION["nom_almacen"]; ?></a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <button type="button" id="logout_alm" class="btn btn-outline-light my-2 my-sm-0" >Salir</button>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        document.querySelector('#logout_alm').addEventListener("click", async function(ev){
        ev.preventDefault();
        datos = new FormData();
        datos.append("logout_alm",true);
        let response = await fetch('../ajax/almacenAjax.php',{
            method : "POST",
            body : datos
        })
        data = await response.text();
        console.log(data);
        console.log("click");
        localStorage.setItem('carritoIn','[]');
        localStorage.setItem('carritoS','[]');
        localStorage.setItem('carritoGen','[]');
        localStorage.setItem('BDproductos','[]');
        //window.location='almacen';
        location.reload();
    

    });
    </script>