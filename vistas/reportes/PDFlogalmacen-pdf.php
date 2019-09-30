<?php 
require_once "./core/configGeneral.php";
require_once "./controladores/almacenControlador.php";
$almCont = new almacenControlador();

$url = explode("/",$_GET["views"]);
$vista=$url[0];
$array=$_POST["datos_form"];
$datos=explode(",",$array);



//$date_ini = new DateTime($datos[3]);
//$date_fin = new DateTime($tipo[6]);
//$date_ini=$date_ini->format('d-m-Y');

$date_ini=$almCont->formato_fecha_hora("fecha",$datos[3]);
$date_fin=$almCont->formato_fecha_hora("fecha",$datos[4]);
$objDateTime = new DateTime('NOW');
$fecha=$almCont->formato_fecha_hora("fecha","NOW");
$hora=$almCont->formato_fecha_hora("hora","NOW");

$tipo = $_POST["tipo_form"];
$html='';

$html.='
<div id="company" class="clearfix">
<img src="'.SERVERURL.'/vistas/img/conmiciv.png">
</div>
<h1>Reporte historial de '.$_SESSION["nom_almacen"].' </h1>';

$html.=$almCont->paginador_log_in_out(0,10,$_SESSION['privilegio_sbp'],'',$vista,$_SESSION["almacen"],$_POST["tipo_form"],$_POST["datos_form"]);

$html.='
<footer>
    <div><span>Generado por </span>'.$_SESSION["nombre_sbp"].','.$_SESSION["apellido_sbp"].'</div>
</footer>';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>'A4']);

$css = file_get_contents(SERVERURL."vistas/css/PDFlogalmacen.css");
$mpdf->WriteHTML($css,1);

?>