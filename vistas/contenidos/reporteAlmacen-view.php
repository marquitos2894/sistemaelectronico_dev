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
<input type="hidden" value="ambos" id="tipo_logalm"/>


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
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" href="#pills-historial"  aria-selected="false">Historial almacen</a>
            
        </li>
        <li class="nav-item">
            <a class="nav-link"  data-toggle="pill" href="#pills-vales" aria-selected="true">Vales</a>     
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active"  id="pills-historial" role="tabpanel" aria-labelledby="pills-vales-tab">
            <!-- INCIO -->
     
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Reporte de historial</h6>
                </div>
                <div class="card-body">
       
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                        </div>
                        <input type="search" class="form-control"  id="buscador_text" placeholder="Buscar" aria-label="Username" aria-describedby="basic-addon1">     
                        
                    </div>
                    
                    
                    <div id="log_in_out">
                        <!-- Se mostrara el log de ingresos y salidas-->
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputCity">Equipo</label>
                            <select id="equipo"  class="form-control">
                                <option value='0' selected>Seleccione Equipo</option>
                                <?php echo $almCont->select_combo("SELECT e.Id_Equipo,eu.alias_equipounidad
                                    FROM equipos e
                                    INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
                                    WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_SESSION['unidad']} ) 
                                    AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1",
                                            1,1)?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputState">Referencia</label>
                            <select id="referencia" class="chosen-select">
                                <option value='0' selected>Choose Ref..</option>
                                <?php echo $almCont->select_combo("SELECT * FROM datos_referencia",
                                            1,1)?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fec_ini">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Fecha Final</label>
                            <input type="date" class="form-control" id="fec_fin">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">.</label>   
                            <input type="button" id='btnFiltrar' value="Filtrar" class="form-control btn btn-warning"/>
                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>
                </div>
            </div>
            <!-- FIN -->
        </div>

        <div class="tab-pane fade" id="pills-vales" role="tabpanel" aria-labelledby="pills-vales-tab">
            <!-- INCIO -->

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Vales de ingreso/salida</h6>
                </div>
                <div class="card-body">
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
                </div>
            </div> 
            <!-- FIN -->
        </div>
        
    </div>
   
    <script src="../vistas/js/reporteAlmacen.js"></script>

</div>