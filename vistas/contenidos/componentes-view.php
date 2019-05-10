<?php 
    require_once './controladores/componentesControlador.php';

    $compCont = new componentesControlador();

    $pagina = explode("/",$_GET['views']);
    $buscador = "";
    $text = "";   
    if(isset($_POST['buscador']) && $_POST['buscador'] != "" ){
        $buscador=$_POST['buscador'];
        $text = '<h3><small class="text-muted">su busqueda fue :</small>"'.$buscador.'"</h3>';
    }else{
      $text="";
    }

?>

<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="">Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeSalida/">Vale de salida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeIngreso/">Vale de ingreso</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">+Nuevo componente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#" aria-disabled="true">Import</a>
        </li>
    </ul><br>
    <form action="" method="POST">
        <div class="input-group mb-3">                        
            <div class="input-group-prepend">                            
                <button class="btn btn-primary" type="submit" id="button-addon1">Buscar</button>
            </div>
            <input type="text" name="buscador" class="form-control" placeholder="Buscar componentes"  aria-describedby="button-addon1">
        </div>
    </form>
   
    <?php echo $text; ?>  
    <?php  echo $compCont->paginador_componentes($pagina[1],15,"",$buscador,$pagina[0]);?> 
</div>