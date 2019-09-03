<?php 
    require_once './controladores/componentesControlador.php';
    $compCont = new componentesControlador();

    $url = explode("/",$_GET["views"]);
    $paginador = $url[1];
    $vista=$url[0];

    
    if($_SESSION["almacen"]==0 ){
      echo "<script> window.location.href = '../almacen/'; </script>";
    }

?>
    <input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />
    <input type="hidden" value="<?php echo $paginador ?>" id="paginador"/>
    <input type="hidden" value="<?php echo $vista ?>" id="vista"/>
    <input type="hidden" value="<?php echo $_SESSION['privilegio_sbp'] ?>" id="privilegio"/>
    <input type="hidden" value="<?php echo $_SESSION['almacen'] ?>" id="id_alm"/>
    <input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />

<div class="container-fluid">

    <?php  include "vistas/modulos/nav-almacen.php";?> 
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link " href="<?php echo SERVERURL;?>insideAlmacen/">Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeSalida/">Vale salida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeIngreso/">Vale de ingreso</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="<?php echo SERVERURL;?>reporteAlmacen/" aria-disabled="true">Reportes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#" aria-disabled="true">Import</a>
        </li>
    </ul><br>

    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Componentes en general
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                Componentes registrados en todas las unidades de la empresa
                    <!--div class="table-responsive" id="componentesin">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Cod.Interno</th>
                                    <th>Nparte1</th>
                                    <th>Nparte2</th>
                                    <th>Nparte3</th>
                                    <th>Marca</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Cod.Interno</th>
                                    <th>Nparte1</th>
                                    <th>Nparte2</th>
                                    <th>Nparte3</th>
                                    <th>Marca</th>
                                    <th>Add</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php //echo $compCont->componentes_general(); ?>
                                
                            </tbody>
                        </table>
                    </div-->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                        </div>
                        <input type="search" class="form-control"  id="buscador_comp_text" placeholder="Buscar componente" aria-label="Username" aria-describedby="basic-addon1">                       
                    </div>
                    <div id='componentesin'></div> 
                </div>   
            </div>
        </div>
    </div>

    <form name="form_inalmacen" action="<?php echo SERVERURL;?>ajax/almacenAjax.php"  method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div id="productosCarrito">
            <!-- item de local storage para ingreso al almacen (Nuevo o ubicacion)-->
        </div>
        <h4><p style="text-align:center;" ><a  href="#" id="varciarCarrito">Vaciar carrito</a></p></h4>
        <input type="hidden"  name="id_alm_frmIA" value="<?php echo $_SESSION["almacen"] ?>"/>
        <input type="hidden"  name="privilegio_ingresoalmacen" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
        <input type="submit"  class="btn btn-primary btn-lg btn-block" value="Registrar"/>
        <div class="RespuestaAjax"></div>
    </form> 
  
</div>
<!-- Button trigger modal -->
<!-- <button type="button" id="btnModal" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Inserte ubicacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnAgregar" class="btn btn-primary" data-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>
<script src="../vistas/js/comp_general.js"></script>

