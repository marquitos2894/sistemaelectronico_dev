<?php 
require_once "./core/configGeneral.php";
require_once "./controladores/almacenControlador.php";
$almCont = new almacenControlador();

$url = explode("/",$_GET["views"]);
$vista=$url[0];
$array=$_POST["datos_form"];
$tipo = $_POST["tipo_form"];

$html='';

$html.=$almCont->paginador_log_in_out(0,10,$_SESSION['privilegio_sbp'],'',$vista,$_SESSION["almacen"],$_POST["tipo_form"],$_POST["datos_form"]);


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>'A4']);

$css = file_get_contents(SERVERURL."vistas/css/valeingreso.css");
$mpdf->WriteHTML($css,1);

?>