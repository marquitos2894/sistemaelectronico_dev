
<?php 
require_once './controladores/componentesControlador.php';
$compCont = new componentesControlador();
$url = explode("/",$_GET["views"]);
$paginador = $url[1];
$vista=$url[0];

$reload = "<script>window.location.replace('".SERVERURL."{$vista}/');</script>";


if(isset($_POST['buscador_comp'])){
  echo $compCont->validar_paginador_controlador($_POST['buscador_comp'],$vista,"");
}
if(isset($_POST["eliminar_busqueda"])){
  echo $compCont->validar_paginador_controlador("",$vista,$_POST["eliminar_busqueda"]);
}


?>


    
<div class="container-fluid"> 
    <!--div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s6">
            <input id="myInput" type="text">
            <label for="myInputt">Buscar</label>
          </div>
        </div>
      </form>
    </div-->
  
        <!--table class="table table-striped" >
            <thead>
                <tr>
                    <th scope="col">Cod interno</th>
                    <th scope="col">descripcion</th>
                    <th scope="col">nparte</th>
                    <th scope="col">nparte2</th>
                    <th scope="col">nparte3</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="myTableComp" >

            </tbody>
        </table-->
    <!--div id="DT">
      <table id="DTComponentes" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Nparte</th>
                <th>Nparte 2</th>
                <th>Nparte 3</th>
                <th>Marca</th>
                <th>U.M</th>
                <th>Control Stock</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Nparte</th>
                <th>Nparte 2</th>
                <th>Nparte 3</th>
                <th>Marca</th>
                <th>U.M</th>
                <th>Control Stock</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
      </table>
        
    </div-->
  <form action="" method="POST">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button class="btn btn-primary" type="submit"  id="buscador_comp">Buscar</button>
      </div>
      <input type="text" name="buscador_comp" class="form-control" placeholder="Buscar Componente" aria-label="Buscar componente" aria-describedby="button-addon1">
    </div>
  </form>


  <?php   if(!isset($_SESSION['session_'.$vista]) && empty($_SESSION['session_'.$vista])): ?>

    <?php  echo $compCont->paginador_componentes($paginador,10,$_SESSION['privilegio_sbp'],"",$vista);  ?>

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
    <?php  echo $compCont->paginador_componentes($paginador,10,$_SESSION['privilegio_sbp'],$_SESSION['session_'.$vista],$vista);  ?>
    
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
          <form  action="<?php echo SERVERURL;?>ajax/componentesAjax.php" id="formEdit"  method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
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

<script src="../vistas/js/componentes.js"></script>


