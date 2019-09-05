
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
            <li class="nav-item">
                <a class="nav-link " href="<?php echo SERVERURL;?>reporteAlmacen/" aria-disabled="true">Reportes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  aria-disabled="true">Import</a>
            </li>
        </ul><br>

        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Detalle de componentes
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                        </div>
                        <input type="search" class="form-control"  id="buscador_comp_text" placeholder="Buscar componente" aria-label="Username" aria-describedby="basic-addon1">
                         
                    </div>
                    <div id="catalogo"></div> 
                     
                    
                </div>
            </div>
            <form action="<?php echo SERVERURL;?>ajax/almacenAjax.php"  method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
                <div id="productosCarrito">
                                <!-- item de local storage para salida del almacen-->
                </div>
                <h4><p style="text-align:center;" ><a  href="#" id="varciarCarrito">Vaciar carrito</a></p></h4> 
                <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_sbp'];?>"/>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#Productos" aria-expanded="false" aria-controls="collapseTwo">
                            Datos de vale de salida
                            </button>
                        </h2>
                    </div>
                    
                    <div id="Productos" >                    
                        <div class="card-body">
                            <div class="card-deck">
                                <div class="card">
                                    <div class="card-header">
                                        Receptor
                                    </div>
                                    <div class="card-body">
                                        <blockquote >
                                            <div class="form-row">                                  
                                                <div class="form-group col-8"> 
                                                    <label for="inputEmail4">Solicitado por</label>                              
                                                    <select data-placeholder="Seleccione personal" name="personal" class="chosen-select" >
                                                        <option value=""></option>
                                                        <?php 
                                                           echo $almCont->select_combo("select p.id_per, concat(p.Nom_per,' ',p.Ape_per)
                                                           from personal p where idunidad = {$_SESSION['unidad']} AND est = 1",0,1);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-10" style="display:none"> 
                                                    <label for="inputEmail4">Turno</label>                              
                                                    <select class="form-control" name="turno">
                                                        <option>Seleccione</option><option value="dia">Dia</option><option value="noche">Noche</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        Datos equipo
                                    </div>
                                    <div class="card-body">
                                        <blockquote class="">
                                            <div class="form-row">                                  
                                                <div class="form-group col-10"> 
                                                    <label for="inputEmail4">Cod. Equipo</label>                              
                                                    <select name="codequipo" class="chosen-select" >
                                                        <option value="1">SIN EQUIPO</option>
                                                        <?php echo $almCont->select_combo("SELECT e.Id_Equipo,eu.alias_equipounidad
                                                            FROM equipos e
                                                            INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
                                                            WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_SESSION['unidad']} ) 
                                                            AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1",
                                                                 0,1)?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-10"> 
                                                    <label for="inputEmail4">Horometro</label>                              
                                                    <input type="number" name="horometro" class="form-control"  placeholder="Horometro">
                                                </div>
                                                <div class="form-group col-10"> 
                                                    <label for="inputEmail4">Datos referencia</label>                              
                                                    <select name="datos_referencia_vale_salida" data-placeholder="#Sin especificar"  class="chosen-select" >
                                                        <option value="#Sin especificar">#Sin especificar</option>
                                                        <?php echo $almCont->combo_DR(1,1)?>
                                                    </select>
                                                </div>
 
                                            </div>
                        
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Comentario de salida de los repuestos</label>
                                    <textarea  name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <input type="hidden"  name="privilegio_sbp_vs" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
                            <input type="hidden"  name="vale" value="valesalida"/>
                            <input type="hidden"  name="id_alm_vs" id="id_alm_vs" value="<?php echo $id_alm ?>"/>
                            <button type="submit" id="btnvale" class="btn btn-danger btn-lg btn-block" disabled='true' >Emitir Vale de salida</button>
                        </div>
                    </div>
                </div>
                <div class="RespuestaAjax"></div>
            </form>
        </div>
    <script src="../vistas/js/carrito.js"></script>
</div>

