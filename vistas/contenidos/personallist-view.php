
<?php 
        require_once "./controladores/personalControlador.php";
        $perCont = new personalControlador();

        $url = explode("/",$_GET["views"]);
        $paginador = $url[1];
        $vista=$url[0];

        $reload = "<script>window.location.replace('".SERVERURL."{$vista}/');</script>";


        if(isset($_POST['buscador_comp'])){
        echo $perCont->validar_paginador_controlador($_POST['buscador_comp'],$vista,"");
        }
        if(isset($_POST["eliminar_busqueda"])){
        echo $perCont->validar_paginador_controlador("",$vista,$_POST["eliminar_busqueda"]);
        }
?>

<div class="container-fluid"> 
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link active"  href="<?php echo SERVERURL;?>personallist/">Personal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>personal/">+Nuevo Personal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
    </ul><br>     
 

  <form action="" method="POST">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button class="btn btn-primary" type="submit"  id="buscador_comp">Buscar</button>
      </div>
      <input type="text" name="buscador_comp" class="form-control" placeholder="Buscar personal" aria-label="Buscar componente" aria-describedby="button-addon1">
    </div>
  </form>


  <?php   if(!isset($_SESSION['session_'.$vista]) && empty($_SESSION['session_'.$vista])): ?>

    <?php  echo $perCont->paginador_personal($paginador,10,$_SESSION['privilegio_sbp'],"",$vista,$_SESSION['unidad']);  ?>

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
    <?php  echo $perCont->paginador_personal($paginador,10,$_SESSION['privilegio_sbp'],$_SESSION['session_'.$vista],$vista,$_SESSION['unidad']);  ?>
    
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
          <form  action="<?php echo SERVERURL;?>ajax/personalAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-body" id="modal-body">

            </div>
            <div class="modal-footer">
              <input type="hidden"  name="privilegio_sbp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <input type="submit"  class="btn btn-primary " value="Actualizar"/>
            </div>
            <div class="RespuestaAjax"></div>
          </form> 
         
        </div>
      </div>
    
    </div>
    

    
</div>

<script src="../vistas/js/personal.js"></script>