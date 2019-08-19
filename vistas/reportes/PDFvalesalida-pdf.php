<?php 
require_once "./Core/configGeneral.php";
require_once './controladores/almacenControlador.php';
$almCont = new almacenControlador();
$url = explode("/",$_GET['views']);
$idvs=0;$idalm=0;
$SERVERURL=SERVERURL;
$html = "";

//$id_vsalida=mainModel::decryption($url[1]);
//$id_alm=mainModel::decryption($url[2]);

$id_vsalida=$url[1];
$id_alm=$url[2];

$html.= $almCont->reporte_valesalida_simple_controlador($id_vsalida,$id_alm,"ticket");


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>[115,350]]);

$css = file_get_contents(SERVERURL."vistas/css/valesalida.css");
$mpdf->WriteHTML($css,1);

?>