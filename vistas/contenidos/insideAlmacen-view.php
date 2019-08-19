<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador(); 
    
      if($_SESSION["almacen"]==0 ){
        
        echo "<script> window.location.href = '../almacen/'; </script>";
      }

?>
   <input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" /> 
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
          <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SERVERURL;?>reporteAlmacen" aria-disabled="true">Reportes</a>
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
                      <th>Control Stock</th>
                      <th>U.M</th>
                      <th>Equipo</th>
                      <th>Referencia</th>
                      <th>Config</th>
                      <th>Delete</th>
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
                      <th>Control Stock</th>
                      <th>U.M</th>
                      <th>Equipo</th>
                      <th>Referencia</th>
                      <th>Config</th>
                      <th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody id="dtbody">
                      <?php echo $almCont->databale_componentes($_SESSION["almacen"],"simple"); ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <input type="hidden" id="id_alm_session" value="<?php echo $_SESSION["almacen"] ?>" />
          <div class="modal fade" id="config_comp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Configuracion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form name="almacen"  action="<?php echo SERVERURL;?>ajax/almacenAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                  <div class="modal-body" id="modal-body">
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <input type="submit"  class="btn btn-primary " value="Actualizar"/>     
                  </div>
                  <div class="RespuestaAjax"></div>
                </form>
              </div>
            </div>
          </div>

          
</div>


                  


<script src="../vistas/js/insideAlmacen.js"></script>