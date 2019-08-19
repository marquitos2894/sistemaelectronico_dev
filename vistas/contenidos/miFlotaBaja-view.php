
<?php 
require_once './controladores/equipoControlador.php';
$equipoCont = new equipoControlador();
$url = explode("/",$_GET["views"]);
$paginador = $url[1];
$vista=$url[0];

$reload = "<script>window.location.replace('".SERVERURL."{$vista}/');</script>";


if(isset($_POST['buscador_comp'])){
  echo $equipoCont->validar_paginador_controlador($_POST['buscador_comp'],$vista,"");
}
if(isset($_POST["eliminar_busqueda"])){
  echo $equipoCont->validar_paginador_controlador("",$vista,$_POST["eliminar_busqueda"]);
}


?>
    
<div class="container-fluid"> 
  <ul class="nav nav-tabs">
      <li class="nav-item">
          <a class="nav-link" href="<?php echo SERVERURL;?>miFlota/"><i class="fas fa-tractor"></i> Mi flota de Equipos</a>
      </li>
      <li class="nav-item">
          <a class="nav-link active" href="<?php echo SERVERURL;?>miFlotaBaja/"><i class="fas fa-tractor"></i> Mi flota dada de baja</a>
      </li>

  </ul><br>
 
  <form action="" method="POST">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button class="btn btn-primary" type="submit"  id="buscador_comp">Buscar</button>
      </div>
      <input type="text" name="buscador_comp" class="form-control" placeholder="Buscar equipo" aria-label="Buscar componente" aria-describedby="button-addon1">
    </div>
  </form>


  <?php   if(!isset($_SESSION['session_'.$vista]) && empty($_SESSION['session_'.$vista])): ?>

    <?php  echo $equipoCont->paginador_equipos_unidad($paginador,10,$_SESSION['privilegio_sbp'],"",$vista,$_SESSION['unidad']);  ?>

  <?php else: ?>
      <h3><small class='text-muted'>Su ultima busqueda fue : </small>"<?php echo $_SESSION['session_'.$vista]?>"</h3>
      <form action="" method="POST">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button class="btn btn-danger" type="submit">Eliminar busqueda</button>
      </div>
      <input type="hidden" name="eliminar_busqueda" >
    </div>
  </form>
    <?php  echo $equipoCont->paginador_equipos_unidad($paginador,10,$_SESSION['privilegio_sbp'],$_SESSION['session_'.$vista],$vista,$_SESSION['unidad']);  ?>
    
  <?php endif; ?>
    <!-- Modal -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Actualizar Datos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form  action="<?php echo SERVERURL;?>ajax/EquiposAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
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
    
    <div class="modal fade" id="ModalAddFlota" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Agregar flota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form  action="<?php echo SERVERURL;?>ajax/EquiposAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-body" id="modal-body-addFlota">

            </div>
            <input type="hidden" name="session_idunidad_agregarF" value="<?php echo $_SESSION['unidad'] ?>" /> 
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <input type="submit"  class="btn btn-primary " value="Guardar"/>
            </div>
            <div class="RespuestaAjax"></div>
          </form> 
         
        </div>
      </div>
    </div>
    
</div>

<script src="../vistas/js/miFlota.js"></script>


