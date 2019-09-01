<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador(); 

      $url = explode("/",$_GET["views"]);
      $paginador = $url[1];
      $vista=$url[0];

      $id_alm = $_SESSION["almacen"];
      if($_SESSION["almacen"]==0 ){
        echo "<script> window.location.href = '../almacen/'; </script>";
      }

?>
  <input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />
  <input type="hidden" value="<?php echo $paginador ?>" id="paginador"/>
  <input type="hidden" value="<?php echo $vista ?>" id="vista"/>
  <input type="hidden" value="<?php echo $_SESSION['privilegio_sbp'] ?>" id="privilegio"/>
  <input type="hidden" value="<?php echo $_SESSION['almacen'] ?>" id="id_alm"/>

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
          <a class="nav-link " href="<?php echo SERVERURL;?>reporteAlmacen/" aria-disabled="true">Reportes</a>
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
              <!--div class="table-responsive">
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
                      <?php //if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                      <th>Config</th>
                      <th>Delete</th>
                      <?php //endif; ?>
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
                      <?php //if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                      <th>Config</th>
                      <th>Delete</th>
                      <?php //endif; ?>
                    </tr>
                  </tfoot>
                  <tbody id="dtbody">
                      <?php //echo $almCont->databale_componentes($_SESSION["almacen"],"simple",$_SESSION['privilegio_sbp']); ?>
                  </tbody>
                </table>
              </div-->
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Buscar</span>
                  </div>
                  <input type="search" class="form-control"  id="buscador_comp_text" placeholder="Buscar componente" aria-label="Username" aria-describedby="basic-addon1">                       
              </div>
              <div id='catalogo'></div>      
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