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

    </ul><br>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalNP">
    <i class="fas fa-plus-circle"></i>
        Nuevo producto
    </button>
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
        <div class="jumbotron jumbotron-fluid" id="box_select">
            <div class="container">
            <h1 class="display-6">Tipo de registro</h1>
                <div class="row">
                    <div id='box_valeI' class="col-sm-6">
                        <div class="card" id='box_valeI_S'>
                            <div class="card-body" id='box_valeI'>
                                <h5 id='box_valeI' class="card-title">Enviar datos a vale ingreso</h5>
                                <p id='box_valeI' class="card-text">Los datos del carrito se registraran 
                                y la vez se enviaran al modulo vale de ingreso para generar su ticket.
                                <br>
                                <strong>(*)Obligatorio tener registro de guia remision</strong>
                                </p>
                                <a href="#box_valeI" id='box_valeI' class="btn btn-secondary"><i class="far fa-paper-plane"></i> Enviar</a>
                            </div>
                        </div>
                    </div>
                    <div id='box_stockI' class="col-sm-6">
                        <div class="card" id='box_stockI_S'>
                            <div class="card-body" id='box_stockI'>
                                <h5 id='box_stockI' class="card-title">Registrar como stock inicial</h5>
                                <p id='box_stockI' class="card-text">Lo datos del carrito se registraran como stock inicial</p>
                                <a href="#box_stockI" id='box_stockI' class="btn btn-secondary"><i class="far fa-check-circle"></i> Registrar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="t_reg" id="t_reg">
        <input type="hidden"  name="id_alm_frmIA" value="<?php echo $_SESSION["almacen"] ?>"/>
        <input type="hidden"  name="privilegio_ingresoalmacen" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
        <input type="submit" id="submit" class="btn btn-secondary btn-lg btn-block" value="" disabled='true'/>
        <input type="hidden"  name="privilegio_sbp_ia" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
        <input type="hidden" id='id_usuario' name="d_fk_usuario" value="<?php echo $_SESSION['id_sbp']?>"/>    
        <div class="RespuestaAjax"></div>
        <div id="alert"></div>
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
        <div id="alert_modal"></div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btnAgregar" class="btn btn-primary" >Agregar</button>
        </div>
    </div>
  </div>
</div>

<!-- Modal nuevo producto -->

<div class="modal fade" id="ModalNP" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="<?php echo SERVERURL;?>ajax/componentesAjax.php" method="POST" data-form="save" class="FormularioAjax" id="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
            <div class="card mb-3">
                <div class="card-body text-primary">
                    
                    <div class="progress" style="height:1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-12 text-primary">
                            <label for="inputAddress">Descripcion</label>
                            <input type="text" name="descripcion" class="form-control " id="inputAddress" placeholder="Nombre del componente" maxlength="50" required>
                        </div>
                    </div>
                    <div class="progress" style="height:1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="inputEmail4">Nparte</label>
                            <input type="text" name="nparte1" class="form-control"  placeholder="Nparte" maxlength="14">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputPassword4">Nparte 2</label>
                            <input type="text" name="nparte2" class="form-control"  placeholder="Nparte 2" maxlength="14">
                        </div>
                        <div  style="display:none" class="form-group col-sm-4">
                            <label for="inputPassword4">Nparte 3</label>
                            <input type="hidden" name="nparte3" class="form-control"  placeholder="Nparte 3">
                        </div>
                    </div>
                    <div class="progress" style="height:1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-8">
                            <label for="inputEmail4">N° Serie</label>
                            <input type="text" name="nserie" class="form-control"  placeholder="N° de serie" maxlength="25">
                        </div>
                    </div>

                    <div class="progress" style="height:1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="inputEmail4">Marca</label>
                            <input type="text" name="marca" class="form-control"  placeholder="Marca" maxlength="18">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inputEmail4">Unidad de medida</label>
                            <select name="unidad_med_new" class="form-control" placeholder="Seleccione unidad" required>
                                <option value="">Seleccione unidad de medida</option>
                                <?php echo $compCont->select_combo("SELECT * FROM unidad_medida WHERE est = 1",0,1); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="inputEmail4">Categoria</label>
                            <select name="categoria_newcomp" class="form-control" id="cbocategoria" required>
                                <option value="">Seleccione categoria</option>
                                <?php echo $compCont->select_combo("SELECT * FROM categoriacomp WHERE est = 1",0,1); ?>
                            </select>
                        </div>
                        <div id="medida_simple" class="form-group col-sm-6">                      
                        </div>
                        <div style="display:none" id="medida_neumatico" class="form-group col-sm-4">
                            <label for="inputEmail4">Medida</label>
                            <select name="medida_neumatico_newcomp" id="cbomedida_neumatico" class="form-control">
                                <option value="">Seleccione medida</option>
                                <?php echo $compCont->select_combo("SELECT * FROM medida_neumaticos",1,1); ?>
                            </select>
                        </div>    
                    </div>
                </div>
            </div>
            <input type="hidden"  name="privilegio_sbp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
              
            
            <div class="RespuestaAjax"></div>
        
        <script src="../vistas/js/newcomponentes.js"></script>       
    
        <div class="modal-footer">
        <div id="alert_modal"></div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnguardarcomp" class="btn btn-primary" >Guardar</button>
        </div>
        </form>
    </div>
  </div>
</div>



<script src="../vistas/js/comp_general.js"></script>

