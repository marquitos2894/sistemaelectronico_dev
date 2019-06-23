<?php 
    require_once './controladores/componentesControlador.php';

    $compCont = new componentesControlador();

    $pagina = explode("/",$_GET['views']);
    $buscador = "";
    $text = "";   
    if(isset($_GET['buscador']) && $_GET['buscador'] != "" ){
        $buscador=$_GET['buscador'];
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
            <a class="nav-link" href="<?php echo SERVERURL;?>newcomponente/">+Nuevo componente</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#" aria-disabled="true">Import</a>
        </li>
    </ul><br>
    <!--form action="" method="POST">
        <div class="input-group mb-3">                        
            <div class="input-group-prepend">                            
                <button class="btn btn-primary" type="submit" id="button-addon1">Buscar</button>
            </div>
            <input type="text" name="buscador" class="form-control" placeholder="Buscar componentes"  aria-describedby="button-addon1">
        </div>
    </form-->
   
    <?php //echo $text; ?>  
    <?php  //echo $compCont->paginador_componentes($pagina[1],15,"",$buscador,$pagina[0]);?> 

   

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Componentes</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Cod.Interno</th>
                      <th>Descripcion</th>
                      <th>Nparte1</th>
                      <th>Nparte2</th>
                      <th>Nparte3</th>
                      <th>Stock</th>
                      <th>U.M</th>
                      <th>Ubicacion</th>
                      <th>Equipo</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Cod.Interno</th>
                      <th>Descripcion</th>
                      <th>Nparte1</th>
                      <th>Nparte2</th>
                      <th>Nparte3</th>
                      <th>Stock</th>
                      <th>U.M</th>
                      <th>Ubicacion</th>
                      <th>Mod Equipo</th>
                    </tr>
                  </tfoot>
                  <tbody id="bdcomponentes" >
                    

                  </tbody>
                </table>
              </div>
            </div>
          </div>  
</div>


                  


<script src="../vistas/js/cargarproductos.js"></script>