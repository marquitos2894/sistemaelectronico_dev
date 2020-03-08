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
    <div class="card">
        <div class="card-header text-white bg-primary mb-3">
            Reporte de comprobantes de ingresos / salidas
        </div>
        <div class="card-body">
            
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Vale salida</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Vale ingreso</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Despacho</th>
                                    <th>Solicitado</th>
                                    <th>Atendido por</th>
                                    <th>Ver</th>
                                    <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                    <th>Anular</th>
                                    <?php endif;?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>#Vale</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Despacho</th>
                                    <th>Solicitado</th>
                                    <th>Atendido por</th>
                                    <th>Ver</th>
                                    <?php if($_SESSION['privilegio_sbp']==0 or $_SESSION['privilegio_sbp']==1): ?>
                                    <th>Anular</th>
                                    <?php endif;?>
                                </tr>
                            </tfoot>
                            <tbody id="dtbody">
                                <?php echo $almCont->reporte_valesalida_simple_controlador(0,$id_alm,"vista_simple",$_SESSION['privilegio_sbp']); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
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