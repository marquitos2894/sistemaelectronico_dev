<?php 


      $id_alm = $_SESSION["almacen"];
      if($_SESSION["almacen"]==0 ){
        echo "<script> window.location.href = '../almacen/'; </script>";
      }


?>

<div class="container-fluid">
    <?php  include "vistas/modulos/nav-almacen.php";?> 
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="<?php echo SERVERURL;?>componentes/">Almacen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SERVERURL;?>RValeSalida/">Vale salida</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SERVERURL;?>RValeIngreso/">Vale de ingreso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo SERVERURL;?>newcomponente/">+Nuevo componente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" aria-disabled="true">Reportes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="#" aria-disabled="true">Import</a>
            </li>
    </ul><br>
    <form action="<?php echo SERVERURL;?>ajax/componentesAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
    <div class="card border-primary mb-3">
            <div class="card-body text-primary">
                <h4 class="card-title">Datos del componente</h4>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6 text-primary">
                        <label for="inputAddress">Descripcion</label>
                        <input type="text" name="descripcion" class="form-control " id="inputAddress" placeholder="Nombre del componente">
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                    <label for="inputEmail4">Nparte</label>
                    <input type="text" name="nparte1" class="form-control" id="inputEmail4" placeholder="Nparte">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Nparte 2</label>
                    <input type="text" name="nparte2" class="form-control" id="inputPassword4" placeholder="Nparte 2">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Nparte 3</label>
                    <input type="text" name="nparte3" class="form-control" id="inputPassword4" placeholder="Nparte 3">
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-4">
                    <label for="inputEmail4">Marca</label>
                    <input type="text" name="marca" class="form-control" id="inputEmail4" placeholder="Marca">
                    </div>
                    <!--div class="form-group col-sm-4">
                    <label for="inputPassword4">Tipo</label>
                    <input type="text" name="tipo" class="form-control" id="inputPassword4" placeholder="Tipo de repuesto">
                    </div-->
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                    <label for="inputEmail4">Unidad de medida</label>
                    <input type="text" name="unidad_med" class="form-control" id="inputEmail4" placeholder="Unidad de medida">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Medida</label>
                    <input type="text" name="medida" class="form-control" id="inputPassword4" placeholder="Medida">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                    <input type="checkbox" name="control_stock" class="form-check-input"  id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Control de stock
                    </label>
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                    <label for="inputEmail4">Stock Min.</label>
                    <input type="text" name="stock_min"  class="form-control" id="inputEmail4" placeholder="Stock minimo">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Stock Max.</label>
                    <input type="text" name="stock_max" class="form-control" id="inputPassword4" placeholder="Stock Maximo">
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
        <div class="RespuestaAjax"></div>
    </form>

</div>