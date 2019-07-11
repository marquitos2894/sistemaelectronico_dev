<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador(); 
    
      if($_SESSION["almacen"]==0 ){
        
        echo "<script> window.location.href = '../almacen/'; </script>";
      }

?>

<div class="container-fluid">
  <?php  include "vistas/modulos/nav-almacen.php";?> 
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
                <a class="nav-link " href="#" aria-disabled="true">Reportes</a>
            </li>
        <li class="nav-item">
            <a class="nav-link " href="#" aria-disabled="true">Import</a>
        </li>
    </ul><br>

  
   

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
                      <th>Ubicacion</th>
                      <th>Stock</th>
                      <th>U.M</th>
                      <th>Equipo</th>
                      <th>Referencia</th>
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
                      <th>Ubicacion</th>
                      <th>Stock</th>
                      <th>U.M</th>
                      <th>Equipo</th>
                      <th>Referencia</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php echo $almCont->databale_componentes($_SESSION["almacen"],"simple"); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>  
</div>


                  


<!--script src="../vistas/js/cargarproductos.js"></script-->