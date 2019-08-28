
<?php 
require_once './controladores/unidadmedidaControlador.php';
$unidadmedCont = new unidadmedidaControlador(); 
$url = explode("/",$_GET["views"]);
$paginador = $url[1];
$vista=$url[0];

//$reload = "<script>window.location.replace('".SERVERURL."{$vista}/');</script>";


if(isset($_POST['buscador_'.$vista])){
  echo $unidadmedCont->validar_paginador_controlador($_POST['buscador_'.$vista],$vista,"");
}
if(isset($_POST["eliminar_busqueda_".$vista])){
  echo $unidadmedCont->validar_paginador_controlador("",$vista,$_POST["eliminar_busqueda_".$vista]);
}


?>

<div class="container-fluid">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href=""><i class="fas fa-dolly-flatbed"></i>Unidades medida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>newunidadmed/"><i class="fas fa-plus-circle"></i> Nuevo</a>
        </li>
    </ul><br>

    <form action="" method="POST">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="submit"  id="buscador_comp">Buscar</button>
            </div>
            <input type="text" name="buscador_<?php echo $vista ?>" class="form-control" placeholder="Buscar unidad medida" aria-label="Buscar unidad medida" aria-describedby="button-addon1">
        </div>
    </form>
    <?php   if(!isset($_SESSION['session_'.$vista]) && empty($_SESSION['session_'.$vista])): ?>

    <?php  echo $unidadmedCont->paginador_unidadmedida($paginador,10,$_SESSION['privilegio_sbp'],"",$vista);  ?>

    <?php else: ?>
    <h3><small class='text-muted'>Su ultima busqueda fue : </small>"<?php echo $_SESSION['session_'.$vista]?>"</h3>
    <form action="" method="POST">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
        <button class="btn btn-danger" type="submit">Eliminar busqueda</button>
    </div>
    <input type="hidden" name="eliminar_busqueda_<?php echo $vista ?>" >
    </div>
    </form>

    <?php  echo $unidadmedCont->paginador_unidadmedida($paginador,10,$_SESSION['privilegio_sbp'],$_SESSION['session_'.$vista],$vista);  ?>

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
          <form  action="<?php echo SERVERURL;?>ajax/unidadmedidaAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
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

<script src="../vistas/js/unidadmedlist.js"></script>