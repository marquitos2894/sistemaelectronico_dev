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

?>
    <input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />
    <input type="hidden" value="<?php echo $paginador ?>" id="paginador"/>
    <input type="hidden" value="<?php echo $vista ?>" id="vista"/>
    <input type="hidden" value="<?php echo $_SESSION['privilegio_sbp'] ?>" id="privilegio"/>
    <input type="hidden" value="<?php echo $_SESSION['almacen'] ?>" id="id_alm"/>

<div class="container-fluid">
    <?php  include "vistas/modulos/nav-almacen.php";?> 
    <div class="card">  
            <div class="card-header text-white bg-primary mb-3">
                Consulta kardex
            </div>
       
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-check-label" for="inputEmail4">Codigo</label>
                        <select name="codigo" id="codigo" style="width: 100%" class="js-example-basic-single">
                                <option value="0">Buscar producto</option>
                                <?php 
                                    echo $almCont->select_combo("SELECT ac.fk_idcomp,CONCAT(ac.fk_idcomp,' || ',c.descripcion,' || ',c.nparte1)
                                    FROM almacen_componente ac
                                    INNER JOIN componentes c
                                    ON c.id_comp = ac.fk_idcomp WHERE ac.fk_idalm = {$id_alm}
                                    group by ac.fk_idcomp",0,1);
                                ?>
                        </select>   
                    </div>
                    <div class="form-group col-md-auto">
                        <label  class="form-check-label" for="inputEmail4">Fecha inicio</label>                              
                        <input type="date"  name="fecha_inicio" class="form-control" id="fecha_ini">
                    </div>
                    <div class="form-group col-md-auto">
                        <label  class="form-check-label" for="inputEmail4">Fecha final</label>                              
                        <input type="date" name="fecha_final" class="form-control" id="fecha_fin">
                    </div>
                </div>
                <div class="form-row">
                    <button type="button" id="btnbuscar" class="btn btn-primary" aria-pressed="false">
                    <i class="fas fa-search"></i>Buscar
                    </button>
                </div>
                <div id="contenido_kardex" ></div>
            </div>
    </div>

</div>

<script src="../vistas/js/kardex.js"></script>