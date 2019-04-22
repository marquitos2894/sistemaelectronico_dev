<?php 
    require_once "./controladores/adminControlador.php";
    $insAdmin = new adminControlador();
    $pagina= explode("/",$_GET['views']);

    $buscador = "";
    $text = "";   
    if(isset($_POST['buscador']) && $_POST['buscador'] != ""){
        $buscador=$_POST['buscador'];
        $text = '<h3><small class="text-muted">su busqueda fue :</small>"'.$buscador.'"</h3>';
    }else{
        $text="";
      }

    
?>
<div class="container-fluid" >

    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active"  href="<?php echo SERVERURL;?>usuariolist/">Lista de Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SERVERURL;?>usuario/">Nuevo Usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <form action="" method="POST">
                            <button class="btn btn-primary" type="submit" id="button-addon1">Buscar</button>
                        </div>
                            <input type="text" class="form-control" name="buscador" value=""  placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                    </form>
                <?php echo $text; ?>
                
            <?php 
                    echo  $insAdmin->paginador_usuarios($pagina[1],2, $_SESSION['privilegio_sbp'],$_SESSION['id_sbp'],$buscador,$pagina[0]);
 
            ?>
        </div>
    </div>



</div>