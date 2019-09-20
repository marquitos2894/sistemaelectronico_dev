<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador();
      
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
            <a class="nav-link" href="<?php echo SERVERURL;?>RValeIngreso/">Vale de ingreso</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="<?php echo SERVERURL;?>ingresoAlmacen/" aria-disabled="true">Ingreso Almacen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>reporteAlmacen/" aria-disabled="true">Reportes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="" aria-disabled="true">Import</a>
            </li>
    </ul><br>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-vales" role="tab" aria-controls="pills-vales" aria-selected="true">Vales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-historial-tab" data-toggle="pill" href="#pills-historial" role="tab" aria-controls="pills-historial" aria-selected="false">Historial almacen</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-vales" role="tabpanel" aria-labelledby="pills-vales-tab">
            <!-- INCIO -->
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
                                            <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                            <th>Cancel</th>
                                            <?php endif;?>
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
                                            <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                            <th>Cancel</th>
                                            <?php endif;?>
                                        </tr>
                                    </tfoot>
                                    <tbody id="dtbody">
                                        <?php echo $almCont->reporte_valesalida_simple_controlador(0,$id_alm,"vista_simple",$_SESSION['privilegio_sbp']); ?>
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
                                            <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                            <th>Cancel</th>
                                            <?php endif;?>
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
                                            <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                            <th>Cancel</th>
                                            <?php endif;?>
                                        </tr>
                                    </tfoot>
                                    <tbody id="dtbody">
                                        <?php echo $almCont->reporte_valeingreso_simple_controlador(0,$id_alm,"vista_simple",$_SESSION['privilegio_sbp']); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>   
                    </div>
                </div>

            </div> 
            <!-- FIN -->
        </div>
        <div class="tab-pane fade" id="pills-historial" role="tabpanel" aria-labelledby="pills-historial-tab">
            <!-- INCIO -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Buscar</span>
                </div>
                <input type="search" class="form-control"  id="buscador_text" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">     
            </div>
            <div id="log_in_out">
                <!-- Se mostrara el log de ingresos y salidas-->
            </div>
             <!-- FIN -->
             <div class="RespuestaAjax"></div>
        </div>
        
    </div>
   
    <script src="../vistas/js/reporteAlmacen.js"></script>

</div>