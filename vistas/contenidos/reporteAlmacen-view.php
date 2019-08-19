<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador();
      
      $id_alm = $_SESSION["almacen"];
      if($_SESSION["almacen"]==0 ){
        echo "<script> window.location.href = '../almacen/'; </script>";
      }
    
?>

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
            <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>reporteAlmacen" aria-disabled="true">Reportes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="#" aria-disabled="true">Import</a>
            </li>
    </ul><br>
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseValeSalida" aria-expanded="true" aria-controls="collapseValeSalida">
                    Reporte de vale de salida
                    </button>
                </h2>
            </div>
            <div id="collapseValeSalida" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Equipo</th>
                                    <th>Horometro</th>
                                    <th>Solicitado</th>
                                    <th>Atendido por</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Equipo</th>
                                    <th>Horometro</th>
                                    <th>Solicitado</th>
                                    <th>Atendido por</th>
                                    <th>Ver</th>
                                </tr>
                            </tfoot>
                            <tbody id="dtbody">
                                <?php echo $almCont->reporte_valesalida_simple_controlador(0,$id_alm,"vista_simple"); ?>
                            </tbody>
                        </table>
                    </div>
                </div>   
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseValeIngreso" aria-expanded="true" aria-controls="collapseValeIngreso">
                    Reporte de vale de ingreso
                    </button>
                </h2>
            </div>
            <div id="collapseValeIngreso" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Documento</th>
                                    <th>#Documento</th>
                                    <th>Remitente</th>
                                    <th>Registrado por</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Documento</th>
                                    <th>#Documento</th>
                                    <th>Remitente</th>
                                    <th>Registrado por</th>
                                    <th>Ver</th>
                                </tr>
                            </tfoot>
                            <tbody id="dtbody">
                                <?php echo $almCont->reporte_valeingreso_simple_controlador(0,$id_alm,"vista_simple"); ?>
                            </tbody>
                        </table>
                    </div>
                </div>   
            </div>
        </div>

    </div>    


</div>