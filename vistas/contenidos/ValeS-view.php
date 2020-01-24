
<?php 
    require_once "./controladores/almacenControlador.php";
    $almCont = new almacenControlador(); 
      
    $pagina = explode("/",$_GET['views']);
      
    $url = explode("/",$_GET["views"]);
    $paginador = $url[1];
    $vista=$url[0];

   echo $id_alm = $_SESSION["almacen"];

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
        <li class="nav-item">
            <a class="nav-link " href="<?php echo SERVERURL;?>reporteAlmacen/" aria-disabled="true">Reportes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link "  aria-disabled="true">Import</a>
        </li>
    </ul><br>


        
    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>
            
            <select class="js-example-basic-single" name="state" style="width: 100%">
                <option value="">Seleccionar</option>
                        <?php 
                            echo $almCont->select_combo("SELECT CONCAT(c.id_comp,'|',c.descripcion,'|',c.nparte1,'|',
                            ac.u_nombre,'-',ac.u_seccion,'|',eu.alias_equipounidad,'|',ac.Referencia,'|',c.nserie) as item, ac.id_ac
                             FROM componentes c
                             INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
                             INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
                             INNER JOIN equipo_unidad eu ON eu.fk_idequipo = ac.fk_idflota
                             INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria 
                            WHERE ac.est = 1 and ac.fk_idalm = {$id_alm}",1,0);
                            ?>
            </select>
        </div>
    </div>

    
    <form action="<?php echo SERVERURL;?>ajax/almacenAjax.php"  id="formVS" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
        <div id="productosCarrito">
                        <!-- item de local storage para salida del almacen-->
        </div>
        <div id="alert2"></div>
        <h4><p style="text-align:center;" ><a  href="#" id="varciarCarrito">Vaciar carrito</a></p></h4> 
        <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_sbp'];?>"/>
        
        <div class="RespuestaAjax"></div>
    </form>

    <div class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="inputEmail4">Productos</label><br>
                        <select class="js-example-basic-single" style="width: 100%" name="state">
                            <option value="">Seleccionar</option>
                                    <?php 
                                        echo $almCont->select_combo("SELECT CONCAT(c.id_comp,' |',c.descripcion,' |',c.nparte1,' |',
                                        ac.u_nombre,'-',ac.u_seccion,' |',eu.alias_equipounidad,' |',ac.Referencia,' |',c.nserie) as item, ac.id_ac
                                         FROM componentes c
                                         INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
                                         INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
                                         INNER JOIN equipo_unidad eu ON eu.fk_idequipo = ac.fk_idflota
                                         INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria 
                                        WHERE ac.est = 1 and ac.fk_idalm = {$id_alm}",1,0);
                                        ?>
                        </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputPassword4">Equipo</label><br>
                            <select name="codequipo" class="js-example-basic-single" style="width: 100%" >
                                <option value="1">SIN EQUIPO</option>
                                <?php echo $almCont->select_combo("SELECT eu.id_equipounidad,eu.alias_equipounidad
                                    FROM equipos e
                                    INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
                                    WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_SESSION['unidad']} ) 
                                    AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1",
                                            0,1)?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail4">Stock</label>
                            <input type="number" class="form-control" id="inputEmail4">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputPassword4">Cantidad</label>
                            <input type="number" class="form-control" id="inputPassword4">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Entrega de cambio
                            </label>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>   
   
    <script src="../vistas/js/nvale_vs.js"></script>


</div>

