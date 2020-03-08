
<?php 
    require_once "./controladores/almacenControlador.php";
    $almCont = new almacenControlador(); 
      
    $pagina = explode("/",$_GET['views']);
      
    $url = explode("/",$_GET["views"]);
    $paginador = $url[1];
    $vista=$url[0];

    $id_alm = $_SESSION["almacen"];

    if($_SESSION["almacen"]==0 ){
    echo "<script> window.location.href = '../almacen/'; </script>";
    }
      //var_dump($_SESSION["almacen"]);
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
            <a class="nav-link active;alert alert-danger" href="<?php echo SERVERURL;?>RValeSalida/">Vale salida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeIngreso/">Vale de ingreso</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>

    </ul><br>

    <form action="<?php echo SERVERURL;?>ajax/almacenAjax.php"  id="formVS" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
        <div class="card">
            <div class="card-header text-white bg-danger">
                Vale de salida
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label  class="form-check-label" for="inputEmail4">Solicitado por (*)</label><br>                             
                        <select name="personal" id="personal" style="width: 100%" class="js-example-basic-single">
                            <option value="0">Seleccione personal</option>
                            <?php 
                                echo $almCont->select_combo("select p.id_per, concat(p.Nom_per,' ',p.Ape_per)
                                from personal p where idunidad = {$_SESSION['unidad']} AND est = 1",0,1);
                            ?>
                        </select>        
                    </div>
                    <div class="form-group col-md-3">
                        <label  class="form-check-label" for="inputEmail4">Datos referencia</label><br>                              
                        <select name="datos_referencia_vale_salida" data-placeholder="#Sin especificar" style="width: 100%" class="js-example-basic-single">
                            <option value="#Sin especificar">#Sin especificar</option>
                            <?php echo $almCont->combo_DR(1,1)?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label  class="form-check-label" for="inputEmail4">Turno</label>                              
                        <select class="form-control" name="turno" id="turno">
                            <option value="0">Seleccione</option><option value="dia">Dia</option><option value="noche">Noche</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label  class="form-check-label" for="inputEmail4">Fecha Despacho</label>                              
                        <input type="date" name="fecha_despacho" class="form-control" id="fec_despacho">
                    </div>
                </div>

                <h5 class="card-title">Productos</h5>
                
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Nparte</th>
                            <th scope="col">N/S</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">Ubicacion</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Solitado</th>
                            <th scope="col">Cambio</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        
                        <tbody id="productos_carrito">
                            
                        </tbody>
                        
                    </table>
                </div>
                <button type="button" id="btnagregar" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-lg">+Agregar productos</button>
                <a  href="#" id="varciarCarrito" class="btn btn-warning"><i class="far fa-trash-alt"></i> Vaciar</a>
            </div>
        </div>

        <input type="hidden" name="usuario" id="id_usuario" value="<?php echo $_SESSION['id_sbp'];?>"/>
        <input type="hidden"  name="privilegio_sbp_vs" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
        <input type="hidden"  name="vale" value="valesalida"/>
        <input type="hidden"  name="id_alm_vs" id="id_alm_vs" value="<?php echo $id_alm ?>"/>
        <div id="alert1"></div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Comentario de salida de los repuestos</label>
            <textarea  name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="80"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-8">
             
            </div>
            <div class="form-group col-md-4">
                <button type="button" id="cancelar" class="btn btn-outline-secondary" >Cancelar</button>
                <button type="submit" id="btnvale" class="btn btn-danger" style="display:none" >Generar</button>
            </div>
        </div>
            
        <div id="RespuestaAjax" class="RespuestaAjax"></div>
    </form>

    
 

    <div class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modalProductos" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" > Agregar Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <form id="frm_modal">
                        <div class="form-row">
                            <div class="form-group col-md-9">
                                <label   for="inputEmail4">(*)Productos</label><br>
                                <select class="js-example-basic-single" id="Producto" style="width: 100%" name="state">
                                            <option value="0">Buscar producto</option>
                                            <?php 
                                                echo $almCont->select_combo("SELECT CONCAT(c.id_comp,' || ',c.descripcion,' || ',c.nparte1,' || ',
                                                ac.u_nombre,'-',ac.u_seccion,' || ',eu.alias_equipounidad,' || ',ac.Referencia,' || ',c.nserie) as item, ac.id_ac
                                                FROM componentes c
                                                INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
                                                INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
                                                INNER JOIN equipo_unidad eu ON eu.fk_idequipo = ac.fk_idflota
                                                INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria 
                                                WHERE ac.est = 1 and ac.fk_idalm = {$id_alm} ",1,0);
                                                ?>
                                </select>
                            </div>
                            <div class="form-group col-md-0">
                                    <input class="form-check-input" type="checkbox" id="check_producto">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-check-label">Stock</label>
                                <input type="number" id="stock" class="form-control" id="inputEmail4" disabled="true" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                
                                <label  class="form-check-label">(*)Equipo</label><br>
                            
                                <select name="idflota" id="Equipo" class="js-example-basic-single" style="width: 100%" >
                                    <option value="0">Buscar Equipo</option>
                                    <option value="1">SIN EQUIPO</option>
                                    <?php echo $almCont->select_combo("SELECT eu.id_equipounidad,eu.alias_equipounidad
                                        FROM equipos e
                                        INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
                                        WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_SESSION['unidad']} ) 
                                        AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1",
                                                0,1)?>
                                </select>
                              
                            </div>
                            <div class="form-group col-md-0">
                                    <input class="form-check-input" type="checkbox" id="check_equipo">
                            </div>
                            <div class="form-group col-md-2" id="div_horometro">
                                <label class="form-check-label">Horometro</label>
                                <input type="number" name="horometro" id="horometro" value="0" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-check-label">Motivo</label>
                                <input list="motivo_list" name="motivo" id="motivo" class="form-control" autocomplete="off" maxlength="5">
                                <datalist id="motivo_list">
                                    <option value="Desgaste">
                                    <option value="Vida util">
                                    <option value="Reparacion">
                                </datalist>
                            </div>
                   
                            <div class="form-group col-md-2">
                                <label class="form-check-label" >Cantidad</label>
                                <input type="number" id="Cantidad" value="1" class="form-control">
                            </div>
                        </div>
                   
                        <div class="form-row">
                            <div class="form-check">
                                <input  class="form-check-input" type="checkbox" id="cambio">
                                <label class="form-check-label" for="defaultCheck1">
                                    Entrega con cambio
                                </label>
                            </div>
                        </div>
                        <div id="msgmodal"></div>
                    </form>
                </div>
       
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnadd"class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>   
   
    <script src="../vistas/js/nvale_vs.js"></script>

    
</div>

