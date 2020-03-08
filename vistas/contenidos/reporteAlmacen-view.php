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
<input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />
<input type="hidden" value="<?php echo $paginador ?>" id="paginador"/>
<input type="hidden" value="<?php echo $vista ?>" id="vista"/>
<input type="hidden" value="<?php echo $_SESSION['privilegio_sbp'] ?>" id="privilegio"/>
<input type="hidden" value="<?php echo $_SESSION['almacen'] ?>" id="id_alm"/>
<input type="hidden" value="ambos" id="tipo_logalm"/>     

<div class="container-fluid">
    <?php  include "vistas/modulos/nav-almacen.php";?> 
    <br>
    

    <div class="tab-content" id="pills-tabContent">

    
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
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Desactivar/Activar Filtros</label>
                    </div>
                    
                    <div class="form-row">
                    <div class="form-group col-md-2">
                            <label for="inputZip">codigo</label>
                            <input type="text" class="form-control" id="codigo" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCity">Equipo</label>
                            <select id="equipo"  class="form-control" disabled>
                                <option value='' selected>Seleccione Equipo</option>
                                <?php echo $almCont->select_combo("SELECT e.Id_Equipo,eu.alias_equipounidad
                                    FROM equipos e
                                    INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
                                    WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_SESSION['unidad']} ) 
                                    AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1",
                                            0,1)?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputState">Referencia</label>
                            <select id="referencia" class="chosen-select">
                                <option value='' selected>Buscar Ref..</option>
                                <option value="#Sin especificar">#Sin especificar</option>
                                                        <?php echo $almCont->combo_DR(1,1)?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fec_ini" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Fecha Final</label>
                            <input type="date" class="form-control" id="fec_fin" disabled>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">.</label>   
                            <input type="button" id='btnFiltrar' value="Filtrar" class="form-control btn btn-warning" disabled/>
                        </div>
                    </div>
                    <div id='alert'></div>
                    <form id='formReporte_log' method='POST' action='../PDFlogalmacen'>
                        <input type='hidden' id='tipo_form' value='ambos' name='tipo_form'/>
                        <input type='hidden' id='datos_form' name='datos_form'/>
                        <input type='submit' id='btnreport' formtarget="_blank" value="Generar reporte PDF" class="btn btn-primary" disabled/>
                    </form>
                </div>
            </div>
            <!-- FIN -->
     
        
    </div>
   
    <script src="../vistas/js/reporteAlmacen.js"></script>

</div>