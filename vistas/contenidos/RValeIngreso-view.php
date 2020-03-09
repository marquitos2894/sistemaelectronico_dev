
<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador(); 
      
      //$pagina = explode("/",$_GET['views']);

      $url = explode("/",$_GET["views"]);
      $paginador = $url[1];
      $vista=$url[0];

      $id_alm = $_SESSION["almacen"];
      if($_SESSION["almacen"]==0 ){
        echo "<script> window.location.href = '../almacen/'; </script>";
      }

      
?>
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
                <a class="nav-link active;alert alert-success" href="#">Vale de ingreso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
            </li>
    </ul><br>

    
            

            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="input-group mb-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Buscar</span>
                                    </div>
                                    <input type="search" class="form-control"  id="buscador_comp_text" placeholder="Buscar componente" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="col-md-4">
                                
       
                                    <div id="catalogo"></div>
                                    <div id="alert2"></div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
               
            </div>
            
            <form action="<?php echo SERVERURL;?>ajax/almacenAjax.php"  method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
                <div class="card">
                    <div class="card-header text-white bg-success">
                        Vale de ingreso
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Tipo Documento</label>                                                         
                                <select class="form-control" name="documento" id="documento" required>
                                    <option value="">Seleccione documento</option>
                                    <option value="Guia remision">Guia remision</option>
                                    <option value="Devolucion">Devolucion</option>
                                    <option value="Vale despacho">Vale despacho</option>
                                    <option value="Existencia en almacen">Existencia en almacen</option>
                                </select>    
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Ref. Documento</label>                              
                                <input type="text" name="ref_documento" class="form-control"  placeholder="Referencia documento" maxlength="18"/>
                            </div>
       
                            <div class="form-group col-md-2">
                                <label for="inputEmail4" >Fecha Llegada</label>                              
                                <input type="date" name="fecha_llegada" class="form-control" id="fec_llegada"/>
                            </div>
                        </div>
                        <div class="form-row" id="card_remitente" style="visibility:hidden">                                  
                            <div class="form-group col-8"> 
                                <label for="inputEmail4">Remitente</label><br>                              
                                <select data-placeholder="Seleccione personal" name="personal" id="personal" class="js-example-basic-single" >
                                    <option value=""></option>
                                    <?php  echo $almCont->select_combo("select p.id_per, concat(p.Nom_per,' ',p.Ape_per)
                                        from personal p where idunidad = {$_SESSION['unidad']} AND est = 1",0,1); ?>
                                </select>
                            </div>
                        </div>

                        <h5 class="card-title">Productos</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead  class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cod.Interno</th>
                                        <th scope="col">Descriocion</th>
                                        <th scope="col">Nparte</th>
                                        <th scope="col">NSerie</th>
                                        <th scope="col">Ubicacion</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Equipo</th>
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Ingreso</th>
                                        <th scope="col">Quitar</th>
                                        
                                    </tr>
                                </thead>
                                <tbody  id="productosCarrito">
                                
                                    <!-- item de local storage para salida del almacen-->
                                </tbody>
                            </table>
                        </div> 
                        <button type="button" class="btn btn-success" id='btnmodaladd' data-toggle="modal" data-target=".bd-example-modal-lg">+Agregar productos</button>  
                        <a  href="#" id="varciarCarrito" class="btn btn-warning"><i class="far fa-trash-alt"></i> Vaciar</a>
                        
                    </div>
                </div>
                <div id="alert3"></div>

                <div id="productosCarrito2">
                            <!-- item de local storage para salida del almacen-->
                </div>
      
                
      
                <div class="form-group">
                        <label for="exampleFormControlTextarea1">Comentario de salida de los repuestos</label>
                        <textarea  name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="80"></textarea>
                </div>
                <input type="hidden" id='id_usuario' name="usuario" value="<?php echo $_SESSION['id_sbp'];?>" />
                <input type="hidden" value="valeingreso" name="vale"/>
                <input type="hidden" name="privilegio_in" value="<?php echo $_SESSION['privilegio_sbp'] ?>" />
                <input type="hidden"  name="id_alm_vi" id="id_alm_vi" value="<?php echo $id_alm ?>"/>
                <div id="alert1"></div>
                <button type="submit" id="btnvale" class="btn btn-success btn-lg btn-block" disabled='true'>Emitir Vale de Ingreso</button>
        
                <div class="RespuestaAjax"></div>
            </form>
</div>
<script src="../vistas/js/carritoIn.js"></script>
